<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    public $table = 'kelas';
    protected $guarded = ['id'];

    public function siswa()
    {
    	return $this->hasMany(DataSiswa::class, 'id_kelas', 'id');
    }

    public function absensi()
    {
    	return $this->hasMany(Absensi::class, 'id_kelas', 'id');
    }

}
