<?php

namespace App\Http\Controllers;

use App\Imports\PegawaiImport;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
    public function index()
    {
        return view('admin.pegawai.pegawai');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv,txt'
        ]);

        try {
            Excel::import(new PegawaiImport(), $request->file('file'));
            return response()->json(['message' => 'Data pegawai berhasil diimpor.'], 200);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message' => $failures], 422);
        }
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Pegawai::with(['user']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->with([
                    'totalPegawai' => Pegawai::count(),
                    'totalAktif' => Pegawai::where('status', 1)->count(),
                    'totalNonAktif' => Pegawai::where('status', 0)->count(),
                ])
                ->addColumn('action', function ($row) {
                    $editUrl = route('pegawai.edit', encrypt($row->id));
                    $deleteUrl = route('pegawai.destroy', encrypt($row->id));
                    return '<div class="flex space-x-2">
                        <a href="' . $editUrl . '" class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $decryptedId = decrypt($id);
        $pegawai = Pegawai::findOrFail($decryptedId);
        return view('admin.pegawai.pegawai_edit', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        try {
            $decryptedId = decrypt($id);
            $pegawai = Pegawai::findOrFail($decryptedId);

            $validated = $request->validate([
                'nik'=> 'required|numeric|digits:16|unique:t_pegawai,nik,' . $pegawai->id,
                'nama_lengkap' => 'required|string|max:100',
                'nip' => 'nullable|string|max:50|unique:t_pegawai,nip,' . $pegawai->id,
                'jabatan' => 'required|string|max:100',
            ]);

            $pegawai->nik = $validated['nik'];
            $pegawai->nama_lengkap = $validated['nama_lengkap'];
            $pegawai->nip = $validated['nip'] ?? null;
            $pegawai->jabatan = $validated['jabatan'];
            $pegawai->save();

            if ($pegawai->user_id) {
                \DB::table('t_users')
                    ->where('id', $pegawai->user_id)
                    ->update(['username' => $validated['nik']]);
            }

            Alert::success('Data Pegawai', 'Data pegawai berhasil diperbarui!');
            return redirect()->route('pegawai');
        } catch (\Throwable $th) {
            Alert::error('Gagal update pegawai', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $decryptedId = decrypt($id);
            $pegawai = Pegawai::findOrFail($decryptedId);

            if ($pegawai->user_id) {
                \DB::table('t_users')->where('id', $pegawai->user_id)->delete();
            }

            $pegawai->delete();

            Alert::success('Data Pegawai', 'Data pegawai berhasil dihapus!');
            return redirect()->route('pegawai');
        } catch (\Throwable $th) {
            Alert::error('Gagal hapus pegawai', $th->getMessage());
            return redirect()->back();
        }
    }
}
