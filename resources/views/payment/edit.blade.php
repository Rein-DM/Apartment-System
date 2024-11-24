<x-app-layout>
    <div class="container mx-auto">
    @include('payments.edit-payment', [
            'payment' => $payment,
            'dueDates' => $dueDates,
            'pastDueDates' => $pastDueDates
        ])
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
                    <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number', $payment->phone_number) }}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,11)" required>
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
                <div class="mb-3">
                    <label class="font-bold text-sm mb-2 ml-1">Select Due Date</label>
                    <select name="due_date[]" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" multiple required size="5">
                        <option disabled>Select one or more due dates</option>
                        @foreach($dueDates as $date)
                            <option value="{{ $date }}" {{ is_array($payment->due_dates) && in_array($date, $payment->due_dates) ? 'selected' : '' }}>{{ $date }}</option>
                        @endforeach
                        <option disabled>────── Past Due Dates ──────</option>
                        @foreach($pastDueDates as $date)
                            <option value="{{ $date }}" {{ is_array($payment->due_dates) && in_array($date, $payment->due_dates) ? 'selected' : '' }}>{{ $date }}</option>
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
                <button type="button" class="btn btn-secondary" onclick="window.history.back();">Close</button>
                <button type="submit" class="btn btn-primary">Update Payment</button>
            </div>
        </form>
    </div>
</x-app-layout>
