@extends('admin.layouts.app')
@section('title', 'Persetujuan Izin Pegawai')
@section('pageTitle', 'Persetujuan Izin Pegawai Overview')
@section('pageSubTitle', 'Menu untuk mengelola persetujuan izin pegawai')
@section('content')
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover fade-in">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-purple-500 via-pink-400 to-purple-600 px-6 py-6">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-30 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white drop-shadow">Detail Izin Tidak Hadir</h2>
                            <p class="text-purple-100 text-sm mt-1">Informasi lengkap pengajuan izin pegawai</p>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="p-6">
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-2 text-sm text-gray-500">Nama Pegawai</div>
                                <div class="font-semibold text-lg text-gray-800">{{ $izinRequest->nama_lengkap ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="mb-2 text-sm text-gray-500">NIK / NIP</div>
                                <div class="font-semibold text-lg text-gray-800">
                                    {{ $izinRequest->nik ?? '-' }} / {{ $izinRequest->nip ?? '-' }}
                                </div>
                            </div>
                            <div>
                                <div class="mb-2 text-sm text-gray-500">Jabatan</div>
                                <div class="font-semibold text-lg text-gray-800">{{ $izinRequest->jabatan ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="mb-2 text-sm text-gray-500">Username</div>
                                <div class="font-semibold text-lg text-gray-800">{{ $izinRequest->username }}</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-2 text-sm text-gray-500">Tanggal Izin</div>
                                <div class="font-semibold text-lg text-gray-800">
                                    {{ \Carbon\Carbon::parse($izinRequest->tanggal)->format('d M Y') }}
                                </div>
                            </div>
                            <div>
                                <div class="mb-2 text-sm text-gray-500">Status</div>
                                <div>
                                    @if($izinRequest->status == 'pending')
                                        <span class="inline-block px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-semibold text-sm">Menunggu</span>
                                    @elseif($izinRequest->status == 'approved')
                                        <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-sm">Disetujui</span>
                                    @else
                                        <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-800 font-semibold text-sm">Ditolak</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-2 text-sm text-gray-500">Keterangan</div>
                            <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 text-gray-700">
                                {{ $izinRequest->keterangan ?? '-' }}
                            </div>
                        </div>
                        <div>
                            <div class="mb-2 text-sm text-gray-500">Dokumen Pendukung</div>
                            @if($izinRequest->nama_dokumen && $izinRequest->path_dokumen)
                                <div class="flex items-center space-x-4 bg-gray-50 border border-gray-200 rounded-xl p-4">
                                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7v10a2 2 0 002 2h6a2 2 0 002-2V7M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-800">{{ $izinRequest->nama_dokumen }}</div>
                                        <a href="{{ asset($izinRequest->path_dokumen) }}" target="_blank"
                                            class="text-sm text-purple-600 hover:underline">Lihat / Download</a>
                                    </div>
                                </div>
                            @else
                                <div class="italic text-gray-400">Tidak ada dokumen pendukung.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $(document).ready(function () {
            });
        </script>
    @endpush
@endsection
