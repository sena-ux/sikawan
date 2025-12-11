@extends('admin.layouts.app')
@section('title', 'Jurnal')
@section('pageTitle', 'Jurnal Page')
@section('pageSubTitle', 'Halaman Jurnal Harian')
@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengisian Jurnal</h3>
            </div>
            <div class="card-body">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <form id="leaveForm" class="space-y-4" enctype="multipart/form-data" method="post"
                        action="{{ route('simpan.jurnal') }}">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hari</label>
                            <select
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                name="hari" id="hari">
                                <option value="">-- Pilih Hari --</option>
                                <option value="senin">Senin</option>
                                <option value="selasa">Selasa</option>
                                <option value="rabu">Rabu</option>
                                <option value="kamis">Kamis</option>
                                <option value="jumat">Jumat</option>
                                <option value="sabtu">Sabtu</option>
                                <option value="minggu">Minggu</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                            <input type="date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                name="tanggal">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kegiatan</label>
                            <input type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukan kegiatan anda" name="kegiatan">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                rows="3" placeholder="Detail pekerjaan yang di ambil ..." name="deskripsi"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Dokumentasi</label>
                            <input
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                type="file" name="foto" id="foto">
                            <small>*Opsional</small>
                        </div>
                        <button type="submit"
                            class="w-full bg-gradient-to-br from-purple-500 to-purple-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                            Simpan Jurnal Pekerjaan Harian Anda
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
