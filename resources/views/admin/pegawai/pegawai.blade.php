@extends('admin.layouts.app')
@section('title', 'Pegawai')
@section('pageTitle', 'Pegawai Overview')
@section('pageSubTitle', 'Kelola data pegawai pada sistem sikawan')
@push('css')
    <style>
        .btn-tailwind {
            @apply bg-blue-500 text-white font-semibold px-3 py-1 rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400;
        }

        .dt-button {
            @apply !bg-transparent !border-0 !shadow-none;
            /* reset style bawaan */
        }
    </style>
@endpush
@section('content')
    <div id="dashboardSection" class="p-6">
        <!-- Header Actions -->
        <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between space-y-4 lg:space-y-0">
                <div>
                    <h3 class="text-lg lg:text-xl font-semibold text-gray-800 mb-2">Kelola Data Pegawai</h3>
                    <p class="text-gray-600 text-sm">Manajemen data pegawai, import/export, dan monitoring status
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                    <button onclick="showModal('importModal')"
                        class="flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10">
                            </path>
                        </svg>
                        Import Data
                    </button>
                    {{-- <button onclick="showModal('addEmployeeModal')"
                        class="flex items-center justify-center px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Pegawai
                    </button> --}}
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 lg:gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-sm p-4 lg:p-6 card-hover">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800" id="TotalPegawai">156</p>
                        <p class="text-sm text-gray-600">Total Pegawai</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 lg:p-6 card-hover">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800" id="TotalAktif">142</p>
                        <p class="text-sm text-gray-600">Aktif</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 lg:p-6 card-hover">
                <div class="flex items-center">
                    <div class="bg-red-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800" id="TotalNonAktif">6</p>
                        <p class="text-sm text-gray-600">Non-Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee Table -->
        <div class="bg-white p-3 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full" id="pegawaiTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pegawai</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                NIK</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                NIP</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jabatan</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Alamat</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No HP</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full text-center">
            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                    </path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Berhasil!</h3>
            <p id="successMessage" class="text-gray-600 mb-4">Jurnal berhasil disimpan</p>
            <button onclick="closeModal('successModal')"
                class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200">
                OK
            </button>
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl p-6 max-w-lg w-full">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Import Data Pegawai</h3>
                <button onclick="closeModal('importModal')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form id="importForm" class="space-y-6" enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload File Excel</label>
                    <div
                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors duration-200">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                            </path>
                        </svg>
                        <div class="text-sm text-gray-600">
                            <label for="file-upload"
                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                <span>Upload file</span>
                                <input id="file-upload" name="file" type="file" accept=".xlsx,.xls,.csv"
                                    class="sr-only">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Excel, CSV hingga 10MB</p>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm">
                            <p class="font-medium text-blue-800 mb-1">Format File:</p>
                            <p class="text-blue-700">Pastikan file Excel memiliki kolom: Nama, NIP, Email, Departemen,
                                Jabatan, Tanggal Bergabung</p>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <button type="button" onclick="downloadTemplate()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Download Template
                    </button>
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-green-600 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-green-700 hover:to-blue-700 transition-all duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10">
                            </path>
                        </svg>
                        Import Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Employee Modal -->
    <div id="addEmployeeModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl p-6 max-w-2xl w-full max-h-screen overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Tambah Pegawai Baru</h3>
                <button onclick="closeModal('addEmployeeModal')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form id="addEmployeeForm" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                        <input type="text" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Masukkan nama lengkap">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NIP *</label>
                        <input type="text" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Nomor Induk Pegawai">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="email@company.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                        <input type="tel"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Departemen *</label>
                        <select required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Departemen</option>
                            <option value="IT">IT</option>
                            <option value="HR">HR</option>
                            <option value="Finance">Finance</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Operations">Operations</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan *</label>
                        <input type="text" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Jabatan/Posisi">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Bergabung *</label>
                        <input type="date" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="active">Aktif</option>
                            <option value="inactive">Non-Aktif</option>
                            <option value="leave">Cuti</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Alamat lengkap"></textarea>
                </div>

                <div class="flex space-x-3">
                    <button type="button" onclick="closeModal('addEmployeeModal')"
                        class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-purple-600 to-blue-600 text-white px-4 py-3 rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Simpan Pegawai
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            // Employee management functions
            $(document).ready(function() {
                // Initialize DataTable
                var table = $('#pegawaiTable').DataTable({
                    ajax: {
                        url: "{{ route('pegawai.data') }}",
                    },
                    columns: [{
                            data: 'nama_lengkap',
                        },
                        {
                            data: 'nik'
                        },
                        {
                            data: 'nip'
                        },
                        {
                            data: 'user.email'
                        },
                        {
                            data: 'jabatan'
                        },
                        {
                            data: 'alamat'
                        },
                        {
                            data: 'no_hp'
                        },
                        {
                            data: 'status',
                            render: function(data) {
                                if (data === 1 || data === 'Aktif') {
                                    return `<span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aktif</span>`;
                                } else if (data === 'Cuti') {
                                    return `<span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Cuti</span>`;
                                } else if (data === 0 || data === 'Non Aktif' || data === 'Non-Aktif') {
                                    return `<span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Non Aktif</span>`;
                                } else {
                                    return `<span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">${data}</span>`;
                                }
                            }
                        },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    pageLength: 10,
                    lengthChange: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    innerWidth: true,
                    outerWidth: true,
                    autoWidth: false,
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'excelHtml5',
                            text: 'Excel',
                            className: 'bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200'
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            className: 'bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200'
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            className: 'bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200'
                        }
                    ]
                });

                table.on('xhr.dt', function(e, settings, json, xhr) {
                    if (json) {
                        $('#TotalPegawai').text(json.totalPegawai);
                        $('#TotalAktif').text(json.totalAktif);
                        $('#TotalNonAktif').text(json.totalNonAktif);
                    }
                });
            });
            $('#importForm').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const fileInput = $('#file-upload')[0];
                if (!fileInput.files.length) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Silakan pilih file untuk diimport!'
                    });
                    return;
                }

                const formData = new FormData(this);

                $.ajax({
                    url: "{{ route('pegawai.import') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Data pegawai berhasil diimport!'
                        });
                        closeModal('importModal');
                        $('#importForm')[0].reset();
                        window.location.reload();
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan pada server.'
                        });
                    }
                });
            });

            document.getElementById('addEmployeeForm').addEventListener('submit', function(e) {
                e.preventDefault();

                // Show success message
                document.getElementById('successMessage').textContent = 'Pegawai baru berhasil ditambahkan ke sistem!';
                showModal('successModal');
                closeModal('addEmployeeModal');

                // Reset form
                this.reset();
            });

            function exportEmployees() {
                // Create sample CSV data
                const csvData = [
                    ['Nama', 'NIP', 'Email', 'Departemen', 'Jabatan', 'Status', 'Tanggal Bergabung'],
                    ['Budi Santoso', 'EMP001', 'budi.santoso@company.com', 'IT', 'Senior Developer', 'Aktif',
                        '15 Jan 2022'
                    ],
                    ['Sari Dewi', 'EMP002', 'sari.dewi@company.com', 'HR', 'HR Manager', 'Cuti', '10 Mar 2021'],
                    ['Ahmad Rizki', 'EMP003', 'ahmad.rizki@company.com', 'Finance', 'Finance Analyst', 'Aktif',
                        '05 Jul 2023'
                    ],
                    ['Maya Putri', 'EMP004', 'maya.putri@company.com', 'Marketing', 'Marketing Specialist', 'Non-Aktif',
                        '20 Nov 2022'
                    ]
                ];

                // Convert to CSV string
                const csvContent = csvData.map(row => row.join(',')).join('\n');

                // Create and download file
                const blob = new Blob([csvContent], {
                    type: 'text/csv;charset=utf-8;'
                });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', 'data_pegawai_' + new Date().toISOString().split('T')[0] + '.csv');
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                // Show success message
                document.getElementById('successMessage').textContent = 'Data pegawai berhasil diexport ke file Excel!';
                showModal('successModal');
            }

            function downloadTemplate() {
                // Create template CSV data
                const templateData = [
                    ['Nama', 'NIK', 'NIP', 'Email', 'Jabatan', 'Alamat', 'NoHp'],
                    ['Contoh Nama', '9729837378362', '234325435345', 'contoh@gmail.com', 'Developer', 'Karangasem',
                        '098987768'
                    ]
                ];

                // Convert to CSV string
                const csvContent = templateData.map(row => row.join(',')).join('\n');

                // Create and download file
                const blob = new Blob([csvContent], {
                    type: 'text/csv;charset=utf-8;'
                });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', 'template_import_pegawai.csv');
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        </script>
    @endpush
@endsection
