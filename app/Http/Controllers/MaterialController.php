<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $materials = Material::where('title', 'like', "%$search%")
                            ->orWhere('description', 'like', "%$search%")
                            ->with('user', 'courses')
                            ->get();
        return view('dashboard', compact('materials'));
    }

    public function create()
    {
        return view('materials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'course_name' => 'required|string|max:255',
            'semester' => 'required|string|max:50',
        ]);

        $material = Material::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'approved' => false,
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('materials', 'public');
            $material->file_path = $filePath;
            $material->save();
        }

        $material->courses()->create([
            'course_name' => $request->course_name,
            'semester' => $request->semester,
        ]);

        return redirect()->route('dashboard')->with('success', 'Material uploaded successfully');
    }

    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'course_name' => 'required|string|max:255',
            'semester' => 'required|string|max:50',
        ]);

        $material->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->hasFile('file')) {
            if ($material->file_path) {
                \Storage::disk('public')->delete($material->file_path);
            }
            $filePath = $request->file('file')->store('materials', 'public');
            $material->file_path = $filePath;
            $material->save();
        }

        $material->courses()->updateOrCreate(
            ['material_id' => $material->id],
            ['course_name' => $request->course_name, 'semester' => $request->semester]
        );

        return redirect()->route('dashboard')->with('success', 'Material updated successfully');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('dashboard')->with('success', 'Material soft deleted');
    }

    public function forceDelete($id)
    {
        $material = Material::onlyTrashed()->findOrFail($id);
        if ($material->file_path) {
            \Storage::disk('public')->delete($material->file_path);
        }
        $material->forceDelete();
        return redirect()->route('dashboard')->with('success', 'Material permanently deleted');
    }

    public function approve(Material $material)
    {
        $material->approved = true;
        $material->save();
        return redirect()->route('dashboard')->with('success', 'Material approved');
    }

    public function stats()
    {
        $stats = Material::join('users', 'materials.user_id', '=', 'users.id')
                        ->join('courses', 'materials.id', '=', 'courses.material_id')
                        ->select('users.name', 'materials.title', 'courses.course_name', 'materials.approved')
                        ->get();
        return view('materials.stats', compact('stats'));
    }

    public function trash()
    {
        // Hanya ambil materi yang sudah di-soft delete
        $materials = Material::onlyTrashed()
            ->with('user', 'courses')
            ->where('user_id', auth()->id()) // Hanya tampilkan materi milik pengguna yang login
            ->get();

        return view('materials.trash', compact('materials'));
    }

    public function restore(Material $material)
    {
        // Pastikan hanya pemilik materi yang bisa memulihkan
        if (auth()->user()->role != 'mahasiswa' || $material->user_id != auth()->id()) {
            return redirect()->route('materials.trash')->with('error', 'Unauthorized action.');
        }

        // Pulihkan materi
        $material->restore();

        return redirect()->route('materials.trash')->with('success', 'Material restored successfully.');
    }
}