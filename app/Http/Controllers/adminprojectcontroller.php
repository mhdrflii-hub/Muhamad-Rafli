<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teknologi' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|string',
        ]);

        $data = $request->only([
            'title',
            'description',
            'teknologi',
            'status',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . Str::random(10) . '.' .
                $request->image->extension();

            $request->image->move(public_path('images'), $imageName);

            $data['image'] = $imageName;
        }

        Project::create($data);

        return redirect()->route('admin.project.index')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $project = Project::findOrFail($id);

        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teknologi' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|string',
        ]);

        $data = $request->only([
            'title',
            'description',
            'teknologi',
            'status',
        ]);

        if ($request->hasFile('image')) {
            if ($project->image &&
                file_exists(public_path('images/' . $project->image))) {
                unlink(public_path('images/' . $project->image));
            }

            $imageName = time() . '_' . Str::random(10) . '.' .
                $request->image->extension();

            $request->image->move(public_path('images'), $imageName);

            $data['image'] = $imageName;
        }

        $project->update($data);

        return redirect()->route('admin.project.index')
            ->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);

        if ($project->image &&
            file_exists(public_path('images/' . $project->image))) {
            unlink(public_path('images/' . $project->image));
        }

        $project->delete();

        return redirect()->route('admin.project.index')
            ->with('success', 'Project berhasil dihapus.');
    }
}
