@extends('admin::layouts.master')

@section('page_title')
    Canned Responses
@stop

@section('content-wrapper')
    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>Canned Responses</h1>
            </div>
            <div class="page-action">
                <a href="{{ route('admin.support.canned-responses.create') }}" class="btn btn-primary">Create Response</a>
            </div>
        </div>

        <div class="page-content">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Shortcut</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cannedResponses as $response)
                            <tr>
                                <td>{{ $response->title }}</td>
                                <td><code>{{ $response->shortcut }}</code></td>
                                <td>{{ $response->is_active ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('admin.support.canned-responses.edit', $response->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $cannedResponses->links() }}
        </div>
    </div>
@stop
