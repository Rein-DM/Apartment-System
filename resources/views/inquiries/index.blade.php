<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apartment Booking ') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-full mx-auto sm:px-4 lg:px-6">
            <!-- Success Message -->
            @if(session('success'))
                <div id="successMessage" class="bg-green-500 text-white p-2 rounded mb-4">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div id="errorMessage" class="bg-red-500 text-white p-2 rounded mb-4">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="min-h-full">
                <form method="GET" action="{{ route('inquiries.index') }}" class="relative justify-between flex items-center space-x-2 py-2">
                    <!-- Search Input -->
                    <div class="relative flex items-center w-full max-w-md">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="bi bi-search text-gray-500"></i>
                        </div>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            class="block w-70 pl-10 pr-12 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm transition duration-150 ease-in-out hover:border-blue-400"
                            placeholder="SEARCH" oninput="toggleResetButton()" />

                        <!-- Reset Button Inside Input -->
                        <a href="{{ route('inquiries.index') }}" id="reset-button" class="absolute inset-y-0 right-52 flex items-center pr-3 text-gray-500 hover:text-blue-500 hidden">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </div>
                </form>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-400">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Contact Number</th>
                                <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Room Number</th>
                                <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Valid Id</th>
                                <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Agreement</th>
                                <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">ACCEPTANCE</th>
                                <th class="px-4 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-400">
                            @foreach ($inquiries as $slot)
                            <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-black">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $slot->full_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $slot->contact_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $slot->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $slot->price }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $slot->room_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                    @if($slot->valid_id)
                                        <img src="{{ asset('storage/' . $slot->valid_id) }}" alt="Valid ID" class="h-10 w-10 object-cover">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                    {{ $slot->agreement == 1 ? 'YES' : 'NO' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                    <span class="{{ $slot->inquiry_status === 'pending' ? 'bg-yellow-500 text-black px-2 py-1 rounded' : ($slot->inquiry_status === 'Approved' ? 'bg-green-500 text-white px-2 py-1 rounded' : 'text-black') }}">
                                        {{ $slot->inquiry_status }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-black">
                                    <div class="flex space-x-2">
                                        @if($slot->status === 1)
                                        <form id="approveForm{{ $slot->id }}" action="{{ route('inquiries.approved', $slot->id) }}" method="POST">
                                            @csrf
                                            <button type="button" onclick="confirmAction('approveForm{{ $slot->id }}', 'Approved')" 
                                                    class="flex items-center justify-center w-10 h-10 text-white bg-gray-600 hover:bg-gray-500 rounded-full focus:outline-none" 
                                                    title="Mark as Approved">
                                                    <i class="bi bi-envelope-paper text-lg"></i>
                                            </button>
                                        </form>

                                        <button type="button" 
                                                class="flex items-center justify-center w-10 h-10 text-white bg-blue-600 hover:bg-blue-700 rounded-full focus:outline-none"
                                                data-bs-toggle="modal" data-bs-target="#editInquiryModal{{ $slot->id }}" 
                                                title="Edit">
                                            <i class="bi bi-pencil-square text-lg"></i>
                                        </button>

                                        <form id="deleteForm{{ $slot->id }}" action="{{ route('inquiries.destroy', $slot->id) }}" method="POST" class="delete-form inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    onclick="confirmDelete({{ $slot->id }})"
                                                    class="flex items-center justify-center w-10 h-10 text-white bg-red-600 hover:bg-red-700 rounded-full focus:outline-none" 
                                                    title="Delete">
                                                <i class="bi bi-trash3 text-lg"></i>
                                            </button>
                                        </form>
                                        @else
                                        <form id="restoreForm{{ $slot->id }}" action="{{ route('inquiries.restore', $slot->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white hover:bg-green-500" onclick="confirmRestore('{{ $slot->id }}')" title="Restore">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>    
                                </td>
                            </tr>
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editInquiryModal{{ $slot->id }}" tabindex="-1" aria-labelledby="editInquiryLabel{{ $slot->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editInquiryLabel{{ $slot->id }}">Edit Inquiry</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('inquiries.update', $slot->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="full_name{{ $slot->id }}" class="form-label">Full Name:</label>
                                                    <input type="text" id="full_name{{ $slot->id }}" name="full_name" class="form-control" value="{{ $slot->full_name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="contact_number{{ $slot->id }}" class="form-label">Contact Number:</label>
                                                    <input type="text" id="contact_number{{ $slot->id }}" name="contact_number" class="form-control" 
                                                        value="{{ $slot->contact_number }}" 
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11); validateContactNumber(this)" 
                                                        required>
                                                    <div class="invalid-feedback" id="contactNumberFeedback{{ $slot->id }}" style="display:none;">
                                                        Invalid number. It must start with 09 and have 11 digits.
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="email{{ $slot->id }}" class="form-label">Email:</label>
                                                    <input type="email" id="email{{ $slot->id }}" name="email" class="form-control" value="{{ $slot->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="price{{ $slot->id }}" class="form-label">Price:</label>
                                                    <input type="text" id="price{{ $slot->id }}" name="price" class="form-control" 
                                                        value="{{ $slot->price }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="room_number{{ $slot->id }}" class="form-label">Room Number:</label>
                                                    <input type="text" id="room_number{{ $slot->id }}" name="room_number" class="form-control" 
                                                        value="{{ $slot->room_number }}" required>
                                                </div>
                                                <!-- Agreement Checkbox -->
                                                <div class="mb-3 form-check">
                                                    <input type="hidden" name="agreement" value="0"> <!-- This will send '0' if unchecked -->
                                                    <input type="checkbox" class="form-check-input" id="agreement{{ $slot->id }}" name="agreement" value="1" {{ $slot->agreement == 1 ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="agreement{{ $slot->id }}">I agree to the terms and conditions. By using our service, you agree to our terms and conditions. Please read them carefully. I agree to the terms and conditions for the 1-month deposit and 1-month advance.</label>
                                                    <div class="invalid-feedback">
                                                        You must agree before submitting.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination Section -->
                    <div class="flex flex-col md:flex-row justify-between items-center mb-4 px-4">
                        <div class="flex items-center mb-2 md:mb-0">
                            <form method="GET" action="{{ route('inquiries.index') }}" class="flex items-center">
                                <label for="per_page" class="mr-2 text-sm mt-2">Show</label>
                                <select name="per_page" id="per_page" class="border border-gray-300 rounded px-4 py-1 text-sm" onchange="this.form.submit()">
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </form>
                            <span class="text-sm ml-2">of <strong>{{ $inquiries->total() }}</strong> entries</span>
                        </div>
                        <div class="md:mt-0">
                            <x-inquiry-pagination :inquiries="$inquiries" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- SweetAlert2 and Delete Confirmation Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm' + id).submit();
        }
    });
}

function confirmRestore(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to restore this inquiry?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, restore it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Use Fetch API or AJAX to submit the form
            fetch(document.getElementById('restoreForm' + id).action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({}) // Send any necessary data
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Restored!', 'Inquiry restored successfully!', 'success')
                    .then(() => {
                        // Reload the page to reflect the changes
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message || 'Something went wrong.', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Could not restore inquiry.', 'error');
            });
        }
    });
}

function confirmAction(formId, action) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to " + action + " this inquiry?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, ' + action + ' it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit(); // Submit the form
        }
    });
}


// Preview image function
function previewImage(event, previewId) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        const preview = document.getElementById(previewId);
        preview.src = e.target.result;
        preview.style.display = 'block';
    }

    if (file) {
        reader.readAsDataURL(file);
    }
}
window.onload = function() {
    const successMessage = document.getElementById('successMessage');
    if (successMessage) {
        // Set a timeout to fade out the message after 3 seconds
        setTimeout(() => {
            successMessage.style.transition = "opacity 0.5s ease";
            successMessage.style.opacity = 0;
            // Remove the message from the DOM after fading out
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 500); // 500ms should match the duration of the CSS transition
        }, 3000); // 3 seconds
    }
};
</script>
