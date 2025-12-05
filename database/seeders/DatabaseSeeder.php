<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'intan',
            'email' => 'intannurfathriaha@gmail.com',
            'password' => bcrypt('Password123')
        ]);
        Mahasiswa::create([
            'nim' => 'A001',
            'nama' => 'intan',  
            'alamat' => 'Jl.Kampug dongkal cipondoh',
            'kelas' => 'TI-1A',
            'jurusan' => 'Teknologi Informasi'
        ]);
    }
}
