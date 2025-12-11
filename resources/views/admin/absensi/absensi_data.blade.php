@extends('admin.layouts.app')
@section('title', 'Data Absensi')
@section('pageTitle', 'Data Absensi Overview')
@section('pageSubTitle', 'Menu untuk mengelola Data Absensi')
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
                                <h2 class="text-2xl font-bold text-white drop-shadow">Data Absensi</h2>
                                <p class="text-purple-100 text-sm mt-1">Manajemen Data Absensi</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Filter Form -->
                <div class="p-6">
                    <form id="filterAbsensiForm" class="flex flex-col md:flex-row gap-4 mb-6 items-end">
                        <div>
                            <label for="tanggalAwal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Awal</label>
                            <input type="date" id="tanggalAwal" name="tanggal_awal"
                                class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="tanggalAkhir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                            <input type="date" id="tanggalAkhir" name="tanggal_akhir"
                                class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <button type="submit"
                            class="bg-purple-600 text-white px-6 py-2 rounded-xl font-semibold shadow-md hover:bg-purple-700 transition flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Tampilkan</span>
                        </button>
                        <button type="button" id="refreshTableBtn"
                            class="bg-blue-500 text-white px-6 py-2 rounded-xl font-semibold shadow-md hover:bg-blue-700 transition flex items-center space-x-2 hidden">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582M20 20v-5h-.581M5 19a9 9 0 0014-14" />
                            </svg>
                            <span>Refresh</span>
                        </button>
                    </form>
                    <div class="overflow-x-auto">
                        <table id="absensiDataTable" class="min-w-full divide-y divide-gray-200 hidden">
                            <thead class="bg-gradient-to-r from-purple-400 via-pink-300 to-purple-500 text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left font-semibold">No</th>
                                    <th class="px-4 py-2 text-left font-semibold">Nama Pegawai</th>
                                    <th class="px-4 py-2 text-left font-semibold">NIK</th>
                                    <th class="px-4 py-2 text-left font-semibold">Tanggal</th>
                                    <th class="px-4 py-2 text-left font-semibold">Jam Masuk</th>
                                    <th class="px-4 py-2 text-left font-semibold">Jam Keluar</th>
                                    <th class="px-4 py-2 text-left font-semibold">Status</th>
                                    <th class="px-4 py-2 text-left font-semibold">Lokasi</th>
                                    <th class="px-4 py-2 text-left font-semibold">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                {{-- DataTable will fill here --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- Pagination bisa dihilangkan jika pakai datatable --}}
        {{-- <div class="mt-6 flex justify-center">
            {{ $jurnals->links('pagination::tailwind') }}
        </div> --}}
    </div>
    @push('js')
        <script>
            var table;
            $(document).ready(function () {
                // Hide table and refresh button on load
                $('#absensiDataTable').addClass('hidden');
                $('#refreshTableBtn').addClass('hidden');

                // Filter form submit
                $('#filterAbsensiForm').on('submit', function(e) {
                    e.preventDefault();
                    // Show table and refresh button
                    $('#absensiDataTable').removeClass('hidden');
                    $('#refreshTableBtn').removeClass('hidden');

                    // Inisialisasi DataTable jika belum ada
                    if (!$.fn.DataTable.isDataTable('#absensiDataTable')) {
                        table = $('#absensiDataTable').DataTable({
                            responsive: true,
                            language: {
                                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                            },
                            dom: 'Bfrtip',
                            buttons: [
                                { extend: 'copy', text: 'Copy' },
                                { extend: 'csv', text: 'CSV' },
                                {
                                    extend: 'excel',
                                    text: 'Excel',
                                    customize: function (xlsx) {
                                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                        $('row c', sheet).attr('s', '25'); // style 25: border all
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    text: 'PDF',
                                    customize: function (doc) {
                                        var objLayout = {};
                                        objLayout['hLineWidth'] = function(i) { return 0.5; };
                                        objLayout['vLineWidth'] = function(i) { return 0.5; };
                                        objLayout['hLineColor'] = function(i) { return '#aaa'; };
                                        objLayout['vLineColor'] = function(i) { return '#aaa'; };
                                        objLayout['paddingLeft'] = function(i) { return 4; };
                                        objLayout['paddingRight'] = function(i) { return 4; };
                                        doc.content[1].layout = objLayout;
                                    }
                                },
                                { extend: 'print', text: 'Print' },
                                { extend: 'colvis', text: 'Kolom' }
                            ],
                            ajax: {
                                url: "{{ route('absensi.get.data') }}",
                                data: function (d) {
                                    d.tanggal_awal = $('#tanggalAwal').val();
                                    d.tanggal_akhir = $('#tanggalAkhir').val();
                                }
                            },
                            columns: [
                                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                                { data: 'pegawai.nama_lengkap', name: 'pegawai.nama_lengkap' },
                                { data: 'pegawai.nik', name: 'pegawai.nik' },
                                { data: 'tanggal', name: 'tanggal' },
                                { data: 'jam_masuk', name: 'jam_masuk' },
                                { data: 'jam_pulang', name: 'jam_pulang' },
                                { data: 'status', name: 'status',
                                    render: function(data, type, row) {
                                        if(data === 'hadir') return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hadir</span>';
                                        if(data === 'terlambat') return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Terlambat</span>';
                                        return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">'+data+'</span>';
                                    }
                                },
                                { data: null, name: 'lokasi',
                                    render: function(data, type, row) {
                                        if(row.latitude && row.longitude) {
                                            return `<a href="https://maps.google.com/?q=${row.latitude},${row.longitude}" target="_blank" class="text-blue-600 hover:underline">Lihat Lokasi</a>`;
                                        }
                                        return '-';
                                    }
                                },
                                { data: 'jam_pulang', name: 'jam_pulang' },
                                { data: 'keterangan', name: 'keterangan', defaultContent: '-' }
                            ]
                        });

                        setTimeout(function () {
                            $('.dt-buttons button').addClass('bg-purple-500 hover:bg-purple-700 text-white font-semibold py-2 mb-2 px-4 rounded mx-1 shadow transition-all duration-200');
                            $('.dt-buttons button').removeClass('dt-button');
                        }, 100);
                    } else {
                        table.ajax.reload();
                    }
                });

                // Refresh button: reload datatable with current filter
                $('#refreshTableBtn').on('click', function() {
                    if (table) {
                        table.ajax.reload();
                    }
                });
            });
        </script>
    @endpush
@endsection
