<?php

namespace App\Http\Controllers;

use App\Models\AbsensiDetail;
use App\Models\DataSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DataSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_kelas = Auth::user()->data['id_kelas'];
        $kelas = Auth::user()->data->kelas['nama_kelas'];
        $siswa = DataSiswa::where('id_kelas', $id_kelas)->get();

        return view('sekretaris.data.index', [
            'siswa' => $siswa,
            'kelas' => $kelas
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
        // return $request;
        if(!isset($request->id_kelas)) $id_kelas = Auth::user()->data['id_kelas'];
        else $id_kelas = $request->id_kelas;

        if(isset($request->level))  $level = $request->level;
        else $level = 1;

        $validatedData = $request->validate([
            'no_absen' => [
                'required', 
                'numeric',
                'min:1',
                        Rule::unique('siswa')
                            ->where('id_kelas', $id_kelas)
            ],
            'nisn' => 'required|unique:siswa',
            'nama' => 'required',
        ], [
            'nisn.required' => 'NISN wajib diisi',
            'nisn.unique' => 'NISN sudah terdaftar',
            'no_absen.required' => 'Absen wajib diisi',
            'no_absen.unique' => 'Absen sudah terdaftar',
            'no_absen.min' => 'Harus lebih dari 0',
            'no_absen.numeric' => 'Harus berupa angka',
            'nama.required' => 'Nama wajib diisi',
        ]);
        
        $validatedData['id_kelas'] = $id_kelas;

        $nisn = $validatedData['nisn'];
        $pass = Hash::make($nisn);

        $user = User::create([
            'username' => $nisn,
            'password' => $pass,
            'level' => $level,
        ]);

        $user->save();

        $id_user = User::where('username', $nisn)->value('id');
        $validatedData['id_user'] = $id_user;

        DataSiswa::create($validatedData);

        if(auth()->user()->level == 3) return redirect('/operator/data-kelas/'. $id_kelas)->with('success', 'Siswa telah ditambahkan'); 
        elseif(auth()->user()->level == 2)  return redirect('/sekretaris/data-siswa')->with('success', 'Siswa telah ditambahkan'); 
        elseif(auth()->user()->level == 4)  return redirect('/admin/data-kelas/'. $id_kelas)->with('success', 'Siswa telah ditambahkan'); 

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataSiswa  $dataSiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DataSiswa $dataSiswa)
    {
        $absen = $request->absen;
        $id_kelas = Auth::user()->data['id_kelas'];
        $siswa = $dataSiswa::where('id_kelas', $id_kelas)->where('no_absen', $absen)->get();
        return $siswa;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataSiswa  $dataSiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DataSiswa $dataSiswa)
    {
        
        $nisn = $request->nisn;
        // return $nisn;
        $id_kelas = DataSiswa::where('nisn', $nisn)->value('id_kelas');
        $siswa = $dataSiswa::where('nisn', $nisn)->get();
        $level = User::where('username', $nisn)->value('level');
        
        return view('sekretaris.data.edit', [
            'siswa' => $siswa,
            'id_kelas' => $id_kelas,
            'level' => $level
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataSiswa  $dataSiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataSiswa $dataSiswa)
    {
        $dataSiswa = DataSiswa::where('nisn', $request->nisn)->first();
        // return $dataSiswa;
        
        $rules = [ 'nama' => 'required' ];
        $validator = [ 'nama.required' => 'Nama wajib diisi' ];

        if($request->no_absen != $dataSiswa->no_absen)
        {
            $rules['no_absen'] = [
                        'required', 
                        'numeric',
                        'min:1',
                        Rule::unique('siswa')
                            ->where('id_kelas', $request->id_kelas)
            ];
            $validator['no_absen.required']  = 'Absen wajib diisi';
            $validator['no_absen.unique']  = 'Absen sudah terdaftar';
            $validator['no_absen.min']  =  'Harus lebih dari 0';
            $validator['no_absen.numeric']  = 'Absen hanya boleh berupa angka';
                
        }

        if($request->nisn != $dataSiswa->nisn)
        {
            $rules['nisn'] = 'required|unique:siswa';
            $validator['nisn.required']  = 'NISN wajib diisi';
            $validator['nisn.unique']  = 'NISN sudah terdaftar';         
        }
            $validatedData = $request->validate($rules, $validator);

            if(isset($validatedData['nisn']))
            {
                $nisn = $validatedData['nisn'];
                $pass = Hash::make($nisn);
        
                User::where('username', $dataSiswa->nisn)
                ->update([
                    'username' => $nisn,
                    'password' => $pass
                 ]);
                            
            }

            if(isset($request->level))
            {
                User::where('username', $dataSiswa->nisn)
                ->update([
                    'level' => $request->level,
                 ]);
            }

            DataSiswa::Where('nisn', $dataSiswa->nisn)
            ->update($validatedData);

        

        if(auth()->user()->level == 3) return redirect('/operator/data-kelas/'. $request->id_kelas)->with('success', 'Siswa telah diubah');
        if(auth()->user()->level == 4) return redirect('/admin/data-kelas/'. $request->id_kelas)->with('success', 'Siswa telah diubah');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataSiswa  $dataSiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DataSiswa $dataSiswa)
    {
        $absen = $request->absen;
        $id_kelas = Auth::user()->data['id_kelas'];
        $siswa = $dataSiswa::where('id_kelas', $id_kelas)->where('no_absen', $absen);
        $nisn = $siswa->value('nisn');
        $user = User::where('username', $nisn)->delete();
        $siswa->delete();

       if(auth()->user()->level == 2) return redirect('/sekretaris/data-siswa')->with('success', 'Siswa telah dihapus'); 
       if(auth()->user()->level == 3) return redirect('/operator/data-siswa')->with('success', 'Siswa telah dihapus'); 
        
    }
    public function delete(Request $request, DataSiswa $dataSiswa)
    {
        
        $siswa = $dataSiswa::where('nisn', $request->nisn)->get();
        $kelas = $siswa[0]->id_kelas;

        User::where('username', $siswa[0]->nisn)->delete();
        $dataSiswa::where('nisn', $request->nisn)->delete();
        AbsensiDetail::where('nisn', $request->nisn)->delete();

        if(auth()->user()->level == 3) return redirect('/operator/data-kelas/'. $kelas)->with('success', 'Siswa telah dihapus'); 
        if(auth()->user()->level == 4) return redirect('/admin/data-kelas/'. $kelas)->with('success', 'Siswa telah dihapus'); 
        
    }
}
