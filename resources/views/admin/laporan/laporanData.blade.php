@extends('admin.layouts.app')
@section('title', 'Laporan Data')
@section('pageTitle', 'Laporan Data Overview')
@section('pageSubTitle', 'Menu untuk mengelola Data Laporan Data Pegawai')
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
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex items-center space-x-2 lg:space-x-4 w-full">
                            <div class="text-left hidden md:block">
                                <h2 class="text-2xl font-bold text-white drop-shadow">Data Laporan Data Pegawai</h2>
                                <p class="text-purple-100 text-sm mt-1">Manajemen Data Laporan Data Pegawai</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Filter Form -->
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                    <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
                        <div class="text-center">
                            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Laporan Absensi</h4>
                            <p class="text-gray-600 text-sm mb-4">Generate laporan presensi bulanan</p>
                            <button type="button" id="btnLaporanAbsensi"
                                class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                Lihat Laporan
                            </button>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
                        <div class="text-center">
                            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Laporan Jurnal</h4>
                            <p class="text-gray-600 text-sm mb-4">Generate laporan Jurnal bulanan</p>
                            <button type="button" id="btnLaporanJurnal"
                                class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                                Lihat Laporan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Laporan Absensi -->
    <div id="modalLaporanAbsensi" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Laporan Absensi</h3>
            <form id="formLaporanAbsensi" class="space-y-4" method="get" action="{{ route('laporan.generate.data') }}">
                <input type="hidden" name="laporan" value="absensi">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                    <select name="bulan" id="bulanAbsensi" class="w-full px-3 py-2 border rounded-lg" required>
                        <option value="">-- Pilih Bulan --</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                    <input type="number" name="tahun" id="tahunAbsensi" min="2020" max="2099"
                        value="{{ date('Y') }}" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('modalLaporanAbsensi')"
                        class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded bg-purple-600 text-white hover:bg-purple-700">
                        Generate
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Laporan Jurnal -->
    <div id="modalLaporanJurnal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Laporan Jurnal</h3>
            <form id="formLaporanJurnal" class="space-y-4" method="get" action="{{ route('laporan.generate.data') }}">
                <input type="hidden" name="laporan" value="jurnal">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                    <select name="bulan" id="bulanJurnal" class="w-full px-3 py-2 border rounded-lg" required>
                        <option value="">-- Pilih Bulan --</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                    <input type="number" name="tahun" id="tahunJurnal" min="2020" max="2099"
                        value="{{ date('Y') }}" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('modalLaporanJurnal')"
                        class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">
                        Generate
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showModal(modalId) {
            $('#' + modalId).removeClass('hidden');
        }

        function closeModal(modalId) {
            $('#' + modalId).addClass('hidden');
        }

        $(document).ready(function() {
            // Button Laporan Absensi
            $('#btnLaporanAbsensi').on('click', function() {
                showModal('modalLaporanAbsensi');
            });

            // Button Laporan Jurnal
            $('#btnLaporanJurnal').on('click', function() {
                showModal('modalLaporanJurnal');
            });
        });
    </script>
    @endpush
@endsection
