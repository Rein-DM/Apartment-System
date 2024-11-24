<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '{{ session('error') }}',
            });
        </script>
    @endif


    <div class="py-2">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Due Date Card -->
                    <div class="bg-blue-100 p-4 rounded-lg shadow flex flex-col h-56">
                        <h3 class="text-xl font-semibold">Due Date</h3>
                        <p class="text-2xl font-bold">{{ $dueTodayCount }}</p>
                        <button class="mt-auto text-blue-900 bg-blue-200 py-2 px-4 rounded-lg show-all-dates" data-bs-toggle="modal" data-bs-target="#dueModal">Show All Dates</button>
                    </div>

                    <!-- Past Due Card -->
                    <div class="bg-red-100 p-4 rounded-lg shadow flex flex-col h-56">
                        <h3 class="text-xl font-semibold">Past Due</h3>
                        <p class="text-2xl font-bold">{{ $pastDueCount }}</p>
                        <button class="mt-auto text-blue-900 bg-red-200 py-2 px-4 rounded-lg show-all-dates" data-bs-toggle="modal" data-bs-target="#pastDueModal">Show All Dates</button>
                    </div>

                    <!-- Total Payments Card -->
                    <div class="bg-green-100 p-4 rounded-lg shadow flex flex-col h-56">
                        <h3 class="text-xl font-semibold">Total Payments</h3>
                        <p class="text-2xl font-bold">{{ $paymentCount }}</p>
                        <button class="mt-auto text-blue-900 bg-green-300 py-2 px-4 rounded-lg show-all-dates" data-bs-toggle="modal" data-bs-target="#paidModal">Show All Dates</button>
                    </div>

                    <!-- Payment Receipts Card -->
                    <div class="bg-gray-200 p-4 rounded-lg shadow flex flex-col h-56">
                        <div class="container mx-auto mt-2 flex-1">
                            <h1 class="text-2xl font-bold mb-2">Payment Receipts</h1>
                            <div class="w-full h-28 overflow-y-auto p-2 rounded flex-1">
                                @if($payments->isNotEmpty())
                                    <ul class="list-disc pl-5">
                                        @foreach($payments as $payment)
                                            <li class="mb-2">
                                                <strong>Date:</strong> {{ $payment->created_at->format('F j, Y') }}<br>
                                                <strong>Receipt:</strong>
                                                <a href="{{ asset($payment->receipt_path) }}" target="_blank" class="text-blue-500 hover:underline">
                                                    Download Receipt
                                                </a><br>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No payment receipts available.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- All Due Dates -->
    <div class="modal fade" id="dueModal" tabindex="-1" aria-labelledby="dueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dueModalLabel">All Due Dates</h5>
                    <p class="h4 mb-0">{{$dueTodayCount}}</p> <!-- Display the due today count -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                    @foreach ($dueDates as $date)
                        <li>{{ htmlspecialchars($date->name) }} - {{ \Carbon\Carbon::parse($date->due_date)->format('F j, Y') }}</li>
                    @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- All Past Due Dates -->
    <div class="modal fade" id="pastDueModal" tabindex="-1" aria-labelledby="pastDueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pastDueModalLabel">All Past Due Dates</h5>
                    <p class="h4 mb-0">{{ $pastDueCount }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                    @foreach($pastDueDates as $date)
                        <li>{{ htmlspecialchars($date->name) }} - {{ \Carbon\Carbon::parse($date->due_date)->format('F j, Y') }}</li>
                    @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Paid Modal for all dates -->
    <div class="modal fade" id="paidModal" tabindex="-1" aria-labelledby="paidModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paidModalLabel">All Paid Dates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                    @foreach($paymentDates as $payment)
                        <p>{{ $payment['name'] }} - {{ $payment['date'] }}</p>
                    @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    @if(session('success'))
    <div id="success-message" class="bg-green-500 text-white p-4 rounded mb-4 w-full max-w-md mx-auto text-center">
        {{ session('success') }}
    </div>
    @endif

    <div class="min-h-screen flex items-center justify-center pt-16 pb-10">
    <div class="w-full max-w-xl mx-auto rounded-lg bg-white shadow-lg p-6 text-gray-700">
        <!-- First Form for Gcash -->
        <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="w-full pt-1 pb-5">
                <div class="bg-indigo-500 text-white overflow-hidden rounded-full w-20 h-20 -mt-20 mx-auto shadow-lg flex justify-center items-center">
                    <i class="bi bi-wallet2 text-4xl"></i>
                </div>
            </div>
            <h1 class="text-center font-bold text-xl uppercase">Secure payment info for Gcash</h1>
            <div class="flex flex-row items-center justify-center space-x-4">
                <div class="flex flex-col items-center justify-center">
                    <label for="gcash" class="text-md font-bold">GCASH</label>
                    <label for="gcash" class="flex items-center cursor-pointer mb-2">
                        <img src="{{ asset('admin_assets/assets/images/qr-code/gcash.png') }}" alt="Gcash Logo" class="h-40">
                    </label>
                    <label for="gcash_number" class="text-center"><strong>095654245165</strong></label>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <label for="maya" class="text-md font-bold">MAYA</label>
                    <label for="maya" class="flex items-center cursor-pointer mb-2">
                        <img src="{{ asset('admin_assets/assets/images/qr-code/maya.png') }}" alt="Maya Logo" class="h-40">
                    </label>
                    <label for="maya_number" class="text-center"><strong>09687546225</strong></label>
                </div>
            </div>
            <!-- Due Date Dropdown -->
            <div class="mb-3">
                <label class="font-bold text-sm mb-2 ml-1">Select Due Date</label>
                <select name="due_date[]" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" multiple required size="5">
                    <option disabled>Select one or more due dates</option>
                    @foreach($dueDates as $date)
                        <option value="{{ $date->due_date }}">
                            @if(Auth::user()->role === 'admin')
                                {{ $date->name }} - 
                            @endif
                            {{ \Carbon\Carbon::parse($date->due_date)->format('F j, Y') }}
                        </option>
                    @endforeach
                    <option disabled>────── Past Due Dates ──────</option>
                    @foreach($pastDueDates as $date)
                        <option value="{{ $date->due_date }}">
                            @if(Auth::user()->role === 'admin')
                                {{ $date->name }} - 
                            @endif
                            {{ \Carbon\Carbon::parse($date->due_date)->format('F j, Y') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="font-bold text-sm mb-2 ml-1">Full Name</label>
                <input name="full_name" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="Enter your Full Name" type="text" required/>
            </div>
            <div class="mb-3">
                <label class="font-bold text-sm mb-2 ml-1">Phone Number (Gcash Registered)</label>
                <input name="phone_number" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="Enter your Phone Number" type="text" required/>
            </div>
            <div class="mb-3">
                <label class="font-bold text-sm mb-2 ml-1">Payment Method</label>
                <select name="payment_method" id="payment_method" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" required>
                    <option value="" disabled selected>Select a Payment Method</option>
                    <option value="GCASH">GCASH</option>
                    <option value="MAYA">MAYA</option>
                    <option value="PERSONAL PAYMENT">PERSONAL PAYMENT</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="font-bold text-sm mb-2 ml-1">Amount</label>
                <input name="amount" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="Enter Amount" type="number" required/>
            </div>
            <div class="mb-10" id="proof-of-billing">
                <label class="font-bold text-sm mb-2 ml-1">Upload Proof of Billing</label>
                <input name="qr_code" type="file" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" required />
            </div>
            <div id="reason-container" class="mb-10 hidden">
                <label class="font-bold text-sm mb-2 ml-1">Reason</label>
                <textarea name="reason" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="Enter the reason for personal payment"></textarea>
            </div>
            <button type="submit" class="block w-full max-w-xs mx-auto bg-indigo-500 hover:bg-indigo-700 focus:bg-indigo-700 text-white rounded-lg px-3 py-3 font-semibold">
                <i class="mdi mdi-lock-outline mr-1"></i> PAY NOW
            </button>
        </form>
    </div>
</div>

<script>
    document.getElementById('payment_method').addEventListener('change', function() {
        const proofOfBilling = document.getElementById('proof-of-billing');
        const reasonContainer = document.getElementById('reason-container');
        
        if (this.value === 'PERSONAL PAYMENT') {
            proofOfBilling.classList.add('hidden');
            reasonContainer.classList.remove('hidden');
            document.querySelector('input[name="qr_code"]').removeAttribute('required');
        } else {
            proofOfBilling.classList.remove('hidden');
            reasonContainer.classList.add('hidden');
            document.querySelector('input[name="qr_code"]').setAttribute('required', 'required');
        }
    });
</script>



    <script>
    // Wait for the DOM to fully load before running the script
    document.addEventListener("DOMContentLoaded", function() {
        // Set timeout to hide success message after 3 seconds
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 3000); // 3000 milliseconds = 3 seconds
    });
</script>
</x-app-layout>
