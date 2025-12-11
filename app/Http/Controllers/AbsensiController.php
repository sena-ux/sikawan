<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AbsensiController extends Controller
{
    public function index()
    {
        $data = [
            "absensi" => Absensi::all(),
            "izin" => \DB::table('t_izin')->where('user_id', auth()->id())->get(),
        ];
        return view('admin.absensi.absen', $data);
    }

    public function checkIn(Request $request)
    {
        // Logika untuk absen masuk
        try {
            Absensi::create([
                'user_id' => auth()->id(),
                'tanggal' => date('Y-m-d'),
                'jam_masuk' => date('H:i:s'),
                'status' => 'hadir',
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
            ]);
            return response()->json(['message' => 'Absen masuk berhasil!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal absen masuk.'], 500);
        }
    }

    public function checkOut(Request $request)
    {
        // Logika untuk absen pulang
        try {
            $absensi = Absensi::where('user_id', auth()->id())
                ->where('tanggal', date('Y-m-d'))
                ->first();
            if ($absensi) {
                $absensi->update([
                    'jam_pulang' => date('H:i:s'),
                ]);
                return response()->json(['message' => 'Absen pulang berhasil!'], 200);
            } else {
                return response()->json(['message' => 'Data absensi tidak ditemukan.'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal absen pulang.'], 500);
        }
    }

    public function izin(Request $request)
    {
        // Logika untuk mengajukan izin
        try {
            $idDokumen = null;

            if ($request->hasFile('dokumen')) {
                $file = $request->file('dokumen');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->move('uploads/dokumen', $filename);

                $idDokumen = \DB::table('t_dokumen')->insertGetId([
                    'user_id' => auth()->id(),
                    'nama_dokumen' => $filename,
                    'path_dokumen' => $path,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            \DB::table('t_izin')->insert([
                'user_id' => auth()->id(),
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'status' => 'pending',
                'id_dokumen' => $idDokumen,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['message' => 'Izin berhasil diajukan!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal mengajukan izin.'], 500);
        }
    }

    public function absensiData(){
        return view('admin.absensi.absensi_data');
    }

    public function absensiGetData(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $query = Absensi::with('pegawai');

        if ($tanggalAwal) {
            $query->whereDate('tanggal', '>=', $tanggalAwal);
        }

        if ($tanggalAkhir) {
            $query->whereDate('tanggal', '<=', $tanggalAkhir);
        }

        $absensiRecords = $query->orderBy('tanggal', 'desc')->get();


        return DataTables::of($absensiRecords)
            ->addIndexColumn()
            ->make(true);
    }

    // New method to view izin requests
    public function izinRequest()
    {
        $izinRequests = \DB::table('t_izin')
            ->join('t_users', 't_izin.user_id', '=', 't_users.id')
            ->leftJoin('t_pegawai', 't_users.id', '=', 't_pegawai.user_id')
            ->where('t_izin.status', 'pending')
            ->orderBy('t_izin.created_at', 'desc')
            ->select(
                't_izin.*',
                't_users.username',
                't_users.role',
                't_pegawai.nama_lengkap',
                't_pegawai.nik',
                't_pegawai.nip',
                't_pegawai.jabatan'
            )
            ->get();

        return view('admin.absensi.izin_request', compact('izinRequests'));
    }

    public function izinRequestDetail($id)
    {
        $decryptedId = decrypt($id);
        $izinRequest = \DB::table('t_izin')
            ->join('t_users', 't_izin.user_id', '=', 't_users.id')
            ->leftJoin('t_pegawai', 't_users.id', '=', 't_pegawai.user_id')
            ->leftJoin('t_dokumen', 't_izin.id_dokumen', '=', 't_dokumen.id')
            ->where('t_izin.id', $decryptedId)
            ->select(
                't_izin.*',
                't_users.username',
                't_users.role',
                't_pegawai.nama_lengkap',
                't_pegawai.nik',
                't_pegawai.nip',
                't_pegawai.jabatan',
                't_dokumen.nama_dokumen',
                't_dokumen.path_dokumen'
            )
            ->first();

        if (!$izinRequest) {
            abort(404, 'Izin request not found.');
        }

        return view('admin.absensi.izin_request_detail', compact('izinRequest'));
    }
}
