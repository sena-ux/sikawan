@extends('admin.layouts.app')
@section('title', 'Laporan')
@section('pageTitle', 'Laporan Page')
@section('pageSubTitle', 'Cetak Laporan')
@section('content')
    @push('css')
        <style>
            body {
                box-sizing: border-box;
            }

            .fade-in {
                animation: fadeIn 0.5s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .glass-effect {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.9);
            }

            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .card-hover {
                transition: all 0.3s ease;
            }

            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            .sidebar-active {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }

            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #555;
            }

            .file-upload-wrapper {
                position: relative;
                overflow: hidden;
                display: inline-block;
                width: 100%;
            }

            .file-upload-input {
                position: absolute;
                left: -9999px;
            }

            .file-upload-label {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;
                border: 2px dashed #d1d5db;
                border-radius: 0.5rem;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .file-upload-label:hover {
                border-color: #8b5cf6;
                background-color: #f9fafb;
            }

            .file-name {
                font-size: 0.875rem;
                color: #6b7280;
                margin-top: 0.5rem;
            }
        </style>
    @endpush
    <div class="p-6 sm:p-8">
        <form id="leaveForm" class="space-y-6" enctype="multipart/form-data" method="post">

            <!-- Grid 2 Kolom -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <!-- Tanggal Awal -->
                <div class="fade-in">
                    <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Tanggal Awal
                    </label>
                    <input type="date"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- Tanggal Akhir -->
                <div class="fade-in">
                    <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Tanggal Akhir
                    </label>
                    <input type="date"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- Bulan Awal -->
                <div class="fade-in">
                    <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Bulan Awal
                    </label>
                    <select
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">-- Pilih Bulan --</option>
                        <option value="januari">Januari</option>
                        <option value="februari">Februari</option>
                        <option value="maret">Maret</option>
                        <option value="april">April</option>
                        <option value="mei">Mei</option>
                        <option value="juni">Juni</option>
                        <option value="juli">Juli</option>
                        <option value="agustus">Agustus</option>
                        <option value="september">September</option>
                        <option value="oktober">Oktober</option>
                        <option value="november">November</option>
                        <option value="desember">Desember</option>
                    </select>
                </div>

                <!-- Bulan Akhir -->
                <div class="fade-in">
                    <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Bulan Akhir
                    </label>
                    <select
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">-- Pilih Bulan --</option>
                        <option value="januari">Januari</option>
                        <option value="februari">Februari</option>
                        <option value="maret">Maret</option>
                        <option value="april">April</option>
                        <option value="mei">Mei</option>
                        <option value="juni">Juni</option>
                        <option value="juli">Juli</option>
                        <option value="agustus">Agustus</option>
                        <option value="september">September</option>
                        <option value="oktober">Oktober</option>
                        <option value="november">November</option>
                        <option value="desember">Desember</option>
                    </select>
                </div>

            </div>

            <!-- Tombol Aksi (Grid 2 Kolom) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
                <button type="button" id="btnAbsensi"
                    class="w-full bg-purple-600 text-white py-4 px-6 rounded-xl font-semibold shadow-md hover:bg-purple-700 transition flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Lihat Laporan Absensi</span>
                </button>

                <button type="button" id="btnJurnal"
                    class="w-full bg-purple-600 text-white py-4 px-6 rounded-xl font-semibold shadow-md hover:bg-purple-700 transition flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Lihat Laporan Jurnal Harian</span>
                </button>
            </div>

        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#btnAbsensi').on('click', function() {
            const form = $('#leaveForm');
            const params = {
                tanggal_awal: form.find('input[type="date"]').eq(0).val(),
                tanggal_akhir: form.find('input[type="date"]').eq(1).val(),
                bulan_awal: form.find('select').eq(0).val(),
                bulan_akhir: form.find('select').eq(1).val(),
                laporan: 'absensi'
            };
            const query = $.param(params);
            window.location.href = "{{ route('laporan.view') }}?" + query;
        });

        $('#btnJurnal').on('click', function() {
            const form = $('#leaveForm');
            const params = {
                tanggal_awal: form.find('input[type="date"]').eq(0).val(),
                tanggal_akhir: form.find('input[type="date"]').eq(1).val(),
                bulan_awal: form.find('select').eq(0).val(),
                bulan_akhir: form.find('select').eq(1).val(),
                laporan: 'jurnal'
            };
            const query = $.param(params);
            window.location.href = "{{ route('laporan.view') }}?" + query;
        });
    </script>
@endsection
