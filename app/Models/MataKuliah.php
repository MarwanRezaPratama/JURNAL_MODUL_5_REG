<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    //TODO
    //Tambahkan fillable model MataKuliah sesuai dengan variabel yang ada
    protected $fillable = [
        'kode',
        'nama',
        'sks'
    ];
}   
