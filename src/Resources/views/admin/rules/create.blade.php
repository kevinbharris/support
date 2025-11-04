@extends('layouts.admin')

@section('page_title')
    Create Rule
@stop

@section('content')
    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>Create Automation Rule</h1>
            </div>
        </div>

        <div class="page-content">
            <form action="{{ route('admin.support.rules.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Name *</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Conditions (JSON) *</label>
                    <textarea name="conditions" class="form-control" rows="5" required>{"field": "priority_id", "operator": "equals", "value": "1"}</textarea>
                    <small class="text-muted">Example: {"field": "priority_id", "operator": "equals", "value": "1"}</small>
                </div>
                <div class="form-group">
                    <label>Actions (JSON) *</label>
                    <textarea name="actions" class="form-control" rows="5" required>{"action": "assign", "value": "1"}</textarea>
                    <small class="text-muted">Example: {"action": "assign", "value": "1"}</small>
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
                <a href="{{ route('admin.support.rules.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
