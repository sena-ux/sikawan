<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Jurnal;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view("admin.laporan.index");
    }

    public function view(Request $request)
    {
        if ($request->query("laporan") == "absensi") {
            return view("admin.laporan.absensi", [
                "absensi" => \DB::table('t_absensi')
                    ->where('user_id', auth()->id())
                    ->orderBy('tanggal', 'desc')
                    ->get(),
            ]);
        }
        if ($request->query("laporan") == "jurnal") {
            return view("admin.laporan.jurnal", [
                "jurnal" => \DB::table('t_jurnal')
                    ->where('user_id', auth()->id())
                    ->orderBy('tanggal', 'desc')
                    ->get(),
            ]);
        }
    }

    public function data(Request $request)
    {
        return view("admin.laporan.laporanData");
    }

    public function generateData(Request $request)
    {
        $bulan = $request->query('bulan');
        $tahun = $request->query('tahun');
        $laporan = $request->query('laporan');

        if ($laporan == 'absensi') {
            $data = Absensi::with('pegawai')
                ->whereMonth('tanggal', (int) $bulan)
                ->whereYear('tanggal', (int) $tahun)
                ->orderBy('tanggal', 'desc')
                ->get();
            return view("admin.laporan.generateAbsensi", compact('data', 'bulan', 'tahun'));
        }

        if ($laporan == 'jurnal') {
            $data = Jurnal::with('pegawai')
                ->whereMonth('tanggal', (int) $bulan)
                ->whereYear('tanggal', (int) $tahun)
                ->orderBy('tanggal', 'desc')
                ->get();

            // dd($data, $bulan, $tahun, $laporan);
            return view("admin.laporan.generateJurnal", compact('data', 'bulan', 'tahun'));
        }

        return redirect()->back()->withErrors(['message' => 'Jenis laporan tidak valid.']);
    }
}
