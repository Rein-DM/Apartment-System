<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Payments') }}
        </h2>
    </x-slot>
    <div class="mx-auto px-4 py-6">
        @if(session('success'))
            <div id="successMessage" class="bg-green-500 text-white p-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        <div class="flex justify-between items-center mb-1">
            <!-- Search Form -->
            <form method="GET" action="{{ route('payments.index') }}" class="relative flex items-center space-x-2 w-full max-w-md">
                <!-- Search Input -->
                <div class="relative flex items-center w-full max-w-md">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="bi bi-search text-gray-500"></i>
                    </div>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        class="block w-70 pl-10 pr-12 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm transition duration-150 ease-in-out hover:border-blue-400"
                        placeholder="SEARCH" oninput="toggleResetButton()" />

                    <!-- Reset Button Inside Input -->
                    <a href="{{ route('payments.index') }}" id="reset-button" class="absolute inset-y-0 right-52 flex items-center pr-3 text-gray-500 hover:text-blue-500 hidden">
                        <i class="bi bi-x-circle"></i>
                    </a>
                </div>
            </form>

            <!-- Right-side Actions -->
            <div class="flex items-center space-x-2">
                <button type="button" class="btn btn-primary whitespace-nowrap" data-toggle="modal" data-target="#createModal">
                    <i class="bi bi-plus"></i> Add Payment
                </button>
                <x-sales.filter-date />
            </div>
        </div>

        <div class="overflow-x-auto flex justify-center">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Full Name</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Phone Number</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Payment Method</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Due Date</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Proof of Billing</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr class="hover:bg-gray-1000">
                            <td class="px-6 py-4 border-b border-gray-300">{{ $payment->full_name }}</td>
                            <td class="px-6 py-4 border-b border-gray-300">{{ $payment->phone_number }}</td>
                            <td class="px-6 py-4 border-b border-gray-300">{{ $payment->amount }}</td>
                            <td class="px-6 py-4 border-b border-gray-300">{{ $payment->payment_method }}</td>
                            <td class="px-6 py-4 border-b border-gray-300">
                                @php
                                    $dueDates = json_decode($payment->due_date, true); // Decode the JSON string
                                @endphp

                                @if($dueDates && is_array($dueDates))
                                    {{ implode(', ', $dueDates) }}
                                @else
                                    No due dates set
                                @endif
                            </td>

                            <td class="px-6 py-4 border-b border-gray-300">
                                <img src="{{ asset('storage/' . $payment->qr_code) }}" alt="Proof of Billing" class="h-10">
                            </td>
                            <td class="py-3 flex space-x-2 justify-center items-center">
                                <!-- Edit Button -->
                                @if($payment->status === 1)
                                <button class="bg-yellow-500 text-white px-3 py-2 rounded-md hover:bg-yellow-600 focus:outline-none"
                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-full-name="{{ $payment->full_name }}"
                                        data-phone-number="{{ $payment->phone_number }}"
                                        data-amount="{{ $payment->amount }}"
                                        data-payment-method="{{ $payment->payment_method }}"
                                        data-due-dates="{{ is_array(json_decode($payment->due_date)) ? implode(',', json_decode($payment->due_date)) : '' }}"
                                        data-qr-code="{{ asset('storage/' . $payment->qr_code) }}"
                                        data-payment-id="{{ $payment->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Delete Button with SweetAlert Confirmation -->
                                <form id="deleteForm{{ $payment->id }}" action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="bg-red-600 text-white px-3 py-2 rounded-md hover:bg-red-700 focus:outline-none"
                                            onclick="confirmDelete('{{ $payment->id }}')">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                                @else
                                <!-- Restore Button with SweetAlert Confirmation -->
                                <form id="restoreForm{{ $payment->id }}" action="{{ route('payments.restore', $payment->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white hover:bg-green-500"
                                            onclick="confirmRestore('{{ $payment->id }}')" title="Restore">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form id="editForm" method="POST" enctype="multipart/form-data" action="{{ route('payments.update', $payment) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body overflow-auto max-h-96 overflow-y-auto">
                                            <div class="form-group mb-3">
                                                <label for="editFullName">Full Name</label>
                                                <input type="text" class="form-control" name="full_name" value="{{ old('full_name', $payment->full_name) }}" required>
                                                @error('full_name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="editPhoneNumber">Phone Number</label>
                                                <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number', $payment->phone_number) }}"   oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,11)" required>
                                                @error('phone_number')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="editAmountPaid">Amount Paid</label>
                                                <input type="number" class="form-control" name="amount" value="{{ old('amount', $payment->amount) }}" required>
                                                @error('amount')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Payment Method</label>
                                                <select id="editPaymentMethod" class="form-select" name="payment_method" required>
                                                    <option value="GCASH" {{ $payment->payment_method == 'GCASH' ? 'selected' : '' }}>GCASH</option>
                                                    <option value="MAYA" {{ $payment->payment_method == 'MAYA' ? 'selected' : '' }}>MAYA</option>
                                                </select>
                                            </div>
                                             <!-- Due Date Dropdown -->
                                            <div class="mb-3">
                                                <label class="font-bold text-sm mb-2 ml-1">Select Due Date</label>
                                                <select name="due_date[]" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" multiple required size="5">
                                                    <option disabled>Select one or more due dates</option>
                                                    @foreach($dueDates as $date)
                                                        <option value="{{ $date }}">{{ $date }}</option>
                                                    @endforeach
                                                    <option disabled>────── Past Due Dates ──────</option>
                                                    @foreach($pastDueDates as $date)
                                                        <option value="{{ $date }}">{{ $date }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="editQRCode">Upload New Proof of Billing</label>
                                                <input type="file" class="form-control" name="qr_code" accept="image/*" onchange="previewImage(event, 'editQRCodePreview')">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Current Proof of Billing:</label>
                                                @if ($payment->qr_code)
                                                    <img src="{{ asset('storage/' . $payment->qr_code) }}" alt="Proof of Billing" class="img-fluid mt-2" style="max-height: 150px;">
                                                @else
                                                    <p>No Proof of Billing uploaded.</p>
                                                @endif
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">New Proof of Billing Preview:</label>
                                                <img id="editQRCodePreview" src="" alt="New Proof of Billing Preview" class="img-fluid" style="display: none; max-width: 100px; margin-top: 10px;">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update Payment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 px-4">
            <div class="flex items-center mb-2 md:mb-0">
                <form method="GET" action="{{ route('payments.index') }}" class="flex items-center">
                    <label for="per_page" class="mr-2 text-sm mt-2">Show</label>
                    <select name="per_page" id="per_page" class="border border-gray-300 rounded px-4 py-1 text-sm" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
                <span class="text-sm ml-2">of <strong>{{ $payments->total() }}</strong> entries</span>
            </div>

            <div class="md:mt-0">
                <x-payment-pagination :payments="$payments" />
            </div>
        </div>
    </div>

    <!-- Create Payment Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Add Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body overflow-auto max-h-96 overflow-y-auto">
                        <div class="mb-3">
                            <label for="createFullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="full_name" placeholder="Enter full name" required>
                        </div>
                        <div class="mb-3">
                            <label for="createPhoneNumber" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" placeholder="Enter phone number"  oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,11)" required>
                        </div>
                        <div class="mb-3">
                            <label for="createAmountPaid" class="form-label">Amount Paid</label>
                            <input type="number" class="form-control" name="amount" placeholder="Enter amount paid" required>
                        </div>
                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <select id="paymentMethod" class="form-select" name="payment_method" required>
                                <option value="" disabled selected>Select a payment method</option>
                                <option value="GCASH">GCASH</option>
                                <option value="MAYA">MAYA</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="font-bold text-sm mb-2 ml-1">Select Due Date</label>
                            <select name="due_date[]" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" multiple required size="5">
                                <option disabled>Select one or more due dates</option>
                                @foreach($dueDates as $date)
                                    <option value="{{ $date }}">{{ $date }}</option>
                                @endforeach

                                <option disabled>────── Past Due Dates ──────</option>

                                @foreach($pastDueDates as $date)
                                    <option value="{{ $date }}">{{ $date }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="createQRCode" class="form-label">Upload Proof of Billing</label>
                            <input type="file" class="form-control" name="qr_code" id="createQRCode" accept="image/*" onchange="previewImage(event, 'createQRCodePreview')">
                        </div>
                        <div class="mb-3">
                        <label class="form-label">New Proof of Billing Preview:</label>
                        <img id="createQRCodePreview" src="" alt="Proof of Billing Preview" class="img-fluid" style="display: none; max-width: 100px; margin-top: 10px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Include SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Delete confirmation
    function confirmDelete(paymentId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to undo this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the delete form
                document.getElementById(`deleteForm${paymentId}`).submit();
            }
        });
    }

    // Restore confirmation
    function confirmRestore(paymentId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to restore this payment?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the restore form
                fetch(document.getElementById(`restoreForm${paymentId}`).action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Restored!', data.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(() => Swal.fire('Error!', 'An error occurred.', 'error'));
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