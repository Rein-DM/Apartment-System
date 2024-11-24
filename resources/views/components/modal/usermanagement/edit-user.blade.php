<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm{{ $user->id }}" data-user-id="{{ $user->id }}" class="space-y-2">
                    @csrf
                    @method('PUT')
                    <div class="">
                        <div class="">
                            <label class="block text-gray-700 font-semibold mb-1">Name</label>
                            <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Name" value="{{ $user->name }}">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-2">
                            <label class="block text-gray-700 font-semibold mb-1">Role</label>
                            <select name="role" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="tenant" {{ $user->role == 'tenant' ? 'selected' : '' }}>Tenant</option>
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-2">
                            <label class="block text-gray-700 font-semibold mb-1">Email Address</label>
                            <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Email Address" value="{{ $user->email }}">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="mt-5 w-full bg-[#1B76B5] text-white font-bold py-2 px-4 rounded-md transition duration-200">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
