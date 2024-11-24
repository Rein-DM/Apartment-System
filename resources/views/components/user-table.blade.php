<div class="w-full">
    <!-- Success Message -->
    <x-modal.usermanagement.add-user />
    <div class="min-h-full">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-400">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Message</th>
                        <th class="px-4 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-400">
                    @foreach ($users as $user)
                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-black">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $user->role }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                            @if ($user->is_past_due)
                                <span class="text-red-500">"Past Due"</span>
                            @endif
                            {{ $user->due_date ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $user->reminder_status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                            <div class="flex space-x-2">
                                @if($user->status === 1)
                                <!-- Reminders Button -->
                                <button type="button" onclick="confirmAction('{{ route('reminder.reminder', $user->id) }}', 'Reminders')" 
                                        class="flex items-center justify-center w-10 h-10 text-white bg-gray-600 hover:bg-gray-500 rounded-full focus:outline-none" 
                                        title="Mark as Preparing">
                                    <i class="bi bi-chat-square-dots text-lg"></i>
                                </button>

                                <!-- Edit Button -->
                                <button type="button" 
                                        class="flex items-center justify-center w-10 h-10 text-white bg-blue-600 hover:bg-blue-700 rounded-full focus:outline-none"
                                        data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}" 
                                        title="Edit">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </button>

                                <!-- Set Due Date Button -->
                                <button type="button" 
                                        class="flex items-center justify-center w-10 h-10 text-white bg-yellow-500 hover:bg-yellow-600 rounded-full focus:outline-none" 
                                        data-bs-toggle="modal" data-bs-target="#setDueDateModal{{ $user->id }}" 
                                        title="Set Due Date">
                                    <i class="bi bi-calendar-event text-lg"></i>
                                </button>

                                <!-- Delete Button -->
                                <form id="deleteForm{{ $user->id }}" action="{{ route('usermanagement.destroy', $user->id) }}" method="POST" class="delete-form inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="confirmDelete({{ $user->id }})"
                                            class="flex items-center justify-center w-10 h-10 text-white bg-red-600 hover:bg-red-700 rounded-full focus:outline-none delete-button" 
                                            title="Delete">
                                        <i class="bi bi-trash3 text-lg"></i>
                                    </button>
                                </form>
                                @else
                                <form id="restoreForm{{ $user->id }}" action="{{ route('usermanagement.restore', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white hover:bg-green-500" onclick="confirmRestore('{{ $user->id }}')" title="Restore">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>    
                        </td>
                    </tr>
                    <!-- Modal for Setting Due Date -->
                    <div class="modal fade" id="setDueDateModal{{ $user->id }}" tabindex="-1" aria-labelledby="setDueDateLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="setDueDateLabel{{ $user->id }}">Set Due Date for {{ $user->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('usermanagement.setDueDate', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <label for="due_date{{ $user->id }}" class="form-label">Due Date:</label>
                                        <input type="date" id="due_date{{ $user->id }}" name="due_date" class="form-control" value="{{ $user->due_date }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Due Date</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
     <!-- Pagination Section -->
     <div class="flex flex-col md:flex-row justify-between items-center mb-4 px-4">
        <div class="flex items-center mb-2 md:mb-0">
            <form method="GET" action="{{ route('usermanagement') }}" class="flex items-center">
                <label for="per_page" class="mr-2 text-sm mt-2">Show</label>
                <select name="per_page" id="per_page" class="border border-gray-300 rounded px-4 py-1 text-sm" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
            </form>
            <span class="text-sm ml-2">of <strong>{{ $users->total() }}</strong> entries</span>
        </div>
        <div class="md:mt-0">
            <x-user-pagination :users="$users" />
        </div>
    </div>
</div>


<!-- Modals for Edit User -->
@foreach ($users as $user)
    @include('components.modal.usermanagement.edit-user', ['user' => $user])
@endforeach

<!-- SweetAlert2 and Delete Confirmation Script -->
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
            // Locate the specific form based on the given ID
            const form = document.getElementById('deleteForm' + id);
            const actionUrl = form.getAttribute('action');

            $.ajax({
                url: actionUrl,
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

function confirmAction(actionUrl, actionName) {
    Swal.fire({
        title: `Are you sure you want to mark as ${actionName}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = actionUrl; // URL passed from the button's onclick
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}'; // Laravel CSRF token
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();

            // Show success message after form submission
            Swal.fire({
                title: 'Success!',
                text: `Order marked as ${actionName} successfully.`,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                timer: 2000, // Optional: Auto close after 2 seconds
                willClose: () => {
                    // Reload the page to see the changes after success
                    location.reload();
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
            $.ajax({
                url: $('#restoreForm' + id).attr('action'),
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
</script>
