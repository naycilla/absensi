<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\AbsensiDetail;
use App\Models\DataSiswa;
use App\Models\TambahAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiDetailController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $absensi = Absensi::find($id);
        // $detail_exist = TambahAbsensi::where('id_absensi', $id)->value('nisn');
        $kelas = Auth::user()->data->kelas['nama_kelas'];
        $siswa = DataSiswa::where('id_kelas', $absensi->id_kelas)->get();
        $detail = TambahAbsensi::where('id_absensi', $id)->where('status', '<>', 5)->get();

        if (AbsensiDetail::where('id_absensi', '=', $id)->exists()) {
            
            return redirect('/sekretaris/absensi');

        } 
        
        else {

            return view('sekretaris.absensi.create', [
                'absensi' => $absensi,
                'detail' => $detail,
                'siswa' => $siswa,
                'kelas' => $kelas
            ]);
    
        }
    }

    public function create(Request $request)
    {
        // return $request;

        $tambah_exist = TambahAbsensi::where('id_absensi', $request->id_absensi)->where('nisn', $request->nisn)->where('status', '!=', 5)->first();
        
        if ($tambah_exist !== null) 
        { 
            return back()->with('error', 'Siswa sudah ditambahkan');
        } 
        
        if ($request->hasFile('bukti'))
        {
            $data = $request->validate([
                'bukti' => 'mimes:jpg,jpeg,png,pdf',
                'nisn' => 'required',
                'status' => 'required'
            ], [
                'bukti.mimes' => 'Bukti harus berupa jpg, png, atau pdf',
                'nisn.required' => 'Nama wajib diisi',
                'status.required' => 'Status wajib diisi'
            ]);

            $bukti = $request->file('bukti')->store('bukti');

            TambahAbsensi::where('nisn', $request->nisn)->update([
                'status' => $request->status,
                'keterangan' => $request->keterangan,
                'gambar' => $bukti
            ]);

            return redirect('/sekretaris/absensi-detail/'. $request->id_absensi);

        } else {

            $data = $request->validate([
                'nisn' => 'required',
                'status' => 'required'
            ], [
                'nisn.required' => 'Nama wajib diisi',
                'status.required' => 'Status wajib diisi'
            ]);

            
            TambahAbsensi::where('nisn', $request->nisn)->update([
                'status' => $request->status,
                'keterangan' => $request->keterangan,
            ]);

            return redirect('/sekretaris/absensi-detail/'. $request->id_absensi);

        }
        
    }

    public function store(Request $request)
    {
        $tambah_absensi = TambahAbsensi::where('id_absensi', $request->id)->select('id_absensi', 'nisn', 'status', 'keterangan', 'gambar')->get()->toArray();
        AbsensiDetail::insert($tambah_absensi);
        $created_at = Absensi::where('id', $request->id)->value('created_at');
        AbsensiDetail::where('id_absensi', $request->id)->update([
            'created_at' => $created_at
        ]);

        $hapus = TambahAbsensi::where('id_absensi', $request->id)->select('id_absensi', 'nisn', 'status', 'keterangan', 'gambar');
        $hapus->delete();

        $hadir = AbsensiDetail::where('id_absensi', $request->id)->where('status', 5)->count();
        $sakit = AbsensiDetail::where('id_absensi', $request->id)->where('status', 1)->count();
        $izin = AbsensiDetail::where('id_absensi', $request->id)->where('status', 2)->count();
        $alpa = AbsensiDetail::where('id_absensi', $request->id)->where('status', 3)->count();
        $dispen = AbsensiDetail::where('id_absensi', $request->id)->where('status', 4)->count();

        Absensi::where('id', $request->id)->update([
            'hadir' => $hadir,
            'sakit' => $sakit,
            'izin' => $izin,
            'alpa' => $alpa,
            'dispen' => $dispen,
        ]);

        return redirect('/sekretaris/absensi')->with('success', 'Absensi berhasil ditambahkan');


    }
    
    public function destroy(Request $request)
    {
        TambahAbsensi::where('nisn', $request->nisn)->update([
            'status' => 5,
            'keterangan' => null,
            'gambar' =>  null
        ]);

        return back();

    }
}
