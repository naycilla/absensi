<?php

namespace App\Http\Controllers;
use App\Helpers\Helpers;
use App\Models\Absensi;
use App\Models\AbsensiDetail;
use App\Models\DataSiswa;
use App\Models\TambahAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index() 
    {
        $kelas = Auth::user()->data->kelas['nama_kelas'];
        $id_kelas = Auth::user()->data['id_kelas'];
        $absensi = Absensi::where('id_kelas', $id_kelas)->orderBy('created_at', 'desc')->get();

        return view('sekretaris.absensi.index', [
            'absensi' => $absensi,
            'kelas'=> $kelas
        ]);
    }

    public function create() 
    {
        $id_kelas = Auth::user()->data['id_kelas'];
        $siswa = DataSiswa::where('id_kelas', $id_kelas)->get();
        
        if(Absensi::where('id_kelas', $id_kelas)->count() > 0)
        {
        $latest_id = Absensi::where('id_kelas', $id_kelas)->orderBy('id', 'desc')->first()->id;
        if(AbsensiDetail::where('id_absensi', $latest_id)->count() < 1) {

            return redirect('/sekretaris/absensi-detail/'. $latest_id);

        }

    }


        $absensi = Absensi::create([
            'id_kelas' => $id_kelas,
            'sakit' => 0,
            'izin' => 0,
            'alpa' => 0,
            'dispen' => 0,
            'hadir' => 0,
        ]);

        foreach ($siswa as $siswa) 
        {
            TambahAbsensi::create([
                'id_absensi' => $absensi->id,
                'nisn' => $siswa['nisn'],
                'status' => '5',
                'keterangan' => '',
                'gambar' => ''
            ])->save();
        }

        return redirect('/sekretaris/absensi-detail/'.$absensi->id);     
    }

    public function detail(Request $request)
    {
        $id = $request->id;
        $tanggal = Absensi::where('id', $id)->value('created_at');
        $detail = AbsensiDetail::where('id_absensi', $id);

        $hadir = $detail->where('status', 5)->get();

        $absen = AbsensiDetail::select('*')
        ->where('id_absensi', $id)
        ->where(function($query) {
            return $query
                   ->where('status', '=', 1)
                   ->orWhere('status', '=', 2)
                   ->orWhere('status', '=', 3)
                   ->orWhere('status', '=', 4);
           })
        ->get();
        return view('sekretaris.absensi.detail', compact('hadir', 'absen', 'tanggal'));
    }
}
