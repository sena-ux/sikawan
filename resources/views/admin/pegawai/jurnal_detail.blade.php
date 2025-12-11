@extends('admin.layouts.app')
@section('title', 'Detail Jurnal Harian')
@section('pageTitle', 'Detail Jurnal Harian Overview')
@section('pageSubTitle', 'Informasi lengkap jurnal harian pegawai')
@section('content')
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover fade-in">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-purple-500 via-pink-400 to-purple-600 px-6 py-6">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-30 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white drop-shadow">Detail Jurnal Harian</h2>
                            <p class="text-purple-100 text-sm mt-1">Informasi lengkap jurnal pekerjaan harian</p>
                        </div>
                    </div>
                </div>

                <!-- Content Body -->
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Pegawai Info -->
                        <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3">Informasi Pegawai</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Nama Pegawai</p>
                                    <p class="font-semibold text-gray-900">{{ $jurnal->pegawai->nama_lengkap ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">NIK / NIP</p>
                                    <p class="font-semibold text-gray-900">{{ $jurnal->pegawai->nik ?? '-' }} / {{ $jurnal->pegawai->nip ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Jabatan</p>
                                    <p class="font-semibold text-gray-900">{{ $jurnal->pegawai->jabatan ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Departemen</p>
                                    <p class="font-semibold text-gray-900">{{ $jurnal->pegawai->alamat ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Jurnal Details -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-4">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3">Detail Jurnal</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Hari</p>
                                    <p class="font-semibold text-gray-900">{{ ucfirst($jurnal->hari) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Tanggal</p>
                                    <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Waktu Pencatatan</p>
                                    <p class="font-semibold text-gray-900">{{ $jurnal->waktu }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Kegiatan</p>
                                    <p class="font-semibold text-gray-900">{{ $jurnal->kegiatan }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">Deskripsi Kegiatan</h3>
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-gray-700 leading-relaxed">
                                {{ $jurnal->deskripsi }}
                            </div>
                        </div>

                        <!-- Foto Jurnal -->
                        @if($jurnal->foto)
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 mb-3">Foto Dokumentasi</h3>
                            <div class="bg-gray-100 rounded-xl p-4 overflow-hidden">
                                <img src="{{ asset($jurnal->foto) }}" alt="Dokumentasi Jurnal"
                                    class="w-full h-64 object-cover rounded-lg hover:scale-105 transition duration-300">
                            </div>
                        </div>
                        @endif

                        <!-- Dokumentasi -->
                        @if($jurnal->id_dokumen)
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 mb-3">Dokumentasi Pendukung</h3>
                            <div class="space-y-3">
                                @php
                                    $dokumens = \DB::table('t_dokumen')->where('id', $jurnal->id_dokumen)->get();
                                @endphp
                                @forelse($dokumens as $dokumen)
                                    <div class="flex items-center space-x-4 bg-gradient-to-r from-orange-50 to-red-50 border border-orange-200 rounded-xl p-4 hover:shadow-md transition">
                                        <div class="bg-orange-500 p-3 rounded-lg flex-shrink-0">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-900">{{ $dokumen->nama_dokumen }}</p>
                                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($dokumen->created_at)->format('d M Y H:i') }}</p>
                                        </div>
                                        <a href="{{ asset($dokumen->path_dokumen) }}" target="_blank"
                                            class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            <span>Download</span>
                                        </a>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-gray-500 italic">Tidak ada dokumentasi pendukung.</div>
                                @endforelse
                            </div>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('jurnal.manage.data') }}"
                                class="flex items-center justify-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl transition font-semibold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Kembali
                            </a>
                            {{-- <a href="{{ route('jurnal.edit', encrypt($jurnal->id)) }}"
                                class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition font-semibold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
    @endpush
@endsection
