<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            {{ __('Contacts List') }}
        </h2>
    </x-slot>
    <div class=" mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif
        <div class="mr-4">
            <form method="GET" action="{{ route('contact.index') }}" class="relative justify-between flex items-center space-x-2 py-2">
                <!-- Search Input -->
                <div class="relative flex items-center w-full max-w-md">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="bi bi-search text-gray-500"></i>
                    </div>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        class="block w-70 pl-10 pr-12 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm transition duration-150 ease-in-out hover:border-blue-400"
                        placeholder="SEARCH" oninput="toggleResetButton()" />

                    <!-- Reset Button Inside Input -->
                    <a href="{{ route('contact.index') }}" id="reset-button" class="absolute inset-y-0 right-52 flex items-center pr-3 text-gray-500 hover:text-blue-500 hidden">
                        <i class="bi bi-x-circle"></i>
                    </a>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto flex justify-center">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Full Name</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Phone Number</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Message</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 border-b border-gray-300">{{ $contact->full_name }}</td>
                            <td class="px-6 py-4 border-b border-gray-300">{{ $contact->email }}</td>
                            <td class="px-6 py-4 border-b border-gray-300">{{ $contact->phone_number }}</td>
                            <td class="px-6 py-4 border-b border-gray-300">{{ $contact->message }}</td>
                            <td class="px-6 py-4 border-b border-gray-300 flex space-x-2 justify-center items-center">
                                @if($contact->status === 1)
                                <!-- Button to Open Modal -->
                                <!-- <button type="button" class="bg-blue-600 text-white px34 py-2 rounded-md hover:bg-blue-700 focus:outline-none"
                                        data-bs-toggle="modal" data-bs-target="#editContactModal{{ $contact->id }}" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button> -->
                                <form id="deleteForm{{ $contact->id }}" action="{{ route('contact.destroy', $contact->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-red-600 text-white hover:bg-red-500" onclick="confirmDelete('{{ $contact->id }}')" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @else
                                <form id="restoreForm{{ $contact->id }}" action="{{ route('contact.restore', $contact->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white hover:bg-green-500" onclick="confirmRestore('{{ $contact->id }}')" title="Restore">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editContactModal{{ $contact->id }}" tabindex="-1" aria-labelledby="editContactModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editContactModalLabel">Edit Contact</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('contact.update', $contact->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="full_name" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $contact->full_name }}" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ $contact->email }}" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="phone_number" class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $contact->phone_number }}" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="message" class="form-label">Message</label>
                                                <textarea class="form-control" id="message" name="message" rows="4" required>{{ $contact->message }}</textarea>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-success w-100 mt-3">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Edit Modal -->
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 px-4">
            <div class="flex items-center mb-2 md:mb-0">
                <form method="GET" action="{{ route('contact.index') }}" class="flex items-center">
                    <label for="per_page" class="mr-2 text-sm mt-2">Show</label>
                    <select name="per_page" id="per_page" class="border border-gray-300 rounded px-4 py-1 text-sm" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
                <span class="text-sm ml-2">of <strong>{{ $contacts->total() }}</strong> entries</span>
            </div>

            <div class="md:mt-0">
                <x-contact-pagination :contacts="$contacts" />
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: $('#deleteForm' + id).attr('action'),
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire('Deleted!', 'Product deleted successfully!', 'success').then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'Error deleting product: ' + xhr.responseText, 'error');
                }
            });
        }
    });
}

function confirmRestore(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to restore this product?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, restore it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Get the specific form action URL
            const form = document.getElementById('restoreForm' + id);
            const actionUrl = form.getAttribute('action');

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire('Restored!', 'Product restored successfully!', 'success').then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'Error restoring product: ' + xhr.responseText, 'error');
                }
            });
        }
    });
}


function toggleResetButton() {
    const searchInput = document.getElementById('search');
    const resetButton = document.getElementById('reset-button');

    if (searchInput.value) {
        resetButton.classList.remove('hidden'); // Show the reset button
    } else {
        resetButton.classList.add('hidden'); // Hide the reset button
    }
}
</script>