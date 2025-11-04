@extends('admin::layouts.master')

@section('page_title')
    Edit Status
@stop

@section('content-wrapper')
    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>Edit Status</h1>
            </div>
        </div>

        <div class="page-content">
            <form action="{{ route('admin.support.statuses.update', $status->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ $status->name }}" required>
                </div>
                <div class="form-group">
                    <label>Code *</label>
                    <input type="text" name="code" class="form-control" value="{{ $status->code }}" required>
                </div>
                <div class="form-group">
                    <label>Color *</label>
                    <input type="color" name="color" class="form-control" value="{{ $status->color }}" required>
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ $status->sort_order }}">
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" value="1" {{ $status->is_active ? 'checked' : '' }}> Active
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.support.statuses.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
