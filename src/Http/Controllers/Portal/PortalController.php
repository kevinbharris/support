<?php

namespace KevinBHarris\Support\Http\Controllers\Portal;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use KevinBHarris\Support\Models\Ticket;
use KevinBHarris\Support\Models\Status;
use KevinBHarris\Support\Models\Priority;
use KevinBHarris\Support\Models\Category;
use KevinBHarris\Support\Models\Note;
use KevinBHarris\Support\Events\TicketCreated;
use KevinBHarris\Support\Events\NoteAdded;

class PortalController extends Controller
{
    public function submitTicket(Request $request)
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:support_categories,id',
        ];

        // Add ReCaptcha validation if enabled
        if (config('support.recaptcha_enabled') && config('support.recaptcha_site_key')) {
            $rules['g-recaptcha-response'] = 'required';
        }

        $validated = $request->validate($rules);

        // Get default status and priority
        $defaultStatus = Status::where('code', 'new')->first() ?? Status::first();
        $defaultPriority = Priority::where('code', 'medium')->first() ?? Priority::first();

        $ticket = Ticket::create([
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'category_id' => $validated['category_id'],
            'status_id' => $defaultStatus->id,
            'priority_id' => $defaultPriority->id,
        ]);

        $ticket->calculateSlaDue();
        $ticket->save();

        event(new TicketCreated($ticket));

        return redirect()->route('support.portal.show', $ticket->access_token)
            ->with('success', 'Your ticket has been submitted successfully!');
    }

    public function show($token)
    {
        $ticket = Ticket::where('access_token', $token)
            ->with(['status', 'priority', 'category', 'notes' => function ($query) {
                $query->where('is_internal', false)->orderBy('created_at', 'asc');
            }])
            ->firstOrFail();

        return view('support::portal.show', compact('ticket'));
    }

    public function reply(Request $request, $token)
    {
        $ticket = Ticket::where('access_token', $token)->firstOrFail();

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $note = Note::create([
            'ticket_id' => $ticket->id,
            'content' => $validated['content'],
            'is_internal' => false,
            'created_by' => null,
            'created_by_name' => $ticket->customer_name,
        ]);

        event(new NoteAdded($note));

        return back()->with('success', 'Your reply has been added successfully!');
    }
}
