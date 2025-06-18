<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('operator.kelas.index', [
            'kelas' => Kelas::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kelas' => 'required|unique:kelas',
            'nisn' => 'required|unique:siswa',
            'no_absen' => 'required',
            'nama' => 'required',
        ], [
            'nama_kelas.required' => 'Kelas wajib diisi',
            'nama_kelas.unique' => 'Kelas sudah ada',
            'nisn.required' => 'NISN wajib diisi',
            'nisn.unique.' => 'NISN sudah ada',
            'no_absen.required' => 'Absen wajib diisi',
            'nama.required' => 'Nama wajib diisi',
        ]);
    
        $kelas = Kelas::create(['nama_kelas' => $validatedData['nama_kelas']]);
        
        $nisn = $validatedData['nisn'];
        $pass = Hash::make($nisn);

        $user = User::create([
            'username' => $nisn,
            'password' => $pass,
            'level' => 2,
        ]);

        $user->save();

        $id_user = User::where('username', $nisn)->value('id');

        DataSiswa::create([
            'id_user' => $id_user,
            'nisn' => $validatedData['nisn'],
            'no_absen' => $validatedData['no_absen'],
            'nama' => $validatedData['nama'],
            'id_kelas' => $kelas->id,
        ]);


        if(auth()->user()->level == 3) return redirect('/operator/data-kelas')->with('success', 'Kelas telah ditambahkan');
        if(auth()->user()->level == 4) return redirect('/admin/data-kelas')->with('success', 'Kelas telah ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Kelas $kelas)
    {

        $kelas = Kelas::where('id', $request->id)->get();
        $siswa = DataSiswa::where('id_kelas', $request->id)->get();
        // return $siswa;
        return view('operator.kelas.show', [
            'kelas' => $kelas,
            'siswa' => $siswa
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Kelas $kelas)
    {

        $kelas = Kelas::where('id', $request->id)->get();
        // return $kelas;

        return view('operator.kelas.edit', [
            'kelas' => $kelas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $kelas)
    {
        
        $kelas = Kelas::where('id', $request->id)->get();

            if($request->nama_kelas != $kelas[0]->nama_kelas)
            {
                $validatedData = $request->validate([
                    'nama_kelas' => 'required|unique:kelas',
                ], [
                    'nama_kelas.required' => 'Kelas wajib diisi',
                    'nama_kelas.unique' => 'Kelas sudah ada',
                ]);
    
                Kelas::Where('id', $request->id)
                ->update($validatedData);
    
            }
    
        
        if(auth()->user()->level == 3)  return redirect('/operator/data-kelas')->with('success', 'Kelas telah diubah');
        if(auth()->user()->level == 4)  return redirect('/admin/data-kelas')->with('success', 'Kelas telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (DataSiswa::where('id_kelas', '=', $request->id)->exists()) 
        {
            if(auth()->user()->level == 3) return redirect('/operator/data-kelas')->with('error', 'Kelas sedang digunakan');
            if(auth()->user()->level == 4) return redirect('/admin/data-kelas')->with('error', 'Kelas sedang digunakan');

        } else {

            Kelas::destroy($request->id);
            if(auth()->user()->level == 3) return redirect('/operator/data-kelas')->with('success', 'Kelas telah dihapus');
            if(auth()->user()->level == 4) return redirect('/admin/data-kelas')->with('success', 'Kelas telah dihapus');

        }
    }
}
