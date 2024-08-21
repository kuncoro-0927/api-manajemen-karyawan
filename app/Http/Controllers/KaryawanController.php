<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Cuti;
use App\Http\Controllers\Controller;
use App\Http\Resources\KaryawanResource;

class KaryawanController extends Controller
{
    // Menampilkan semua data karyawan
    public function index()
    {
        // Mengembalikan koleksi data karyawan dalam bentuk resource JSON
        return KaryawanResource::collection(Karyawan::all());
    }

    // Menyimpan data karyawan baru
    public function store(Request $request)
    {
        // Memvalidasi data yang dikirimkan dalam request
        $validated = $request->validate([
            'nomor_induk' => 'required|string|max:10|unique:data_karyawan', // nomor_induk harus unik
            'nama' => 'required|string|max:255', // nama harus berupa string dan maksimal 255 karakter
            'alamat' => 'required|string', // alamat harus berupa string
            'tanggal_lahir' => 'required|date', // tanggal_lahir harus berupa tanggal
            'tanggal_bergabung' => 'required|date', // tanggal_bergabung harus berupa tanggal
        ]);

        // Membuat data karyawan baru dengan data yang telah divalidasi
        $karyawan = Karyawan::create($validated);

        // Mengembalikan data karyawan yang baru dibuat dalam bentuk resource JSON
        return new KaryawanResource($karyawan);
    }

    // Menampilkan data karyawan berdasarkan ID
    public function show(Karyawan $karyawan)
    {
        // Mengembalikan data karyawan dalam bentuk resource JSON
        return new KaryawanResource($karyawan);
    }

    // Mengupdate data karyawan berdasarkan ID
    public function update(Request $request, $id)
    {
        // Memvalidasi data yang dikirimkan dalam request
        $data = $request->validate([
            'nomor_induk' => 'required|string', // nomor_induk harus berupa string
            'nama' => 'required|string', // nama harus berupa string
            'alamat' => 'required|string', // alamat harus berupa string
            'tanggal_lahir' => 'required|date', // tanggal_lahir harus berupa tanggal
            'tanggal_bergabung' => 'required|date', // tanggal_bergabung harus berupa tanggal
        ]);

        // Mencari data karyawan berdasarkan ID
        $karyawan = Karyawan::find($id);
        if (!$karyawan) {
            // Mengembalikan pesan kesalahan jika karyawan tidak ditemukan
            return response()->json(['message' => 'Karyawan tidak ditemukan'], 404);
        }

        // Mengupdate data karyawan dengan data baru
        $karyawan->update($data);

        // Mengembalikan data karyawan yang telah diupdate
        return response()->json(['data' => $karyawan], 200);
    }

    // Menghapus data karyawan berdasarkan ID
    public function destroy($id)
    {
        // Mencari data karyawan berdasarkan ID
        $karyawan = Karyawan::find($id);

        // Cek apakah karyawan ditemukan
        if (!$karyawan) {
            // Mengembalikan pesan kesalahan jika karyawan tidak ditemukan
            return response()->json(['message' => 'Karyawan tidak ditemukan'], 404);
        }

        // Menghapus data karyawan
        $karyawan->delete();

        // Mengembalikan pesan sukses setelah karyawan berhasil dihapus
        return response()->json(['message' => 'Karyawan berhasil dihapus'], 200);
    }

    // Menampilkan tiga karyawan pertama yang bergabung
    public function getFirstThreeKaryawan()
    {
        // Mengambil tiga karyawan pertama berdasarkan tanggal bergabung yang paling awal
        $karyawan = Karyawan::orderBy('tanggal_bergabung', 'asc')
                            ->limit(3)
                            ->get();

        // Mengembalikan data ketiga karyawan tersebut
        return response()->json(['data' => $karyawan], 200);
    }

    // Menampilkan karyawan yang memiliki data cuti
    public function getKaryawanWithCuti()
    {
        // Mengambil semua data cuti
        $cuti = Cuti::all();
        
        // Mengembalikan data cuti dalam bentuk JSON
        return response()->json($cuti);
    }

    // Menghitung dan menampilkan sisa cuti setiap karyawan
    public function sisaCuti()
    {
        // Mengambil semua data karyawan
        $karyawan = Karyawan::all();
        $quota_cuti = 12; // Kuota cuti per tahun

        // Menghitung sisa cuti untuk setiap karyawan
        $hasil = $karyawan->map(function($karyawan) use ($quota_cuti) {
            // Menghitung total cuti yang sudah diambil oleh karyawan berdasarkan nomor induk
            $total_cuti = Cuti::where('nomor_induk', $karyawan->nomor_induk)
                ->sum('lama_cuti');

            // Menghitung sisa cuti yang tersedia
            $sisa_cuti = $quota_cuti - $total_cuti;

            // Mengembalikan data berupa nomor_induk, nama, dan sisa cuti karyawan
            return [
                'nomor_induk' => $karyawan->nomor_induk,
                'nama' => $karyawan->nama,
                'sisa_cuti' => max($sisa_cuti, 0) // Pastikan sisa cuti tidak negatif
            ];
        });

        // Mengembalikan data sisa cuti dalam bentuk JSON
        return response()->json($hasil);
    }
}
