@extends('admin.layouts.app')
@section('title', 'User Management')
@section('pageTitle', 'User Management Overview')
@section('pageSubTitle', 'Selamat datang di panel admin sistem presensi')
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
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex items-center space-x-2 lg:space-x-4 w-full">
                            <div class="text-left hidden md:block">
                                <h2 class="text-2xl font-bold text-white drop-shadow">User Management</h2>
                                <p class="text-purple-100 text-sm mt-1">Manage your system users</p>
                            </div>
                        </div>
                        <button id="btnNewUser"
                            class="flex items-center space-x-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 lg:px-6 lg:py-3 rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 w-fit whitespace-nowrap">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="hidden sm:inline font-semibold">New User</span>
                        </button>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table id="jurnalTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-purple-400 via-pink-300 to-purple-500 text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left font-semibold">No</th>
                                    <th class="px-4 py-2 text-left font-semibold">Username</th>
                                    <th class="px-4 py-2 text-left font-semibold">Role</th>
                                    <th class="px-4 py-2 text-left font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($users as $user)
                                    <tr class="hover:bg-purple-50 transition duration-150">
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $user->username }}</td>
                                        <td class="px-4 py-2">{{ $user->role }}</td>
                                        <td class="px-4 py-2">
                                            <div class="flex gap-2">
                                                <!-- Edit Role Button -->
                                                <!-- Edit Role Button -->
                                                <button type="button"
                                                    class="text-blue-600 hover:text-blue-900 transition-colors duration-150 btn-edit-role"
                                                    data-id="{{ $user->id }}" data-username="{{ $user->username }}" data-role="{{ $user->role }}"
                                                    title="Edit Role">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M13 16H5v-1m0 0a6 6 0 1112 0m0 0v1m0-1a6 6 0 01-12 0m12-12V5m0 0a6 6 0 00-12 0m0 0v1m0-1a6 6 0 0112 0" />
                                                    </svg>
                                                </button>
                                                <!-- Reset Password Button -->
                                                <button type="button"
                                                    class="text-orange-600 hover:text-orange-900 transition-colors duration-150 btn-reset-password"
                                                    data-id="{{ $user->id }}" data-username="{{ $user->username }}"
                                                    title="Reset Password">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                                    </svg>
                                                </button>
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
    <!-- Edit Role Modal -->
    <div id="editRoleModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Edit Role User</h3>
            <form id="formEditRole" class="space-y-4">
                <input type="hidden" name="user_id" id="editRoleUserId">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" id="editRoleUsername" class="w-full px-3 py-2 border rounded-lg bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role" id="editRoleSelect" class="w-full px-3 py-2 border rounded-lg">
                        <option value="admin">Admin</option>
                        <option value="Pegawai Non-ASN">Pegawai Non-ASN</option>
                        <option value="Pegawai ASN">Pegawai ASN</option>
                        <option value="Analis SDM">Analis SDM</option>
                        <option value="Kepala Sekolah">Kepala Sekolah</option>
                        <option value="superadmin">Superadmin</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('editRoleModal')" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded bg-purple-600 text-white hover:bg-purple-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div id="resetPasswordModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Reset Password User</h3>
            <form id="formResetPassword" class="space-y-4">
                <input type="hidden" name="user_id" id="resetPasswordUserId">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" id="resetPasswordUsername" class="w-full px-3 py-2 border rounded-lg bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                    <input type="password" name="password" id="resetPasswordInput" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('resetPasswordModal')" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Reset</button>
                </div>
            </form>
        </div>
    </div>

    <!-- New User Modal -->
    <div id="newUserModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah User Baru</h3>
            <form id="formNewUser" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" name="username" id="newUserUsername" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="newUserEmail" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" id="newUserPassword" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role" id="newUserRole" class="w-full px-3 py-2 border rounded-lg" required>
                        <option value="admin">Admin</option>
                        {{-- <option value="pegawai">Pegawai</option> --}}
                        <option value="superadmin">Superadmin</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('newUserModal')" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @push('js')
        <script>
            $(document).ready(function () {
                var table = $('#jurnalTable').DataTable({
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

                // Modal helpers
                function showModal(id) {
                    $('#' + id).removeClass('hidden');
                }
                function closeModal(id) {
                    $('#' + id).addClass('hidden');
                }

                // New User Modal
                $('#btnNewUser').on('click', function() {
                    $('#newUserUsername').val('');
                    $('#newUserPassword').val('');
                    $('#newUserRole').val('pegawai');
                    showModal('newUserModal');
                });

                $('#formNewUser').on('submit', function(e) {
                    e.preventDefault();
                    var username = $('#newUserUsername').val();
                    var password = $('#newUserPassword').val();
                    var email = $('#newUserEmail').val();
                    var role = $('#newUserRole').val();
                    $.ajax({
                        url: "{{ route('user.management.store') }}",
                        type: "POST",
                        data: {
                            username: username,
                            password: password,
                            email: email,
                            role: role,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            closeModal('newUserModal');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message || 'User berhasil ditambahkan.',
                                confirmButtonColor: '#8b5cf6'
                            }).then(() => { location.reload(); });
                        },
                        error: function(xhr) {
                            closeModal('newUserModal');
                            let msg = 'Gagal menambah user.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: msg,
                                confirmButtonColor: '#ef4444'
                            });
                        }
                    });
                });

                // Edit Role Modal
                $('.btn-edit-role').on('click', function() {
                    $('#editRoleUserId').val($(this).data('id'));
                    $('#editRoleUsername').val($(this).data('username'));
                    $('#editRoleSelect').val($(this).data('role'));
                    showModal('editRoleModal');
                });

                $('#formEditRole').on('submit', function(e) {
                    e.preventDefault();
                    var userId = $('#editRoleUserId').val();
                    var role = $('#editRoleSelect').val();
                    $.ajax({
                        url: "{{ route('user.management.updateRole') }}",
                        type: "POST",
                        data: {
                            user_id: userId,
                            role: role,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            closeModal('editRoleModal');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message || 'Role berhasil diupdate.',
                                confirmButtonColor: '#8b5cf6'
                            }).then(() => { location.reload(); });
                        },
                        error: function(xhr) {
                            closeModal('editRoleModal');
                            let msg = 'Gagal update role.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: msg,
                                confirmButtonColor: '#ef4444'
                            });
                        }
                    });
                });

                // Reset Password Modal
                $('.btn-reset-password').on('click', function() {
                    $('#resetPasswordUserId').val($(this).data('id'));
                    $('#resetPasswordUsername').val($(this).data('username'));
                    $('#resetPasswordInput').val('');
                    showModal('resetPasswordModal');
                });

                $('#formResetPassword').on('submit', function(e) {
                    e.preventDefault();
                    var userId = $('#resetPasswordUserId').val();
                    var password = $('#resetPasswordInput').val();
                    $.ajax({
                        url: "{{ route('user.management.resetPassword') }}",
                        type: "POST",
                        data: {
                            user_id: userId,
                            password: password,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            closeModal('resetPasswordModal');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message || 'Password berhasil direset.',
                                confirmButtonColor: '#8b5cf6'
                            });
                        },
                        error: function(xhr) {
                            closeModal('resetPasswordModal');
                            let msg = 'Gagal reset password.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: msg,
                                confirmButtonColor: '#ef4444'
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
