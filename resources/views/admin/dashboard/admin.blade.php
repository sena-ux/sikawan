@php
    $totalPegawai = DB::table('t_pegawai')->count();
    $hadirHariIni = DB::table('t_absensi')
        ->whereDate('tanggal', now()->toDateString())
        ->where('status', 'hadir')
        ->count();
    $totalIzinHariIni = DB::table('t_izin')->whereDate('tanggal', now()->toDateString())->count();
    $totalJurnalHariIni = DB::table('t_jurnal')->whereDate('tanggal', now()->toDateString())->count();
@endphp
<!-- Dashboard Section -->
<div id="dashboardSection" class="p-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white card-hover fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Pegawai</p>
                    <p class="text-3xl font-bold">{{ $totalPegawai }}</p>
                    <p class="text-blue-100 text-sm mt-1">+12 bulan ini</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white card-hover fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Hadir Hari Ini</p>
                    <p class="text-3xl font-bold">{{ $hadirHariIni }}</p>
                    <p class="text-green-100 text-sm mt-1">91% kehadiran</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl p-6 text-white card-hover fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Izin/Cuti</p>
                    <p class="text-3xl font-bold">{{ $totalIzinHariIni }}</p>
                    <p class="text-yellow-100 text-sm mt-1">5% dari total</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white card-hover fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Jurnal Harian</p>
                    <p class="text-3xl font-bold">{{ $totalJurnalHariIni }}</p>
                    <p class="text-purple-100 text-sm mt-1">4% dari total</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Activity -->
    {{-- <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-8 mb-6 lg:mb-8">
        <!-- Attendance Chart -->
        <div class="lg:col-span-2 bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6 card-hover">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 lg:mb-6 space-y-2 sm:space-y-0">
                <h3 class="text-lg lg:text-xl font-semibold text-gray-800">Grafik Kehadiran Mingguan</h3>
                <div class="flex space-x-2">
                    <button
                        class="px-2 lg:px-3 py-1 bg-blue-100 text-blue-600 rounded-lg text-xs lg:text-sm font-medium">7
                        Hari</button>
                    <button
                        class="px-2 lg:px-3 py-1 text-gray-500 rounded-lg text-xs lg:text-sm font-medium hover:bg-gray-100">30
                        Hari</button>
                </div>
            </div>
            <div class="h-64 lg:h-80">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6 card-hover">
            <h3 class="text-lg lg:text-xl font-semibold text-gray-800 mb-4 lg:mb-6">Aktivitas Terbaru</h3>
            <div class="space-y-3 lg:space-y-4 custom-scrollbar max-h-64 lg:max-h-80 overflow-y-auto">
                <div class="flex items-start space-x-3 p-3 bg-green-50 rounded-xl">
                    <div class="bg-green-500 w-3 h-3 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">Budi Santoso check-in</p>
                        <p class="text-xs text-gray-500">08:15 WIB - Kantor Pusat</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-3 bg-red-50 rounded-xl">
                    <div class="bg-red-500 w-3 h-3 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">Sari Dewi terlambat</p>
                        <p class="text-xs text-gray-500">08:45 WIB - Terlambat 15 menit</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-3 bg-yellow-50 rounded-xl">
                    <div class="bg-yellow-500 w-3 h-3 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">Ahmad Rizki mengajukan cuti</p>
                        <p class="text-xs text-gray-500">07:30 WIB - Cuti sakit 2 hari</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-xl">
                    <div class="bg-blue-500 w-3 h-3 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">Maya Putri check-out</p>
                        <p class="text-xs text-gray-500">17:30 WIB - Kerja 9 jam</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">
        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-800 mb-2">Tambah Pegawai</h4>
                <p class="text-gray-600 text-sm mb-4">Daftarkan pegawai baru ke sistem</p>
                <button onclick="window.location='{{ route('pegawai') }}'"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    Kelola Pegawai
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
                <h4 class="text-lg font-semibold text-gray-800 mb-2">Buat Laporan</h4>
                <p class="text-gray-600 text-sm mb-4">Generate laporan presensi bulanan</p>
                <button onclick="window.location='{{ route('laporan.data') }}'"
                    class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                    Lihat Laporan
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="text-center">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-800 mb-2">Jurnal Harian</h4>
                <p class="text-gray-600 text-sm mb-4">Kelola jurnal aktivitas harian</p>
                <button onclick="window.location='{{ route('jurnal.manage.data') }}'"
                    class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition-colors duration-200">
                    Buka Jurnal
                </button>
            </div>
        </div>
    </div>
</div>
