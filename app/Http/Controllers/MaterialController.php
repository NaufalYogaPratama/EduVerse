<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $search = $request->query('search');
        $materials = Material::where('title', 'like', "%$search%")
                            ->orWhere('description', 'like', "%$search%")
                            ->with('user', 'courses')
                            ->get();
        return view('materials.index', compact('materials'));
    }
    
    public function create() {
        return view('materials.create');
    }
    
    public function store(Request $request) {
        $material = Material::create($request->except('file') + ['user_id' => auth()->id()]);
        if ($request->hasFile('file')) {
            $material->file_path = $request->file('file')->store('materials');
            $material->save();
        }
        return redirect()->route('materials.index');
    }
    
    public function edit(Material $material) {
        return view('materials.edit', compact('material'));
    }
    
    public function update(Request $request, Material $material) {
        $material->update($request->except('file'));
        if ($request->hasFile('file')) {
            $material->file_path = $request->file('file')->store('materials');
            $material->save();
        }
        return redirect()->route('materials.index');
    }
    
    public function destroy(Material $material) {
        $material->delete(); // Soft delete
        return redirect()->route('materials.index');
    }
    
    public function forceDelete($id) {
        Material::onlyTrashed()->find($id)->forceDelete(); // Hard delete
        return redirect()->route('materials.index');
    }
    
    public function approve(Material $material) {
        $material->approved = true;
        $material->save();
        return redirect()->route('materials.index');
    }
}
