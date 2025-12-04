<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita = Berita::orderBy('created_at', 'desc')->get();
        return view('admin.berita', compact('berita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.berita-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita-edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $berita = Berita::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $gambarPath = $berita->gambar;
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($berita->gambar && \Storage::disk('public')->exists($berita->gambar)) {
                \Storage::disk('public')->delete($berita->gambar);
            }
            $gambarPath = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $berita = Berita::findOrFail($id);

        // Delete image if exists
        if ($berita->gambar && \Storage::disk('public')->exists($berita->gambar)) {
            \Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus!');
    }

    // API methods for frontend
    public function getLatest()
    {
        $berita = Berita::orderBy('created_at', 'desc')->take(10)->get();
        return response()->json($berita);
    }

    public function getById($id)
    {
        $berita = Berita::findOrFail($id);
        return response()->json($berita);
    }
}
