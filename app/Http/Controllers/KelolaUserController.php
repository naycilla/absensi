<?php

namespace App\Http\Controllers;

use App\Models\Pengelola;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KelolaUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.operator.index', [
            'user' => User::where('level', 3)->orWhere('level', 4)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.operator.create');
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
        $validatedData = $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
            'nama' => 'required',
            'nohp' => 'required|numeric|unique:pengelola',
            'nuptk' => 'required|numeric|unique:pengelola',
            'level' => 'required'
        ], [
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah ada',
            'password.required' => 'Password wajib diisi',
            'nama.required' => 'Nama wajib diisi',
            'nuptk.required' => 'NUPTK wajib diisi',
            'nuptk.unique' => 'NUPTK sudah terdaftar',
            'nuptk.numeric' => 'Harus berupa angka',
            'nohp.required' => 'No hp wajib diisi',
            'nohp.unique' => 'No hp sudah terdaftar',
            'nohp.numeric' => 'Harus berupa angka',
        ]);

        // return $validatedData;

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create([
            'username' => $validatedData['username'],
            'password' => $validatedData['password'], 
            'level' => $validatedData['level']
        ]);

        $user->save();

        $pengelola = Pengelola::create([
            'id_user' => $user->id,
            'nuptk' => $validatedData['nuptk'],
            'nama' => $validatedData['nama'],
            'nohp' => $validatedData['nohp'],
        ]);

        $pengelola->save();

        return redirect('/admin/kelola-user')->with('success', 'User berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.operator.edit', [
            'user' => User::where('id', $id)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;
        $user = User::where('id', $id)->first();

        $rules = [
            'username' => 'required',
            'level' => 'required',
            'nama' => 'required',
            'nuptk' => 'required',
            'nohp' => 'required',
        ];

        $validator = [
            'username.required' => 'Username wajib diisi',
            'nama.required' => 'Nama wajib diisi',
            'nuptk.required' => 'NUPTK wajib diisi',
            'nohp.required' => 'No hp wajib diisi',
        ];

        if($user->username != $request->username)
        {
            $rules['username'] = 'unique:users';
            $validator['username.unique'] = 'Username sudah ada';

        } 
        
        if($user->pengelola->nuptk != $request->nuptk)
        {
            $rules['nuptk'] = 'numeric|unique:pengelola';
            $validator['nuptk.unique'] = 'NUPTK sudah terdaftar';
            $validator['nuptk.numeric'] = 'Harus berupa angka';
        } 
        
        if($user->pengelola->nohp != $request->nohp)
        {
            $rules['nohp'] = 'numeric|unique:pengelola';
            $validator['nohp.unique'] = 'No hp sudah terdaftar';
            $validator['nohp.numeric'] = 'Harus berupa angka';

        }    

        $validatedData = $request->validate($rules, $validator);
        
        User::where('id', $id)->update([
            'username' => $validatedData['username'],
            'level' => $validatedData['level'],
        ]);
        
        Pengelola::where('id_user', $id)->update([
            'nuptk' => $validatedData['nuptk'],
            'nama' => $validatedData['nama'],
            'nohp' => $validatedData['nohp'],
        ]);

        return redirect('/admin/kelola-user')->with('success', 'User berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        //id request
        $id = $request->id;

        //cek id yang sedang login
        $logged_id = auth()->user()->id;

        //hapus 
        Pengelola::where('id_user', $request->id)->delete();
        User::where('id', $request->id)->delete();
             
        //cek apakah admin menghapus akunnya sendiri
        if($logged_id !== $id)
        //jika admin menghapus akunnya sendiri
        return redirect('/admin/kelola-user/' )->with('success', 'User telah dihapus'); 

        else 
        //jika admin menghapus akun lain
        return redirect('/admin/logout');

    }
}
