@extends('admin.layouts.app')
@section('title', 'Pegawai Edit')
@section('pageTitle', 'Pegawai Edit Overview')
@section('pageSubTitle', 'Menu untuk mengedit data pegawai')
@section('content')
    <div class="p-4 sm:p-6 lg:p-8"><!-- Journal Card with Modern Responsive Design -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover fade-in">
                <!-- Card Header with Gradient -->
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-6">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div class="flex items-center space-x-2 lg:space-x-4 w-full">
                            <div class="text-right hidden md:block">
                                <h3 class="text-xl sm:text-2xl font-bold text-white">Form Edit Data Pegawai</h3>
                                <p class="text-purple-100 text-sm mt-1">Menu untuk mengedit data pegawai</p>
                            </div>
                        </div>
                        <button onclick="window.location.href='{{ route('pegawai') }}'"
                            class="flex items-center space-x-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 lg:px-6 lg:py-3 rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg><span class="hidden sm:inline font-semibold">Kembali</span>
                        </button>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="p-6 sm:p-8">
                    <form action="{{ route('pegawai.update', encrypt($pegawai->id)) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                            <input type="text" name="nik" id="nik" value="{{ $pegawai->nik }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                required>
                        </div>
                        <div>
                            <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                            <input type="text" name="nip" id="nip" value="{{ $pegawai->nip }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ $pegawai->nama_lengkap }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                required>
                        </div>
                        <div>
                            <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan" value="{{ $pegawai->jabatan }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ $pegawai->alamat }}</textarea>
                        </div>
                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                            <input type="text" name="no_hp" id="no_hp" value="{{ $pegawai->no_hp }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <button type="submit"
                                class="w-full bg-purple-600 text-white py-3 rounded-xl font-semibold shadow-md hover:bg-purple-700 transition">
                                Update Data Pegawai
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
