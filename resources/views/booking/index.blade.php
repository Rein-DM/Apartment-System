<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-full mx-auto sm:px-3 lg:px-4">
            <x-room-booking.booking-card :eventCount="$eventCount" />
            <x-room-booking.apartment-booking />
        </div>
    </div>
</x-app-layout>

@section('scripts')
<script>
$(document).ready(function() {
    // CSRF token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initial rendering of calendar with events
    function initializeCalendar(events) {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay',
            },
            events: events, // Initial events
            selectable: true,
            selectHelper: true,
            select: function(start, end) {
                // Check if the selected start date is in the past
                if (moment(start).isBefore(moment(), 'day')) {
                    swal("Error!", "You cannot create events in the past!", "error");
                    return; // Prevent the modal from opening
                }

                // Open modal if the date is valid
                $('#bookingModal').modal('toggle');
                $('#saveBtn').off('click').on('click', function() {
                    var title = $('#title').val();
                    var full_name = $('#full_name').val(); // Get full name from the input
                    var contact_number = $('#contact_number').val();
                    var email = $('#email').val();
                    var valid_id = $('#dropzone-file-validId')[0].files[0];
                    var condition_agreement = $('#condition_agreement').is(':checked') ? 1 : 0; 
                    var start_date = moment(start).format('YYYY-MM-DD');
                    var end_date = moment(end).format('YYYY-MM-DD');

                    // Create a FormData object
                    var formData = new FormData();
                    formData.append('title', title);
                    formData.append('full_name', full_name); // Append full name
                    formData.append('contact_number', contact_number);
                    formData.append('email', email);
                    formData.append('valid_id', valid_id); // Append the file
                    formData.append('condition_agreement', condition_agreement);
                    formData.append('start_date', start_date);
                    formData.append('end_date', end_date);

                    $.ajax({
                        url: "{{ route('booking.store') }}",
                        type: "POST",
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function(response) {
                            $('#bookingModal').modal('hide');
                            $('#calendar').fullCalendar('renderEvent', {
                                'id': response.id,
                                'title': response.title,
                                'full_name': response.full_name, 
                                'start': response.start,
                                'end': response.end,
                                'color': response.color || '#3B82F6',
                            });
                            swal("Success!", "Event created successfully!", "success");
                        },
                        error: function(error) {
                            if (error.responseJSON.errors) {
                                // Gather all error messages and create an array of elements
                                let errorsHtml = Object.entries(error.responseJSON.errors)
                                    .map(([field, messages]) => 
                                        `<span class="text-red-500 font-semibold">${field}:</span> 
                                        <span class="text-gray-700">${messages.join(', ')}</span>`)
                                    .join(' | '); // Joining errors by pipe for inline layout
                                
                                swal({
                                    title: "Validation Error!",
                                    content: {
                                        element: "div",
                                        attributes: {
                                            innerHTML: errorsHtml,
                                        },
                                    },
                                    icon: "error",
                                    buttons: {
                                        confirm: {
                                            text: "OK",
                                            className: "bg-blue-500 text-white px-4 py-2 rounded",
                                        },
                                    },
                                });
                            } else {
                                swal("Error!", "Email already exists", "error");
                            }
                        }
                    });
                });
            },
            editable: true,
            eventRender: function(event, element) {
                element.css({
                    'background-color': event.color || '#3B82F6', // Custom color
                    'border-radius': '5px',
                    'padding': '5px',
                    'font-size': '12px',
                    'color': '#ffffff', // Font color
                    'white-space': 'normal', // Allow text to wrap
                    'overflow': 'visible', // Allow overflowing content to be visible
                    'width': 'auto', // Allow width to adjust to content
                });

                // Update the display to include both title and full name
                element.find('.fc-title').html(event.title + '<br>' + event.full_name);
            },
            eventDrop: function(event) {
                var id = event.id;
                var start_date = moment(event.start).format('YYYY-MM-DD');
                var end_date = moment(event.end).format('YYYY-MM-DD');

                $.ajax({
                    url: "{{ route('booking.update', ':id') }}".replace(':id', id),
                    type: "PATCH",
                    dataType: 'json',
                    data: {
                        start_date,
                        end_date
                    },
                    success: function(response) {
                        // Notify the user of a successful update
                        swal("Success!", "Event updated successfully!", "success");
                    },
                    error: function(error) {
                        // Notify the user of an error during update
                        swal("Error!", "Failed to update event!", "error");
                    },
                });
            },
            eventClick: function(event) {
                var id = event.id;

                swal({
                    title: "Are you sure?",
                    text: "Do you want to delete this event?",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Cancel",
                            value: null,
                            visible: true,
                            className: "bg-gray-300 text-gray-700 px-4 py-2 rounded",
                        },
                        confirm: {
                            text: "Delete",
                            value: true,
                            visible: true,
                            className: "bg-red-500 text-white px-4 py-2 rounded",
                        },
                    },
                    dangerMode: true,
                    customClass: {
                        popup: 'swal-tailwind-popup', 
                        title: 'text-lg font-bold', 
                        content: 'text-sm', 
                    },
                }).then((willDelete) => {
                    if (willDelete) {
                        // Perform the delete action
                        $.ajax({
                            url: "{{ route('booking.destroy', ':id') }}".replace(':id', id),
                            type: "DELETE",
                            success: function(response) {
                                swal("Deleted!", "Your event has been deleted!", "success");
                                $('#calendar').fullCalendar('removeEvents', id);
                            },
                            error: function(error) {
                                swal("Error!", "Failed to delete event!", "error");
                            },
                        });
                    } else {
                        swal("Cancelled", "Your event is safe", "info");
                    }
                });
            },
            eventAfterRender: function(event, element) {
                // Set background color for dates to whitesmoke
                $('.fc-day').css('background-color', 'whitesmoke');

                // Make past dates dark gray and disable them
                $('.fc-day').each(function() {
                    var date = $(this).data('date');
                    if (moment(date).isBefore(moment(), 'day')) {
                        $(this).css({
                            'background-color': '#D3D3D3', // Grayed out past dates
                            'pointer-events': 'none' // Disable interaction
                        });
                        $(this).find('.fc-day-number').css('color', '#A0AEC0'); // Gray out the date number
                    }
                });
                // Make day labels bold
                $('.fc-day-header').css('font-weight', 'bold');
            }
        });
    }

    // Fetch initial events and initialize calendar
    initializeCalendar(@json($events));

    setInterval(function() {
        $.ajax({
            url: "{{ route('booking') }}",
            type: "GET",
            dataType: 'json',
            success: function(response) {
                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('addEventSource', response.events); 
            },
            error: function(error) {}
        });
    }, 10000); 

    // Handle modal close
    $("#bookingModal").on("hidden.bs.modal", function() {
        $('#saveBtn').off('click'); // Remove click event from save button
        $('#title').val(''); // Clear the title input
        $('#full_name').val(''); // Clear full name input
        $('#contact_number').val('');
        $('#email').val('');
        $('#dropzone-file-validId').val(''); // Clear the file input
        $('#condition_agreement').prop('checked', false); 
        $('#titleError').html(''); // Clear any error messages
    });

    // Customize FullCalendar event styling
    $('.fc-event').css({
        'font-size': '13px',
        'width': 'auto', // Changed width to auto to accommodate text
        'border-radius': '5px', // Changed border-radius to make it more rectangular
    });
});
</script>
@ensection