<?php

namespace App\Http\Controllers;

use App\Models\ProjectStatus;
use Illuminate\Http\Request;

class ProjectStatusController extends Controller
{
    public function index()
    {
        $statuses = ProjectStatus::all();
        return view('statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('statuses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_status' => 'required|string|unique:project_statuses,nama_status',
        ]);

        ProjectStatus::create($validated);

        return redirect()->route('statuses.index')->with('success', 'Status berhasil ditambahkan.');
    }

    public function edit(ProjectStatus $status)
    {
        return view('statuses.edit', compact('status'));
    }

    public function update(Request $request, ProjectStatus $status)
    {
        $validated = $request->validate([
            'nama_status' => 'required|string|unique:project_statuses,nama_status,' . $status->id,
        ]);

        $status->update($validated);

        return redirect()->route('statuses.index')->with('success', 'Status berhasil diperbarui.');
    }

    public function destroy(ProjectStatus $status)
    {
        $status->delete();
        return redirect()->route('statuses.index')->with('success', 'Status berhasil dihapus.');
    }
}
