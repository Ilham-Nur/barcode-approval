<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
   public function index()
    {
        $projects = Project::with('status')->latest()->get();
        return view('projek.indexprojek', compact('projects'));
    }

    public function create()
    {
        $statusList  = ProjectStatus::all();
        return view('projek.createprojek', compact('statusList'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
            $validated = $request->validate([
                'nama_perusahaan' => 'required|string|max:255',
                'nama_kapal' => 'required|string|max:255',
                'lokasi' => 'required|string|max:255',
                'jenis_pekerjaan' => 'required|string|max:255',
                'tanggal_masuk' => 'required|date',
                'tanggal_inspeksi' => 'nullable|date',
                'tanggal_selesai' => 'nullable|date',
                'pdf_file' => 'nullable|mimes:pdf|max:2048',
            ]);


        $validated['status_id'] = ProjectStatus::where('nama', 'Pending')->value('id');

        if ($request->hasFile('pdf_file')) {
            $validated['pdf_path'] = $request->file('pdf_file')->store('project_pdfs', 'public');
        }

        // Barcode tidak diisi dulu
        $validated['barcode_path'] = null;

        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Project berhasil ditambahkan dengan status Pending!');
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $statuses = ProjectStatus::all();
        return view('projects.edit', compact('project', 'statuses'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'nama_kapal' => 'required|string',
            'lokasi' => 'required|string',
            'jenis_pekerjaan' => 'required|string',
            'tanggal_inspeksi' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'status_id' => 'required|exists:project_statuses,id',
            'pdf' => 'nullable|file|mimes:pdf',
            'barcode' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $project->update($validated);

        if ($request->hasFile('pdf')) {
            if ($project->pdf_path) {
                Storage::disk('public')->delete($project->pdf_path);
            }
            $pdfPath = $request->file('pdf')->store("projects/{$project->id}", 'public');
            $project->update(['pdf_path' => $pdfPath]);
        }

        if ($request->hasFile('barcode')) {
            if ($project->barcode_path) {
                Storage::disk('public')->delete($project->barcode_path);
            }
            $barcodePath = $request->file('barcode')->store("projects/{$project->id}", 'public');
            $project->update(['barcode_path' => $barcodePath]);
        }

        return redirect()->route('projects.index')->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        if ($project->pdf_path) {
            Storage::disk('public')->delete($project->pdf_path);
        }

        if ($project->barcode_path) {
            Storage::disk('public')->delete($project->barcode_path);
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus.');
    }

   public function approve(Project $project)
    {
        $project->update(['status_id' => 2]);
        return response()->json(['success' => true, 'message' => 'Project berhasil di-approve.']);
    }

    public function reject(Project $project)
    {
        $project->update(['status_id' => 3]);
        return response()->json(['success' => true, 'message' => 'Project berhasil di-reject.']);
    }
}
