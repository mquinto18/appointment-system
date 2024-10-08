@extends('layouts.app')

@section('title', 'Admin')

@section('contents')

<div>
    <h1 class='font-medium text-2xl ml-3'>Administrator</h1>
</div>
<div class='w-full h-32 mt-5 rounded-lg' style="background: linear-gradient(to bottom, #0074C8, #151A5C);"></div>

<div class='mx-10 -mt-16'>
    <div class='flex justify-between mb-2'>
        <span class='text-[20px] text-white font-medium'>All Admins | {{$totalAdmins}} </span>
        <div class='bg-white px-3 py-2 rounded-md cursor-pointer' data-bs-toggle="modal" data-bs-target="#addAdminModal">
            <i class="fa-solid fa-plus" style="color: #0074CB;"></i>
            <!-- Button trigger modal -->
            <a href="#" class='font-medium no-underline text-black' >Add new admin</a>
        </div>
    </div>
    <div class='bg-white w-full rounded-lg shadow-md p-8'>
        <div class="overflow-x-auto">
            <!-- Search bar -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <select name="records_per_page" class="border border-gray-300 p-2 rounded">
                        <option value="5">5 records per page</option>
                        <option value="10">10 records per page</option>
                    </select>
                </div>
                <div class="flex items-center">
                    <!-- Search form -->
                    <form method="GET" action="">
                        <input type="text" name="search" value="{{ request('search') }}" class="border border-gray-300 p-2 rounded" placeholder="Search">
                        <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Search</button>
                    </form>
                </div>
            </div>
            
            <!-- Check if there are admins -->
            @if($admins->count() > 0)
                <!-- Table -->
                <table id='myTable' class="min-w-full bg-white border mt-3">
                    <thead>
                        <tr class="text-left">
                            <th class="py-3 px-4 border-b">ID</th>
                            <th class="py-3 px-4 border-b">Name</th>
                            <th class="py-3 px-4 border-b">Email</th>
                            <th class="py-3 px-4 border-b">Gender</th>
                            <th class="py-3 px-4 border-b">Role Type</th>
                            <th class="py-3 px-4 border-b">Date added</th>
                            <th class="py-3 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                        <tr class="hover:bg-gray-100">
                            <td class="py-3 px-4 border-b">{{ $loop->iteration + ($admins->currentPage() - 1) * $admins->perPage() }}</td>
                            <td class="py-3 px-4 border-b">{{ $admin->name }}</td>
                            <td class="py-3 px-4 border-b">{{ $admin->email }}</td>
                            <td class="py-3 px-4 border-b">{{ ucfirst($admin->gender) }}</td>
                            <td class="py-3 px-4 border-b">{{ $admin->type == 1 ? 'Admin' : 'User' }}</td>
                            <td class="py-3 px-4 border-b">{{ $admin->created_at->format('F d, Y') }}</td>
                            <td class="py-3 px-4 border-b flex gap-2">
                                <!-- View Action -->
                                <div class='relative group'>
                                    <div class='bg-white py-1 px-2 border border-[#0074CB] rounded-md'>
                                        <a href="" class="text-blue-600">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </div>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-700 text-white text-xs rounded-md py-1 px-2">
                                        View
                                    </div>
                                </div>
                                <!-- Edit Action -->
                                <div class='relative group'>
                                    <div class='bg-white py-1 px-2 border border-[#0074CB] rounded-md'>
                                        <a href="" class="text-blue-600">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                    </div>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-700 text-white text-xs rounded-md py-1 px-2">
                                        Edit
                                    </div>
                                </div>
                                <!-- Delete Action -->
                                <div class='relative group'>
                                    <button type="button" class='bg-white py-1 px-2 border border-[#0074CB] rounded-md text-blue-600' onclick="openDeleteModal('{{ $admin->name }}', '{{ route('admin.delete', $admin->id) }}')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-700 text-white text-xs rounded-md py-1 px-2">
                                        Delete
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $admins->appends(['search' => request('search')])->links() }}
                </div>
            @else
                <!-- If no admins found -->
                <div class="text-center text-gray-500">
                    <p>No admins found.</p>
                </div>
            @endif

        </div>
    </div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 900px;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addAdminModalLabel">Add New Admin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" action="{{ route('admin.save') }}">
            @csrf
            <div class="modal-body">
            <div class="row">
                <!-- Admin Name -->
                <div class="mb-3 col-md-4">
                <label for="adminName" class="form-label">Name</label>
                <input type="text" class="form-control" id="adminName" name="name" required>
                </div>

                <!-- Admin Email -->
                <div class="mb-3 col-md-4">
                <label for="adminEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="adminEmail" name="email" required>
                </div>

                <!-- Admin Password -->
                <div class="mb-3 col-md-4">
                <label for="adminPassword" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="adminPassword" name="password" required>
                    <button type="button" class="btn btn-outline-secondary" id="generatePasswordBtn">Generate</button>
                    <button type="button" class="btn btn-outline-secondary" id="togglePasswordBtn"><i class="fa-solid fa-eye"></i></button>
                </div>
                </div>
            </div>

            <div class="row">
                <!-- Date of Birth -->
                <div class="mb-3 col-md-4">
                <label for="adminDOB" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="adminDOB" name="date_of_birth">
                </div>

                <!-- Admin Gender -->
                <div class="mb-3 col-md-4">
                <label for="adminGender" class="form-label">Gender</label>
                <select class="form-select" id="adminGender" name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                </div>

                <!-- Admin Phone Number -->
                <div class="mb-3 col-md-4">
                <label for="adminPhone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="adminPhone" name="phone_number">
                </div>
            </div>

            <div class="row">
                <!-- Admin Address -->
                <div class="mb-3 col-md-4">
                <label for="adminAddress" class="form-label">Address</label>
                <textarea class="form-control" id="adminAddress" name="address" rows="3"></textarea>
                </div>

                <!-- Admin Role -->
                <div class="mb-3 col-md-4">
                <label for="adminRole" class="form-label">Role</label>
                <select class="form-select" id="adminRole" name="type" disabled>
                    <option value="1" selected>Admin</option>
                </select>
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save Admin</button>
            </div>
        </form>
        </div>
    </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-0">
                <div class="modal-body text-center mb-5 mx-4">
                    <i class="fa-solid fa-triangle-exclamation text-[55px] my-4" style="color: #ff0000;"></i>
                    <h5 class="modal-title mb-3 text-[25px] font-bold" id="deleteAdminModalLabel">Delete Administrator</h5>
                    <p id="deleteAdminMessage">Are you sure you want to delete <strong></strong>? Once deleted, it cannot be recovered.</p>
                </div>
                <div class=" p-0 m-0">
                    <div class='flex w-full'>
                        <button type="button" class="btn btn-secondary w-1/2 p-3 m-0 border-0 rounded-0" data-bs-dismiss="modal">Cancel</button>
                        <form id="deleteAdminForm" method="POST" action="" class="w-1/2 m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-full p-3 m-0 border-0 rounded-0">Yes, Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Admin Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAdminModalLabel">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editAdminForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <!-- Admin Name -->
                        <div class="mb-3 col-md-4">
                            <label for="editAdminName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editAdminName" name="name" required>
                        </div>

                        <!-- Admin Email -->
                        <div class="mb-3 col-md-4">
                            <label for="editAdminEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editAdminEmail" name="email" required>
                        </div>

                        <!-- Admin Password -->
                        <div class="mb-3 col-md-4">
                            <label for="editAdminPassword" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="editAdminPassword" name="password">
                                <button type="button" class="btn btn-outline-secondary" id="editGeneratePasswordBtn">Generate</button>
                                <button type="button" class="btn btn-outline-secondary" id="editTogglePasswordBtn"><i class="fa-solid fa-eye"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Date of Birth -->
                        <div class="mb-3 col-md-4">
                            <label for="editAdminDOB" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="editAdminDOB" name="date_of_birth">
                        </div>

                        <!-- Admin Gender -->
                        <div class="mb-3 col-md-4">
                            <label for="editAdminGender" class="form-label">Gender</label>
                            <select class="form-select" id="editAdminGender" name="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Admin Phone Number -->
                        <div class="mb-3 col-md-4">
                            <label for="editAdminPhone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="editAdminPhone" name="phone_number">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Admin Address -->
                        <div class="mb-3 col-md-4">
                            <label for="editAdminAddress" class="form-label">Address</label>
                            <textarea class="form-control" id="editAdminAddress" name="address" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script>
        function openDeleteModal(adminName, deleteUrl) {
            // Set the admin name and form action dynamically
            document.getElementById('deleteAdminMessage').querySelector('strong').textContent = adminName;
            document.getElementById('deleteAdminForm').action = deleteUrl;
            // Show the modal
            const deleteAdminModal = new bootstrap.Modal(document.getElementById('deleteAdminModal'));
            deleteAdminModal.show();
        }
    </script>

    <script>
        document.getElementById('generatePasswordBtn').addEventListener('click', function() {
            const password = generateRandomPassword();
            document.getElementById('adminPassword').value = password;
        });

        document.getElementById('togglePasswordBtn').addEventListener('click', function() {
            const passwordInput = document.getElementById('adminPassword');
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type; // Toggle password visibility
        });

        function generateRandomPassword(length = 12) {
            const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+";
            let password = "";
            for (let i = 0; i < length; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return password;
        }
    </script>



@endsection