@extends('layouts.admin')

@section('page_title')
    Support Tickets
@stop

@section('content')
    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>Support Tickets</h1>
            </div>
            <div class="page-action">
                <a href="{{ route('admin.support.tickets.create') }}" class="btn btn-primary">
                    Create Ticket
                </a>
            </div>
        </div>

        <div class="page-content">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="filters mb-4">
                <form method="GET" action="{{ route('admin.support.tickets.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="priority" class="form-control">
                                <option value="">All Priorities</option>
                                @foreach($priorities as $priority)
                                    <option value="{{ $priority->id }}" {{ request('priority') == $priority->id ? 'selected' : '' }}>
                                        {{ $priority->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="category" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('admin.support.tickets.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Ticket #</th>
                            <th>Subject</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Category</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td><input type="checkbox" name="ticket_ids[]" value="{{ $ticket->id }}"></td>
                                <td>{{ $ticket->ticket_number }}</td>
                                <td>
                                    <a href="{{ route('admin.support.tickets.show', $ticket->id) }}">
                                        {{ $ticket->subject }}
                                    </a>
                                </td>
                                <td>{{ $ticket->customer_name }}</td>
                                <td>
                                    <span class="badge" style="background-color: {{ $ticket->status->color }}">
                                        {{ $ticket->status->name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: {{ $ticket->priority->color }}">
                                        {{ $ticket->priority->name }}
                                    </span>
                                </td>
                                <td>{{ $ticket->category->name }}</td>
                                <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.support.tickets.edit', $ticket->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $tickets->links() }}
        </div>
    </div>
@stop
