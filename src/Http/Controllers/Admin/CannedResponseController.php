<?php

namespace KevinBHarris\Support\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use KevinBHarris\Support\Models\CannedResponse;

class CannedResponseController extends Controller
{
    public function index()
    {
        $cannedResponses = CannedResponse::orderBy('title')->paginate(20);
        return view('support::admin.canned-responses.index', compact('cannedResponses'));
    }

    public function create()
    {
        return view('support::admin.canned-responses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'shortcut' => 'required|string|max:255|unique:support_canned_responses,shortcut',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        CannedResponse::create($validated);

        return redirect()->route('admin.support.canned-responses.index')
            ->with('success', 'Canned response created successfully.');
    }

    public function edit($id)
    {
        $cannedResponse = CannedResponse::findOrFail($id);
        return view('support::admin.canned-responses.edit', compact('cannedResponse'));
    }

    public function update(Request $request, $id)
    {
        $cannedResponse = CannedResponse::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'shortcut' => 'required|string|max:255|unique:support_canned_responses,shortcut,' . $id,
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $cannedResponse->update($validated);

        return redirect()->route('admin.support.canned-responses.index')
            ->with('success', 'Canned response updated successfully.');
    }

    public function destroy($id)
    {
        $cannedResponse = CannedResponse::findOrFail($id);
        $cannedResponse->delete();

        return redirect()->route('admin.support.canned-responses.index')
            ->with('success', 'Canned response deleted successfully.');
    }
}
