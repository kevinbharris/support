{{-- 
    Example Blade Template Snippet for ACL Integration
    
    This file demonstrates how to use ACL permissions in Blade templates.
    Copy these patterns to your actual view files.
--}}

{{-- Example 1: Show/Hide Create Button --}}
@can('create', \KevinBHarris\Support\Models\Ticket::class)
    <a href="{{ route('admin.support.tickets.create') }}" class="btn btn-primary">
        <i class="icon-plus"></i> Create New Ticket
    </a>
@endcan

{{-- Example 2: Show/Hide Edit Button --}}
@can('update', $ticket)
    <a href="{{ route('admin.support.tickets.edit', $ticket->id) }}" class="btn btn-secondary">
        <i class="icon-edit"></i> Edit
    </a>
@endcan

{{-- Example 3: Show/Hide Delete Button --}}
@can('delete', $ticket)
    <form action="{{ route('admin.support.tickets.destroy', $ticket->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
            <i class="icon-trash"></i> Delete
        </button>
    </form>
@endcan

{{-- Example 4: Using hasPermission Helper --}}
@if(auth()->user()->hasPermission('support.tickets.assign'))
    <div class="assign-section">
        <form action="{{ route('admin.support.tickets.assign', $ticket->id) }}" method="POST">
            @csrf
            <select name="assigned_to" class="form-control">
                <option value="">Select Agent...</option>
                {{-- Agent options here --}}
            </select>
            <button type="submit" class="btn btn-primary">Assign</button>
        </form>
    </div>
@endif

{{-- Example 5: Using Gate Facade --}}
@if(Gate::allows('support.tickets.notes'))
    <div class="notes-section">
        <h3>Add Note</h3>
        <form action="{{ route('admin.support.tickets.notes.add', $ticket->id) }}" method="POST">
            @csrf
            <textarea name="content" class="form-control" rows="4"></textarea>
            <label>
                <input type="checkbox" name="is_internal" value="1"> Internal Note
            </label>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>
@endif

{{-- Example 6: Multiple Permission Check --}}
@if(auth()->user()->hasPermission('support.tickets.view') && auth()->user()->hasPermission('support.tickets.update'))
    <div class="bulk-actions">
        <select name="bulk_action" class="form-control">
            <option value="">Bulk Actions...</option>
            @can('update', \KevinBHarris\Support\Models\Ticket::class)
                <option value="update_status">Update Status</option>
                <option value="update_priority">Update Priority</option>
            @endcan
            @can('delete', \KevinBHarris\Support\Models\Ticket::class)
                <option value="delete">Delete Selected</option>
            @endcan
        </select>
    </div>
@endif

{{-- Example 7: Navigation Menu with Permissions --}}
<ul class="nav">
    @if(auth()->user()->hasPermission('support.tickets.view'))
        <li>
            <a href="{{ route('admin.support.tickets.index') }}">
                <i class="icon-ticket"></i> Tickets
            </a>
        </li>
    @endif
    
    @if(auth()->user()->hasPermission('support.statuses.view'))
        <li>
            <a href="{{ route('admin.support.statuses.index') }}">
                <i class="icon-statuses"></i> Statuses
            </a>
        </li>
    @endif
    
    @if(auth()->user()->hasPermission('support.categories.view'))
        <li>
            <a href="{{ route('admin.support.categories.index') }}">
                <i class="icon-categories"></i> Categories
            </a>
        </li>
    @endif
</ul>

{{-- Example 8: Table Action Column --}}
<td class="actions">
    @can('view', $ticket)
        <a href="{{ route('admin.support.tickets.show', $ticket->id) }}" 
           class="btn btn-sm btn-info" 
           title="View">
            <i class="icon-eye"></i>
        </a>
    @endcan
    
    @can('update', $ticket)
        <a href="{{ route('admin.support.tickets.edit', $ticket->id) }}" 
           class="btn btn-sm btn-primary" 
           title="Edit">
            <i class="icon-edit"></i>
        </a>
    @endcan
    
    @can('delete', $ticket)
        <form action="{{ route('admin.support.tickets.destroy', $ticket->id) }}" 
              method="POST" 
              style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="btn btn-sm btn-danger" 
                    title="Delete"
                    onclick="return confirm('Are you sure you want to delete this ticket?')">
                <i class="icon-trash"></i>
            </button>
        </form>
    @endcan
</td>

{{-- Example 9: Conditional Section Rendering --}}
@canany(['create', 'update', 'delete'], \KevinBHarris\Support\Models\Ticket::class)
    <div class="admin-actions">
        <h3>Administrative Actions</h3>
        {{-- Show admin-only features here --}}
    </div>
@endcanany

{{-- Example 10: Unless (Inverse Permission Check) --}}
@cannot('delete', $ticket)
    <p class="text-muted">
        <i class="icon-lock"></i> You don't have permission to delete this ticket.
    </p>
@endcannot
