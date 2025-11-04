@extends('layouts.admin')

@section('page_title')
    Edit Rule
@stop

@section('content')
    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>Edit Automation Rule</h1>
            </div>
        </div>

        <div class="page-content">
            <form action="{{ route('admin.support.rules.update', $rule->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ $rule->name }}" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $rule->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Conditions (JSON) *</label>
                    <textarea name="conditions" class="form-control" rows="5" required>{{ json_encode($rule->conditions) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Actions (JSON) *</label>
                    <textarea name="actions" class="form-control" rows="5" required>{{ json_encode($rule->actions) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ $rule->sort_order }}">
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" value="1" {{ $rule->is_active ? 'checked' : '' }}> Active
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.support.rules.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
