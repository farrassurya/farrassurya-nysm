<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime; // Tambahkan ini!

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
           // --- DATA DUMMY (SILAKAN DIGANTI) ---
        $tglLahir = '2006-4-17';         // Tanggal Lahir (untuk hitung umur)
        $tglWisudaTarget = '2027-12-01'; // Tanggal Harus Wisuda
        $semesterSaatIni = 3;           // Semester saat ini

        // --- PERHITUNGAN UMUR DAN WAKTU SISA ---
        $hariIni = new DateTime();

        // 1. Hitung Umur
        $tglLahirObj = new DateTime($tglLahir);
        $umur = $tglLahirObj->diff($hariIni)->y; // Ambil selisih dalam tahun

        // 2. Hitung Sisa Hari Belajar
        $tglWisudaObj = new DateTime($tglWisudaTarget);
        $sisaHari = $hariIni->diff($tglWisudaObj)->days; // Ambil selisih dalam hari

        // 3. Logic Kondisional Semester
        $pesanSemester = '';
        if ($semesterSaatIni < 3) {
            $pesanSemester = "Masih Awal, Kejar TAK";
        } elseif ($semesterSaatIni > 3) {
            $pesanSemester = "Jangan main-main, kurang-kurangi main game!";
        } else {
            // Untuk semester yang pas 3, bisa dikasih pesan netral atau ikut salah satu kondisi
            $pesanSemester = "Semester 3, fokus ya!";
        }

        // --- HASIL AKHIR SESUAI KETENTUAN ---
        $dataOutput = [
            'name' => 'Muhammad Farras Suryaputra',
            'my_age' => $umur,
            'hobbies' => [
                'Ngoding',
                'Night Ride',
                'Nonton FIlm',
                'Billiard',
                'Touring'
            ],
            'tgl_harus_wisuda' => $tglWisudaTarget,
            'time_to_study_left' => $sisaHari,
            'current_semester' => $semesterSaatIni,
            'info_semester_status' => $pesanSemester, // Key tambahan untuk pesan kondisional
            'future_goal' => 'Menjadi Data Analyst di perusahaan multinasional.',
        ];

            return view('pegawai', $dataOutput);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
