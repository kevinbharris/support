<?php

namespace KevinBHarris\Support\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use KevinBHarris\Support\Models\Ticket;
use KevinBHarris\Support\Models\Status;
use KevinBHarris\Support\Models\Priority;
use KevinBHarris\Support\Models\Category;
use KevinBHarris\Support\Models\Note;
use KevinBHarris\Support\Models\Watcher;
use KevinBHarris\Support\Models\ActivityLog;
use KevinBHarris\Support\Events\TicketCreated;
use KevinBHarris\Support\Events\TicketUpdated;
use KevinBHarris\Support\Events\NoteAdded;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['status', 'priority', 'category'])
            ->orderBy('created_at', 'desc');

        // Filters
        if ($request->has('status')) {
            $query->where('status_id', $request->status);
        }
        if ($request->has('priority')) {
            $query->where('priority_id', $request->priority);
        }
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('ticket_number', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_email', 'like', '%' . $request->search . '%');
            });
        }

        $tickets = $query->paginate(20);
        $statuses = Status::where('is_active', true)->get();
        $priorities = Priority::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();

        return view('support::admin.tickets.index', compact('tickets', 'statuses', 'priorities', 'categories'));
    }

    public function create()
    {
        $statuses = Status::where('is_active', true)->orderBy('sort_order')->get();
        $priorities = Priority::where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('support::admin.tickets.create', compact('statuses', 'priorities', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'status_id' => 'required|exists:support_statuses,id',
            'priority_id' => 'required|exists:support_priorities,id',
            'category_id' => 'required|exists:support_categories,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'assigned_to' => 'nullable|integer',
        ]);

        $ticket = Ticket::create($validated);
        $ticket->calculateSlaDue();
        $ticket->save();

        ActivityLog::create([
            'ticket_id' => $ticket->id,
            'action' => 'created',
            'description' => 'Ticket created',
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'System',
        ]);

        event(new TicketCreated($ticket));

        return redirect()->route('admin.support.tickets.show', $ticket->id)
            ->with('success', 'Ticket created successfully.');
    }

    public function show($id)
    {
        $ticket = Ticket::with([
            'status',
            'priority',
            'category',
            'notes.attachments',
            'attachments',
            'watchers',
            'activityLogs'
        ])->findOrFail($id);

        return view('support::admin.tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $statuses = Status::where('is_active', true)->orderBy('sort_order')->get();
        $priorities = Priority::where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('support::admin.tickets.edit', compact('ticket', 'statuses', 'priorities', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'status_id' => 'required|exists:support_statuses,id',
            'priority_id' => 'required|exists:support_priorities,id',
            'category_id' => 'required|exists:support_categories,id',
            'assigned_to' => 'nullable|integer',
        ]);

        $changes = [];
        $oldStatus = $ticket->status->name;
        $oldPriority = $ticket->priority->name;

        $ticket->update($validated);

        if ($ticket->status->name !== $oldStatus) {
            $changes['Status'] = "{$oldStatus} → {$ticket->status->name}";
        }
        if ($ticket->priority->name !== $oldPriority) {
            $changes['Priority'] = "{$oldPriority} → {$ticket->priority->name}";
        }

        if (!empty($changes)) {
            ActivityLog::create([
                'ticket_id' => $ticket->id,
                'action' => 'updated',
                'description' => 'Ticket updated',
                'properties' => $changes,
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name ?? 'System',
            ]);

            event(new TicketUpdated($ticket, $changes));
        }

        return redirect()->route('admin.support.tickets.show', $ticket->id)
            ->with('success', 'Ticket updated successfully.');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('admin.support.tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }

    public function addNote(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'content' => 'required|string',
            'is_internal' => 'boolean',
        ]);

        $note = Note::create([
            'ticket_id' => $ticket->id,
            'content' => $validated['content'],
            'is_internal' => $validated['is_internal'] ?? false,
            'created_by' => auth()->id(),
            'created_by_name' => auth()->user()->name ?? 'System',
        ]);

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store(config('support.attachments.storage_path'));
                
                $note->attachments()->create([
                    'name' => $file->getClientOriginalName(),
                    'filename' => $file->hashName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'path' => $path,
                ]);
            }
        }

        if ($ticket->first_response_at === null) {
            $ticket->first_response_at = now();
            $ticket->save();
        }

        ActivityLog::create([
            'ticket_id' => $ticket->id,
            'action' => 'note_added',
            'description' => ($validated['is_internal'] ?? false) ? 'Internal note added' : 'Public note added',
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'System',
        ]);

        event(new NoteAdded($note));

        return back()->with('success', 'Note added successfully.');
    }

    public function assign(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'assigned_to' => 'required|integer',
        ]);

        $ticket->assigned_to = $validated['assigned_to'];
        $ticket->save();

        ActivityLog::create([
            'ticket_id' => $ticket->id,
            'action' => 'assigned',
            'description' => 'Ticket assigned',
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'System',
        ]);

        return back()->with('success', 'Ticket assigned successfully.');
    }

    public function addWatcher(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'nullable|string',
        ]);

        Watcher::create([
            'ticket_id' => $ticket->id,
            'email' => $validated['email'],
            'name' => $validated['name'] ?? null,
        ]);

        return back()->with('success', 'Watcher added successfully.');
    }

    public function removeWatcher($id, $watcherId)
    {
        $watcher = Watcher::where('ticket_id', $id)
            ->where('id', $watcherId)
            ->firstOrFail();

        $watcher->delete();

        return back()->with('success', 'Watcher removed successfully.');
    }

    public function bulk(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete,update_status,update_priority,assign',
            'ticket_ids' => 'required|array',
            'value' => 'nullable',
        ]);

        $tickets = Ticket::whereIn('id', $validated['ticket_ids'])->get();

        foreach ($tickets as $ticket) {
            switch ($validated['action']) {
                case 'delete':
                    $ticket->delete();
                    break;
                case 'update_status':
                    $ticket->update(['status_id' => $validated['value']]);
                    break;
                case 'update_priority':
                    $ticket->update(['priority_id' => $validated['value']]);
                    break;
                case 'assign':
                    $ticket->update(['assigned_to' => $validated['value']]);
                    break;
            }
        }

        return back()->with('success', 'Bulk action completed successfully.');
    }
}
