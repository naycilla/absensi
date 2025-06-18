<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataSiswa extends Model
{
    use HasFactory;
    public $table = 'siswa';
    protected $guarded = [];

    public function user()
    {
    	return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function kelas()
    {
    	return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }
    public function detail()
    {
    	return $this->hasMany(AbsensiDetail::class, 'nisn', 'nisn');
    }

    public function tambah_absensi()
    {
    	return $this->hasMany(TambahAbsensi::class, 'nisn', 'nisn');
    }
}
