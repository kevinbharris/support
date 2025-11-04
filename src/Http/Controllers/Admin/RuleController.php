<?php

namespace KevinBHarris\Support\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use KevinBHarris\Support\Models\Rule;

class RuleController extends Controller
{
    public function index()
    {
        $rules = Rule::orderBy('sort_order')->paginate(20);
        return view('support::admin.rules.index', compact('rules'));
    }

    public function create()
    {
        return view('support::admin.rules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'conditions' => 'required|array',
            'actions' => 'required|array',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        Rule::create($validated);

        return redirect()->route('admin.support.rules.index')
            ->with('success', 'Rule created successfully.');
    }

    public function edit($id)
    {
        $rule = Rule::findOrFail($id);
        return view('support::admin.rules.edit', compact('rule'));
    }

    public function update(Request $request, $id)
    {
        $rule = Rule::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'conditions' => 'required|array',
            'actions' => 'required|array',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $rule->update($validated);

        return redirect()->route('admin.support.rules.index')
            ->with('success', 'Rule updated successfully.');
    }

    public function destroy($id)
    {
        $rule = Rule::findOrFail($id);
        $rule->delete();

        return redirect()->route('admin.support.rules.index')
            ->with('success', 'Rule deleted successfully.');
    }
}
