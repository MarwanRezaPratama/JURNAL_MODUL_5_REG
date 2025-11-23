<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Http\Resources\MahasiswaResource;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    // TODO ( Praktikan Nomor Urut 1 )
    // Tambahkan fungsi index yang akan menampilkan List Data Mahasiswa
    // dan fungsi show yang akan menampilkan Detail Data Mahasiswa yang dipilih

    /**
     * Tampilkan seluruh data mahasiswa.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);

        $mahasiswas = Mahasiswa::paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => "List Data Mahasiswa",
            'data' => [
                'current_page' => $mahasiswas->currentPage(),
                'data' => MahasiswaResource::collection($mahasiswas->items()),
                'first_page_url' => $mahasiswas->url(1),
                'from' => $mahasiswas->firstItem(),
                'last_page' => $mahasiswas->lastPage(),
                'last_page_url' => $mahasiswas->url($mahasiswas->lastPage()),
            ]
        ], 200);
    }


    /**
     * Tampilkan detail mahasiswa tertentu.
     * Memanfaatkan route-model binding sehingga jika tidak ditemukan akan otomatis 404.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return new MahasiswaResource($mahasiswa);
    }

    // TODO ( Praktikan Nomor Urut 2 )
    // Tambahkan fungsi store yang akan menyimpan data Mahasiswa baru

    /**
     * Simpan mahasiswa baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|string|unique:mahasiswas,nim',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'kelas' => 'required|string',
            'jurusan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $mahasiswa = Mahasiswa::create($validator->validated());

        return (new MahasiswaResource($mahasiswa))
            ->response()
            ->setStatusCode(201);
    }

    // TODO ( Praktikan Nomor Urut 3 )
    // Tambahkan fungsi update yang mengubah data Mahasiswa yang dipilih

    /**
     * Update data mahasiswa yang dipilih.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validator = Validator::make($request->all(), [
            // unique pada nim kecuali record yang sedang diupdate
            'nim' => 'required|string|unique:mahasiswas,nim,' . $mahasiswa->id,
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'kelas' => 'required|string',
            'jurusan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $mahasiswa->update($validator->validated());

        return response()->json([
            'message' => 'Data mahasiswa berhasil diperbarui',
            'mahasiswa' => new MahasiswaResource($mahasiswa),
        ], 200);
    }

    // TODO ( Praktikan Nomor Urut 4 )
    // Tambahkan fungsi destroy yang akan menghapus data Mahasiswa yang dipilih

    /**
     * Hapus mahasiswa yang dipilih.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return response()->json([
            'message' => 'Data mahasiswa berhasil dihapus',
        ], 200);
    }
}
