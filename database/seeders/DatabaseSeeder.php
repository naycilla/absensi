<?php

namespace Database\Seeders;

use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Models\Pengelola;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'username' => '001',
            'password' => '$2y$10$OAayIs6rYttX4c/IWJh35OFP2DfUlsIAonw/hjOLyS0QPvuXZV5zW', // 001
            'level' => 2
        ]);

        User::create([
            'username' => 'operator',
            'password' => '$2y$10$WtyBW2kHTjpPZLXqS0vqhub8IwAZAK5iBUT0jnsTuNT/yq6welDCy', //123
            'level' => 3
        ]);

        Pengelola::create([
            'id_user' => '2',
            'nuptk' => '000111222333', 
            'nama' => 'Nur Khaliza',
            'nohp' => '08999999999'
        ]);

        DataSiswa::create([
            'id_user' => 1,
            'nisn' => '001',
            'no_absen' => 1,
            'nama' => 'Shafa Naura Livka Naycilla',
            'id_kelas' => '1'
        ]);

        Kelas::create([
            'nama_kelas' => 'XII RPL 1'
        ]);
    }
}
