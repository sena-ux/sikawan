@extends('admin.layouts.app')
@section('title', 'Jurnal Data')
@section('pageTitle', 'Jurnal Data Overview')
@section('pageSubTitle', 'Selamat datang di panel admin sistem presensi')
@section('content')
    <div class="p-6">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover fade-in">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-purple-500 via-pink-400 to-purple-600 px-6 py-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-30 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white drop-shadow">Jurnal Harian</h2>
                            <p class="text-purple-100 text-sm mt-1">Riwayat aktivitas pekerjaan harian Anda</p>
                        </div>
                    </div>
                    <a href="{{ route('main.jurnal') }}"
                        class="flex items-center gap-2 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-purple-600 hover:to-pink-500 text-white font-semibold px-5 py-3 rounded-xl shadow-lg hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Jurnal
                    </a>
                </div>
                <!-- Card Body -->
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table id="jurnalTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-purple-400 via-pink-300 to-purple-500 text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left font-semibold">Hari</th>
                                    <th class="px-4 py-2 text-left font-semibold">Tanggal</th>
                                    <th class="px-4 py-2 text-left font-semibold">Waktu</th>
                                    <th class="px-4 py-2 text-left font-semibold">Kegiatan</th>
                                    <th class="px-4 py-2 text-left font-semibold">Deskripsi</th>
                                    <th class="px-4 py-2 text-left font-semibold">Foto</th>
                                    <th class="px-4 py-2 text-left font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($jurnals as $jurnal)
                                    <tr class="hover:bg-purple-50 transition duration-150">
                                        <td class="px-4 py-2">{{ ucfirst($jurnal->hari) }}</td>
                                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d-m-Y') }}</td>
                                        <td class="px-4 py-2">{{ $jurnal->waktu }}</td>
                                        <td class="px-4 py-2">{{ $jurnal->kegiatan }}</td>
                                        <td class="px-4 py-2">{{ $jurnal->deskripsi }}</td>
                                        <td class="px-4 py-2">
                                            @if($jurnal->foto)
                                                <a href="{{ asset($jurnal->foto) }}" target="_blank">
                                                    <img src="{{ asset($jurnal->foto) }}" alt="{{ $jurnal->foto }}"
                                                        class="h-12 w-12 object-cover rounded shadow hover:scale-110 transition duration-200 border-2 border-purple-300">
                                                </a>
                                            @else
                                                <span class="text-gray-400 italic">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="flex gap-2">
                                                <a href="{{ route('jurnal.edit', encrypt($jurnal->id)) }}"
                                                    class="text-blue-500 hover:text-blue-700 transition-colors duration-150" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0L9 13zm-6 6v-3a2 2 0 012-2h3" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('jurnal.destroy', encrypt($jurnal->id)) }}" method="POST"
                                                    class="delete-jurnal-form" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="text-red-500 hover:text-red-700 btn-delete transition-colors duration-150"
                                                        title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada data jurnal.</td>
                                    </tr>
                                @endforelse
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
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.flash.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script> --}}
        <script>
            $(document).ready(function () {
                var table = $('#jurnalTable').DataTable({
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
                    ]
                });

                // Percantik tombol DataTable dengan Tailwind
                setTimeout(function () {
                    $('.dt-buttons button').addClass('bg-purple-500 hover:bg-purple-700 text-white font-semibold py-2 mb-2 px-4 rounded mx-1 shadow transition-all duration-200');
                    $('.dt-buttons button').removeClass('dt-button');
                }, 100);

                // SweetAlert for delete confirmation
                $('.btn-delete').on('click', function (e) {
                    e.preventDefault();
                    const form = $(this).closest('form');
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: 'Data jurnal yang dihapus tidak dapat dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
