<?php
namespace App\Helpers;
 
class Helpers {
    public static function format_uang($angka) {
        return number_format($angka, 0, ',', '.');
    }
    
    public static function tanggal($tanggal, $tampil_hari = true) {

        if ($tanggal instanceof \Carbon\Carbon) {
        $tanggal = $tanggal->format('Y-m-d');
    }

    $nama_hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $nama_bulan = [1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                   'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    // Ambil komponen angka dari tanggal
    $tahun = (int) substr($tanggal, 0, 4);
    $bulan_angka = (int) substr($tanggal, 5, 2);
    $tanggal_angka = (int) substr($tanggal, 8, 2);

    $bulan = $nama_bulan[$bulan_angka];
    $tgl = "";

    if ($tampil_hari) {
        // Semua argumen harus integer
        $urutan_hari = date('w', mktime(0, 0, 0, $bulan_angka, $tanggal_angka, $tahun));
        $hari = $nama_hari[$urutan_hari];
        $tgl = "$hari, $tanggal_angka $bulan $tahun";
    } else {
        $tgl = "$tanggal_angka $bulan $tahun";
    }

    return $tgl;
    }
    
    public static function tambah_nol_didepan($value, $threshold = null)
    {
        return sprintf("%0". $threshold . "s", $value);
    }
}