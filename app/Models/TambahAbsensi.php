<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TambahAbsensi extends Model
{
    use HasFactory;
    protected $table = 'tambah_absensi';
    protected $guarded = ['id'];

    public function absensi()
    {
    	return $this->belongsTo(Absensi::class, 'id_absensi', 'id');
    }    
    
    public function siswa()
    {
    	return $this->belongsTo(DataSiswa::class, 'nisn', 'nisn');
    }
}
