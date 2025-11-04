<?php

namespace KevinBHarris\Support\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use KevinBHarris\Support\Models\Status;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::orderBy('sort_order')->paginate(20);
        return view('support::admin.statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('support::admin.statuses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:support_statuses,code',
            'color' => 'required|string|max:7',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        Status::create($validated);

        return redirect()->route('admin.support.statuses.index')
            ->with('success', 'Status created successfully.');
    }

    public function edit($id)
    {
        $status = Status::findOrFail($id);
        return view('support::admin.statuses.edit', compact('status'));
    }

    public function update(Request $request, $id)
    {
        $status = Status::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:support_statuses,code,' . $id,
            'color' => 'required|string|max:7',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $status->update($validated);

        return redirect()->route('admin.support.statuses.index')
            ->with('success', 'Status updated successfully.');
    }

    public function destroy($id)
    {
        $status = Status::findOrFail($id);
        
        if ($status->tickets()->count() > 0) {
            return back()->with('error', 'Cannot delete status with existing tickets.');
        }

        $status->delete();

        return redirect()->route('admin.support.statuses.index')
            ->with('success', 'Status deleted successfully.');
    }
}
