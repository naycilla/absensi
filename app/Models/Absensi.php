<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensi';
    protected $guarded = ['id'];

    public function kelas()
    {
    	return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }

    public function absensi_detail()
    {
    	return $this->hasMany(AbsensiDetail::class, 'id_absensi', 'id');
    }

    public function tambah_absensi()
    {
    	return $this->hasMany(TambahAbsensi::class, 'id_absensi', 'id');
    }
}
