<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class JurnalController extends Controller
{
    public function index()
    {
        return view("admin.pegawai.jurnal_isi");
    }
    public function simpan(Request $request)
    {
        try {
            $validated = $request->validate([
                'hari' => 'required|string|max:20',
                'tanggal' => 'required|date',
                'kegiatan' => 'required|string',
                'deskripsi' => 'required|string',
                'foto' => 'nullable|image|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:2048',
            ]);

            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->move('uploads/jurnal', time() . '_' . $request->file('foto')->getClientOriginalName());
            }

            \App\Models\Jurnal::create([
                'user_id' => auth()->id(),
                'hari' => $validated['hari'],
                'tanggal' => $validated['tanggal'],
                'waktu' => now()->format('H:i:s'),
                'kegiatan' => $validated['kegiatan'],
                'deskripsi' => $validated['deskripsi'],
                'foto' => $fotoPath,
            ]);
            Alert::success('Jurnal berhasil dibuat!');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return redirect()->back();
        }
    }

    public function getData(Request $request)
    {
        $jurnals = \App\Models\Jurnal::where('user_id', auth()->id())
            ->orderBy('tanggal', 'desc')
            ->paginate(10); // gunakan paginate tanpa get()
        return view('admin.pegawai.jurnal_data', compact('jurnals'));
    }

    public function edit($id)
    {
        $decryptedId = decrypt($id);
        $jurnal = \App\Models\Jurnal::findOrFail($decryptedId);
        return view('admin.pegawai.jurnal_edit', compact('jurnal'));
    }

    public function update(Request $request, $id)
    {
        $decryptedId = decrypt($id);
        $jurnal = \App\Models\Jurnal::findOrFail($decryptedId);

        $validated = $request->validate([
            'hari' => 'required|string|max:20',
            'tanggal' => 'required|date',
            'kegiatan' => 'required|string',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus gambar lama jika ada
            if ($jurnal->foto && file_exists(public_path($jurnal->foto))) {
                @unlink(public_path($jurnal->foto));
            }
            $fotoPath = $request->file('foto')->move('uploads/jurnal', time() . '_' . $request->file('foto')->getClientOriginalName());
            $jurnal->foto = $fotoPath;
        }

        $jurnal->hari = $validated['hari'];
        $jurnal->tanggal = $validated['tanggal'];
        $jurnal->kegiatan = $validated['kegiatan'];
        $jurnal->deskripsi = $validated['deskripsi'];
        $jurnal->save();

        Alert::success('Jurnal berhasil diperbarui!');
        return redirect()->route('main.jurnal');
    }

    public function destroy($id)
    {
        $decryptedId = decrypt($id);
        $jurnal = \App\Models\Jurnal::findOrFail($decryptedId);

        // Hapus file gambar jika ada
        if ($jurnal->foto && file_exists(public_path($jurnal->foto))) {
            @unlink(public_path($jurnal->foto));
        }

        $jurnal->delete();

        Alert::success('Jurnal berhasil dihapus!');
        return redirect()->route('jurnal.data');
    }

    public function manageData(Request $request)
    {
        return view('admin.pegawai.jurnal_all_pegawai');
    }

    public function getDataWhere(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $query = Jurnal::with('pegawai');

        if ($tanggalAwal) {
            $query->whereDate('tanggal', '>=', $tanggalAwal);
        }

        if ($tanggalAkhir) {
            $query->whereDate('tanggal', '<=', $tanggalAkhir);
        }

        $jurnalRecords = $query->orderBy('tanggal', 'desc')->get();


        return DataTables::of($jurnalRecords)
            ->addIndexColumn()
            ->addColumn('hariTanggal', function ($row) {
            return $row->hari . ', ' . \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y');
            })
            ->addColumn('dokumen', function ($row) {
            $url = route('jurnal.get.one', Crypt::encrypt($row->id));
            return '<a href="' . $url . '" class="text-blue-600 hover:underline"><svg class="inline-block w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> Lihat Detail</a>';
            })
            ->rawColumns(['dokumen'])
            ->make(true);
    }

    public function getOne($id)
    {
        $decryptedId = Crypt::decrypt($id);
        $jurnal = Jurnal::with(['pegawai', 'dokumen'])->findOrFail($decryptedId);
        // dd($jurnal);
        return view('admin.pegawai.jurnal_detail', compact('jurnal'));
    }
}
