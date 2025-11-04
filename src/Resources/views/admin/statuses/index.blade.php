@extends('admin::layouts.master')

@section('page_title')
    Ticket Statuses
@stop

@section('content-wrapper')
    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>Ticket Statuses</h1>
            </div>
            <div class="page-action">
                <a href="{{ route('admin.support.statuses.create') }}" class="btn btn-primary">Create Status</a>
            </div>
        </div>

        <div class="page-content">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Color</th>
                            <th>Sort Order</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statuses as $status)
                            <tr>
                                <td>{{ $status->name }}</td>
                                <td>{{ $status->code }}</td>
                                <td><span class="badge" style="background-color: {{ $status->color }}">{{ $status->color }}</span></td>
                                <td>{{ $status->sort_order }}</td>
                                <td>{{ $status->is_active ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('admin.support.statuses.edit', $status->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $statuses->links() }}
        </div>
    </div>
@stop
