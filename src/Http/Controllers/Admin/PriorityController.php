<?php

namespace KevinBHarris\Support\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use KevinBHarris\Support\Models\Priority;

class PriorityController extends Controller
{
    public function index()
    {
        $priorities = Priority::orderBy('sort_order')->paginate(20);
        return view('support::admin.priorities.index', compact('priorities'));
    }

    public function create()
    {
        return view('support::admin.priorities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:support_priorities,code',
            'color' => 'required|string|max:7',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        Priority::create($validated);

        return redirect()->route('admin.support.priorities.index')
            ->with('success', 'Priority created successfully.');
    }

    public function edit($id)
    {
        $priority = Priority::findOrFail($id);
        return view('support::admin.priorities.edit', compact('priority'));
    }

    public function update(Request $request, $id)
    {
        $priority = Priority::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:support_priorities,code,' . $id,
            'color' => 'required|string|max:7',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $priority->update($validated);

        return redirect()->route('admin.support.priorities.index')
            ->with('success', 'Priority updated successfully.');
    }

    public function destroy($id)
    {
        $priority = Priority::findOrFail($id);
        
        if ($priority->tickets()->count() > 0) {
            return back()->with('error', 'Cannot delete priority with existing tickets.');
        }

        $priority->delete();

        return redirect()->route('admin.support.priorities.index')
            ->with('success', 'Priority deleted successfully.');
    }
}
