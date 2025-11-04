@extends('layouts.admin')

@section('page_title')
    Rules
@stop

@section('content')
    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>Automation Rules</h1>
            </div>
            <div class="page-action">
                <a href="{{ route('admin.support.rules.create') }}" class="btn btn-primary">Create Rule</a>
            </div>
        </div>

        <div class="page-content">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Sort Order</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rules as $rule)
                            <tr>
                                <td>{{ $rule->name }}</td>
                                <td>{{ $rule->description }}</td>
                                <td>{{ $rule->sort_order }}</td>
                                <td>{{ $rule->is_active ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('admin.support.rules.edit', $rule->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $rules->links() }}
        </div>
    </div>
@stop
