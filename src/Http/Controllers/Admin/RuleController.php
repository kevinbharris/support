<?php

namespace KevinBHarris\Support\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use KevinBHarris\Support\Models\Rule;
use KevinBHarris\Support\Models\Status;

class RuleController extends Controller
{
    public function index()
    {
        $rules = Rule::with(['fromStatus', 'toStatus'])->orderBy('created_at', 'desc')->paginate(20);
        return view('support::admin.rules.index', compact('rules'));
    }

    public function create()
    {
        $statuses = Status::where('is_active', true)->orderBy('sort_order')->get();
        return view('support::admin.rules.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'from_status_id' => 'required|exists:support_statuses,id',
            'to_status_id' => 'required|exists:support_statuses,id|different:from_status_id',
            'after_hours' => 'required|integer|min:1',
            'is_enabled' => 'boolean',
        ]);

        $validated['is_enabled'] = $request->has('is_enabled');

        Rule::create($validated);

        return redirect()->route('admin.support.rules.index')
            ->with('success', 'Automation rule created successfully.');
    }

    public function edit($id)
    {
        $rule = Rule::findOrFail($id);
        $statuses = Status::where('is_active', true)->orderBy('sort_order')->get();
        return view('support::admin.rules.edit', compact('rule', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $rule = Rule::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'from_status_id' => 'required|exists:support_statuses,id',
            'to_status_id' => 'required|exists:support_statuses,id|different:from_status_id',
            'after_hours' => 'required|integer|min:1',
            'is_enabled' => 'boolean',
        ]);

        $validated['is_enabled'] = $request->has('is_enabled');

        $rule->update($validated);

        return redirect()->route('admin.support.rules.index')
            ->with('success', 'Automation rule updated successfully.');
    }

    public function destroy($id)
    {
        $rule = Rule::findOrFail($id);
        $rule->delete();

        return redirect()->route('admin.support.rules.index')
            ->with('success', 'Automation rule deleted successfully.');
    }
}
