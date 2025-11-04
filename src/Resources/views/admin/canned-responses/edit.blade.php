@extends('admin::layouts.master')

@section('page_title')
    Edit Canned Response
@stop

@section('content-wrapper')
    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>Edit Canned Response</h1>
            </div>
        </div>

        <div class="page-content">
            <form action="{{ route('admin.support.canned-responses.update', $cannedResponse->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ $cannedResponse->title }}" required>
                </div>
                <div class="form-group">
                    <label>Shortcut *</label>
                    <input type="text" name="shortcut" class="form-control" value="{{ $cannedResponse->shortcut }}" required>
                </div>
                <div class="form-group">
                    <label>Content *</label>
                    <textarea name="content" class="form-control" rows="5" required>{{ $cannedResponse->content }}</textarea>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" value="1" {{ $cannedResponse->is_active ? 'checked' : '' }}> Active
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.support.canned-responses.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
