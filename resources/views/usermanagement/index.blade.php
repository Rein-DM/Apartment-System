<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            {{ __('User management') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-full mx-auto sm:px-4 lg:px-6">
            <x-user-table :users="$users" />
        </div>
    </div>
</x-app-layout>

<script>
// AJAX request to update user
$(document).ready(function() {
    // Attach the event listener to the form
    $(`form[id^="editUserForm"]`).on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Get the user ID from the data attribute
        var userId = $(this).data('user-id'); // This gets the user ID from the form

        // Serialize the form data
        var formData = $(this).serialize();

        $.ajax({
            url: `/usermanagement/${userId}`, // Update the URL to include the user ID
            type: "PUT", // Use PUT for updating
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
            },
            success: function(response) {
                // Show success message
                Swal.fire({
                    title: 'Success!',
                    text: 'User updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Optionally, update the UI or reload the page
                    location.reload();
                });
            },
            error: function(xhr) {
                // Show error message
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to update user: ' + (xhr.responseJSON.message || 'Unknown error'),
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                });
            }
        });
    });
});

// Use SweetAlert to confirm deletion
function confirmDelete(userId) {
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
            // Proceed with AJAX delete request
            const form = document.getElementById(`deleteForm${userId}`);
            const formData = new FormData(form);

            $.ajax({
                url: form.action,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Handle success response
                    Swal.fire(
                        'Deleted!',
                        'The user has been deleted.',
                        'success'
                    ).then(() => {
                        location.reload(); // Reload the page or update the UI
                    });
                },
                error: function(xhr) {
                    // Handle error response
                    Swal.fire(
                        'Error!',
                        'There was a problem deleting the user.',
                        'error'
                    );
                }
            });
        }
    });
}
</script>