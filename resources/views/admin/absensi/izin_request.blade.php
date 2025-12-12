@extends('admin.layouts.app')
@section('title', 'Persetujuan Izin Pegawai')
@section('pageTitle', 'Persetujuan Izin Pegawai Overview')
@section('pageSubTitle', 'Menu untuk mengelola persetujuan izin pegawai')
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
                                <h2 class="text-2xl font-bold text-white drop-shadow">Persetujuan Izin Pegawai</h2>
                                <p class="text-purple-100 text-sm mt-1">Manajemen Izin Pegawai</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table id="izinRequestTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-purple-400 via-pink-300 to-purple-500 text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left font-semibold">No</th>
                                    <th class="px-4 py-2 text-left font-semibold">Nama Lengkap</th>
                                    <th class="px-4 py-2 text-left font-semibold">NIK</th>
                                    <th class="px-4 py-2 text-left font-semibold">Keterangan</th>
                                    <th class="px-4 py-2 text-left font-semibold">Tanggal</th>
                                    <th class="px-4 py-2 text-left font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($izinRequests as $izinRequest)
                                    <tr class="hover:bg-purple-50 transition duration-150">
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $izinRequest->nama_lengkap }}</td>
                                        <td class="px-4 py-2">{{ $izinRequest->nik }}</td>
                                        <td class="px-4 py-2">{{ $izinRequest->keterangan }}</td>
                                        <td class="px-4 py-2">{{ $izinRequest->tanggal }}</td>
                                        <td class="px-4 py-2">
                                            <div class="flex gap-2">
                                                <button type="button"
                                                    class="text-blue-600 hover:text-blue-900 transition-colors duration-150 btn-edit-role"
                                                    onclick="window.location.href = '{{ route('absensi.izin.request.detail', ['id' => encrypt($izinRequest->id)]) }}'"
                                                    title="Lihat Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
            $(document).ready(function () {
                var table = $('#izinRequestTable').DataTable({
                    responsive: true,
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                    },
                    // dom: 'Bfrtip',
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
                    ]
                });

                // Percantik tombol DataTable dengan Tailwind
                setTimeout(function () {
                    $('.dt-buttons button').addClass('bg-purple-500 hover:bg-purple-700 text-white font-semibold py-2 mb-2 px-4 rounded mx-1 shadow transition-all duration-200');
                    $('.dt-buttons button').removeClass('dt-button');
                }, 100);
            });
        </script>
    @endpush
@endsection
