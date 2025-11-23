<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'nim' => $this->nim,
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'kelas' => $this->kelas,
            'jurusan' => $this->jurusan
        ];
    }
}
