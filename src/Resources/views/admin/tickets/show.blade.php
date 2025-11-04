@extends('layouts.admin')

@section('page_title')
    Ticket #{{ $ticket->ticket_number }}
@stop

@section('content')
    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>Ticket #{{ $ticket->ticket_number }}</h1>
            </div>
            <div class="page-action">
                <a href="{{ route('admin.support.tickets.edit', $ticket->id) }}" class="btn btn-primary">
                    Edit Ticket
                </a>
            </div>
        </div>

        <div class="page-content">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3>{{ $ticket->subject }}</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Customer:</strong> {{ $ticket->customer_name }} ({{ $ticket->customer_email }})</p>
                            <p><strong>Status:</strong> 
                                <span class="badge" style="background-color: {{ $ticket->status->color }}">
                                    {{ $ticket->status->name }}
                                </span>
                            </p>
                            <p><strong>Priority:</strong> 
                                <span class="badge" style="background-color: {{ $ticket->priority->color }}">
                                    {{ $ticket->priority->name }}
                                </span>
                            </p>
                            <p><strong>Category:</strong> {{ $ticket->category->name }}</p>
                            <p><strong>Created:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}</p>
                            @if($ticket->sla_due_at)
                                <p><strong>SLA Due:</strong> 
                                    <span class="{{ $ticket->isOverdue() ? 'text-danger' : 'text-success' }}">
                                        {{ $ticket->sla_due_at->format('Y-m-d H:i') }}
                                        @if($ticket->isOverdue())
                                            (OVERDUE)
                                        @endif
                                    </span>
                                </p>
                            @endif
                            <hr>
                            <h4>Description</h4>
                            <p>{{ $ticket->description }}</p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Notes & Replies</h4>
                        </div>
                        <div class="card-body">
                            @foreach($ticket->notes as $note)
                                <div class="note mb-3 p-3 {{ $note->is_internal ? 'bg-warning' : 'bg-light' }}">
                                    <div class="note-header mb-2">
                                        <strong>{{ $note->created_by_name }}</strong>
                                        @if($note->is_internal)
                                            <span class="badge badge-warning">Internal</span>
                                        @endif
                                        <span class="text-muted float-right">{{ $note->created_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    <div class="note-content">
                                        {{ $note->content }}
                                    </div>
                                    @if($note->attachments->count() > 0)
                                        <div class="attachments mt-2">
                                            <strong>Attachments:</strong>
                                            @foreach($note->attachments as $attachment)
                                                <div>{{ $attachment->name }}</div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            <hr>

                            <form action="{{ route('admin.support.tickets.notes.add', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Add Note</label>
                                    <textarea name="content" class="form-control" rows="4" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="is_internal" value="1">
                                        Internal Note (not visible to customer)
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Attachments</label>
                                    <input type="file" name="attachments[]" class="form-control" multiple>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Note</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4>Watchers</h4>
                        </div>
                        <div class="card-body">
                            @foreach($ticket->watchers as $watcher)
                                <div class="watcher mb-2">
                                    {{ $watcher->name ?? $watcher->email }}
                                    <form action="{{ route('admin.support.tickets.watchers.remove', [$ticket->id, $watcher->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                    </form>
                                </div>
                            @endforeach

                            <hr>

                            <form action="{{ route('admin.support.tickets.watchers.add', $ticket->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Name (optional)">
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Add Watcher</button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Activity Log</h4>
                        </div>
                        <div class="card-body">
                            @foreach($ticket->activityLogs as $log)
                                <div class="activity-log mb-2">
                                    <small class="text-muted">{{ $log->created_at->format('Y-m-d H:i') }}</small>
                                    <br>
                                    <strong>{{ $log->action }}</strong>: {{ $log->description }}
                                    @if($log->user_name)
                                        by {{ $log->user_name }}
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
