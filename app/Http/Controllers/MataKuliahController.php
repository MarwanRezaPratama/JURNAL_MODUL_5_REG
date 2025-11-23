<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Http\Resources\MatakuliahResource;
use Illuminate\Support\Facades\Validator;

class MatakuliahController extends Controller
{
    // TODO ( Praktikan Nomor Urut 5 )
    // Tambahkan fungsi index yang akan menampilkan List Data Matakuliah
    // dan fungsi show yang akan menampilkan Detail Data Mahasiswa yang dipilih

    /**
     * Tampilkan seluruh data mata kuliah.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);

        $mata_kuliahs = MataKuliah::paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => "List Data Mata Kuliah",
            'data' => [
                'current_page' => $mata_kuliahs->currentPage(),
                'data' => MatakuliahResource::collection($mata_kuliahs->items()),
                'first_page_url' => $mata_kuliahs->url(1),
                'from' => $mata_kuliahs->firstItem(),
                'last_page' => $mata_kuliahs->lastPage(),
                'last_page_url' => $mata_kuliahs->url($mata_kuliahs->lastPage()),
            ]
        ], 200);
    }

    /**
     * Tampilkan detail mata kuliah tertentu.
     * Menggunakan route-model binding sehingga jika tidak ditemukan otomatis 404.
     */
    public function show(MataKuliah $matakuliah)
    {
        return new MatakuliahResource($matakuliah);
    }

    // TODO ( Praktikan Nomor Urut 6 )
    // Tambahkan fungsi store yang akan menyimpan data MataKuliah baruurn new MatakuliahResource(true, 'Data Matakuliah Berhasil Ditambahkan!', $matakuliah)

    /**
     * Simpan mata kuliah baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string|unique:mata_kuliahs,kode',
            'nama' => 'required|string',
            'sks' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $matakuliah = MataKuliah::create($validator->validated());

        // Jika MatakuliahResource Anda menerima (success, message, data)
        // return new MatakuliahResource(true, 'Data Matakuliah Berhasil Ditambahkan!', $matakuliah);

        // Alternatif (jika resource hanya menerima model):
        return response()->json([
            'success' => true,
            'message' => 'Data Matakuliah Berhasil Ditambahkan!',
            'data' => new MatakuliahResource($matakuliah)
        ], 201);
    }

    // TODO ( Praktikan Nomor Urut 7 )
    // Tambahkan fungsi update yang mengubah data MataKuliah yang dipilih

    /**
     * Update data mata kuliah yang dipilih.
     */
    public function update(Request $request, $id)
    {
        $matakuliah = MataKuliah::findOrFail($id);
        $validator = Validator::make($request->all(), [
            // unique pada kode kecuali record yang sedang diupdate
            'kode' => 'required|string|unique:mata_kuliahs,kode,' . $matakuliah->id,
            'nama' => 'required|string',
            'sks' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $matakuliah->update($validator->validated());

        // Kembalikan resource dengan pesan sukses jika resource mendukungnya
        return response()->json([
            'success' => true,
            'message' => 'Data Matakuliah Berhasil Diperbarui!',
            'data' => new MatakuliahResource($matakuliah)
        ], 200);
    }

    // TODO ( Praktikan Nomor Urut 8 )
    // Tambahkan fungsi destroy yang akan menghapus data MataKuliah yang dipilih

    /**
     * Hapus mata kuliah yang dipilih.
     */
    public function destroy($id)
    {
        $matakuliah = MataKuliah::findOrFail($id);
        $matakuliah->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Matakuliah Berhasil Dihapus!'
        ], 200);
    }
}
