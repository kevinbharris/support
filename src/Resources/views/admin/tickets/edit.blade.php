@extends('admin::layouts.master')

@section('page_title')
    Edit Ticket
@stop

@section('content-wrapper')
    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>Edit Ticket #{{ $ticket->ticket_number }}</h1>
            </div>
        </div>

        <div class="page-content">
            <form action="{{ route('admin.support.tickets.update', $ticket->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="subject">Subject *</label>
                    <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject', $ticket->subject) }}" required>
                    @error('subject')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status_id">Status *</label>
                    <select name="status_id" id="status_id" class="form-control" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id', $ticket->status_id) == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="priority_id">Priority *</label>
                    <select name="priority_id" id="priority_id" class="form-control" required>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->id }}" {{ old('priority_id', $ticket->priority_id) == $priority->id ? 'selected' : '' }}>
                                {{ $priority->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('priority_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Category *</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $ticket->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="assigned_to">Assign To</label>
                    <input type="number" name="assigned_to" id="assigned_to" class="form-control" value="{{ old('assigned_to', $ticket->assigned_to) }}">
                    @error('assigned_to')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Ticket</button>
                <a href="{{ route('admin.support.tickets.show', $ticket->id) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
