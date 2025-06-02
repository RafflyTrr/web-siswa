<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request) //Tampilan Index
    {
        $query = Siswa::query();
    
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%');
        }
    
        $siswas = $query->orderBy('id', 'desc')->Simplepaginate(4);
        return view('pages.siswa.index', compact('siswas'));
    }
    
    public function create() //  Tampilan Tambah
    {
        return view('pages.siswa.create'); // <- Pastikan path-nya sesuai folder
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nis' => 'required',
            'kelas' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
        ]);

        Siswa::create($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id) //Tamilan edit
{
    $siswa = Siswa::findOrFail($id);
    return view('pages.siswa.edit', compact('siswa'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required',
        'nis' => 'required',
        'kelas' => 'required',
        'jenis_kelamin' => 'required',
        'alamat' => 'required',
    ]);

    $siswa = Siswa::findOrFail($id);
    $siswa->update($request->all());

    return redirect()->route('siswa.index')->with('success', 'Data berhasil diperbarui!');
}

public function destroy($id) // Hapus
{
    $siswa = Siswa::findOrFail($id);
    $siswa->delete();

    return redirect()->route('siswa.index')->with('success', 'Data berhasil dihapus!');
}

}
