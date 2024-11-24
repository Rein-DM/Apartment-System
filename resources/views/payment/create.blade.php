<x-app-layout> <!-- Adjust this line based on your actual app layout component -->

    <div class="container mt-4">
        <h1 class="mb-4">Payments</h1>
        
        <!-- Button to trigger the payment addition (if needed) -->
        <a href="{{ route('payments.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus"></i> Add Payment
        </a>

        <!-- Payment Form -->
        <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="createFullName" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="full_name" placeholder="Enter full name" required>
            </div>
            <div class="mb-3">
                <label for="createPhoneNumber" class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone_number" placeholder="Enter phone number" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,11)" required>
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
                <select name="due_date[]" class="form-select" multiple required size="5">
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
            <div class="mb-3">
                <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

</x-app-layout>
<script>
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