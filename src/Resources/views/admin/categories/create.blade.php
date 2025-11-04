@extends('layouts.admin)

@section('page_title')
    Create Status
@stop

@section('content')
    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>Create Status</h1>
            </div>
        </div>

        <div class="page-content">
            <form action="{{ route('admin.support.statuses.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Name *</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Code *</label>
                    <input type="text" name="code" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Color *</label>
                    <input type="color" name="color" class="form-control" value="#6366f1" required>
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="0">
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" value="1" checked> Active
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('admin.support.statuses.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
