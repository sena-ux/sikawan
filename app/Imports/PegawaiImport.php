<?php

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PegawaiImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = User::createOrFirst(
            ['username' => $row['nik'], 'email' => $row['email']],
            ['password' => bcrypt($row['nik']), 'role' => 'pegawai']
        );
        return Pegawai::updateOrCreate(
            ['nik' => $row['nik']],[
            'user_id' => $user->id,
            'nama_lengkap'  => $row['nama'],
            'nip' => $row['nip'],
            'jabatan' => $row['jabatan'],
            'alamat' => $row['alamat'],
            'no_hp' => $row['nohp'],
            'status' => true,
        ]);
    }

    public function rules(): array
    {
        return [
            'nik' => 'required|digits:16',
            'email' => 'nullable|email',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.required' => 'Kolom NIK wajib diisi!',
            'nik.max' => 'NIK maksimal 16 karakter',
        ];
    }
}
