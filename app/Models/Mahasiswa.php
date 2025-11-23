<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    //TODO
    //Tambahkan fillable model Mahasiswa sesuai dengan variabel yang ada
    protected $fillable = [
        'nim',
        'nama',
        'alamat',
        'kelas',
        'jurusan'
    ];
}
