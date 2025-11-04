@extends('admin::layouts.master')

@section('page_title')
    Create Ticket
@stop

@section('content-wrapper')
    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>Create Ticket</h1>
            </div>
        </div>

        <div class="page-content">
            <form action="{{ route('admin.support.tickets.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="customer_name">Customer Name *</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                    @error('customer_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="customer_email">Customer Email *</label>
                    <input type="email" name="customer_email" id="customer_email" class="form-control" value="{{ old('customer_email') }}" required>
                    @error('customer_email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subject">Subject *</label>
                    <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" required>
                    @error('subject')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status_id">Status *</label>
                    <select name="status_id" id="status_id" class="form-control" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
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
                            <option value="{{ $priority->id }}" {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
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
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                    <input type="number" name="assigned_to" id="assigned_to" class="form-control" value="{{ old('assigned_to') }}">
                    @error('assigned_to')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Create Ticket</button>
                <a href="{{ route('admin.support.tickets.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
