@extends('layouts.app2')

@section('contents')

<style>
    .fade-out {
        opacity: 0;
        transition: opacity 1s ease-out;
    }
</style>

<!-- ***** Preloader Start ***** -->
<div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>

<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <span class="breadcrumb">MABALACAT DORM: A WEB APPLICATION FOR ENHANCED TENANT MONITORING AND MANAGEMENT / APARTMENT</span>
                <h3>Booking Forms</h3>
                <p>Total Events: {{ $eventCount }}</p> <!-- Display total number of events -->
            </div>
        </div>
    </div>
</div>

<div class="section properties">
    <div class="container">
        <ul class="properties-filter">
            <li>
                <a class="is_active" href="#!" data-filter="*">APARTMENTS AVAILABLE</a>
            </li>
        </ul>
        @if(session('success'))
            <div id="successMessage" class="bg-green-500 text-white p-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        <div class="row"> <!-- Row for horizontal alignment -->
            @foreach($rooms as $room)
                @if($room->available) 
                <div class="col-md-4 mb-4">
                    <div class="max-w-sm mx-auto bg-white rounded-lg shadow-md p-4">
                        @if($room->apartment_image)
                        <img src="{{ asset('storage/' . $room->apartment_image) }}" alt="Apartment Image" class="rounded-lg w-full h-48 object-cover">
                        @endif
                        <div class="mt-4">
                            <div class="flex items-center justify-between">
                                <span class="bg-orange-500 text-white px-3 py-1 rounded-lg font-bold text-sm">ROOM NUMBER: {{ $room['room_number'] }}</span>
                                <span class="text-gray-600 text-sm">CAPACITY: {{ $room['capacity'] }}</span>
                            </div>
                            <h2 class="text-xl font-bold mt-2 line-clamp-1">{{ strtok($room->description, '.') }}.</h2>
                            <p class="text-gray-700 mt-1">Php: {{ number_format($room->price, 2) }}</p>
                        </div>
                        <div class="main-button mt-4">
                            <!-- Inquire Button -->
                            <button class="bg-orange-600 text-white px-4 py-2 rounded-md" data-toggle="modal" data-target="#inquireModal{{ $room->id }}" onclick="resetModal({{ $room->id }})">Inquire</button>
                        </div>
                    </div>
                </div>

                <!-- Inquiry Modal -->
                <div class="modal fade" id="inquireModal{{ $room->id }}" tabindex="-1" aria-labelledby="inquireModalLabel{{ $room->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content bg-white rounded-lg shadow-lg">
                            <div class="modal-header border-b p-4 flex items-center justify-between">
                                <h5 class="modal-title text-lg font-semibold" id="inquireModalLabel">Apartment Booking</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-3 grid grid-cols-1 gap-4 overflow-auto max-h-[600px] overflow-y-auto">
                                <!-- Static Apartment Data -->
                                <div id="apartmentDetails" class="bg-gray-100 p-4 rounded-md mb-4">
                                    <h6 class="text-md font-semibold">Apartment Details</h6>
                                    <div id="roomImagesCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @if($room->apartment_image)
                                                <div class="carousel-item active">
                                                    <img src="{{ asset('storage/' . $room->apartment_image) }}" alt="Apartment Image" class="d-block w-100" style="height: 300px; object-fit: contain;">
                                                </div>
                                            @endif
                                            @if($room->bathroom_image)
                                                <div class="carousel-item">
                                                    <img src="{{ asset('storage/' . $room->bathroom_image) }}" alt="Bathroom Image" class="d-block w-100" style="height: 300px; object-fit: contain;">
                                                </div>
                                            @endif
                                            @if($room->outside_image)
                                                <div class="carousel-item">
                                                    <img src="{{ asset('storage/' . $room->outside_image) }}" alt="Outside Image" class="d-block w-100" style="height: 300px; object-fit: contain;">
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Carousel controls -->
                                        <button class="carousel-control-prev" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                    <div class="">
                                        <ul class="list-unstyled">
                                            <li>Room Number: <span class="font-bold">{{ $room->room_number }}</span></li>
                                            <li>Price: <span class="font-bold">Php{{ number_format($room->price, 2) }}</span></li>
                                            <li>Description: <span class="font-bold">{{ $room->description }}</span></li>
                                            <li>Availability: <span class="font-bold">{{ $room->available ? 'Available' : 'Not Available' }}</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- User Inquiry Form -->
                                <form id="inquiryForm" action="{{ route('inquiries.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <label class="text-sm font-semibold mb-2" for="price">Price</label>
                                        <input type="text" id="price" name="price" value="{{ number_format($room->price, 2) }}" required class="bg-gray-200 border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" placeholder="Enter price" readonly />
                                        <span id="priceError" class="text-red-500 mt-1 text-sm"></span>
                                    </div>

                                    <div>
                                        <label class="text-sm font-semibold mb-2" for="room_number">Room Number</label>
                                        <input type="text" id="room_number" name="room_number" value="{{ $room['room_number'] }}" required class="bg-gray-200 border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" placeholder="Enter event room_number" readonly>
                                        <span id="RoomNumberError" class="text-red-500 mt-1 text-sm"></span>
                                    </div>

                                    <div>
                                        <label class="text-sm font-semibold mb-2" for="full_name">Full Name</label>
                                        <input type="text" id="full_name" name="full_name" required class="border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" placeholder="Enter your full name">
                                        <span id="fullNameError" class="text-red-500 mt-1 text-sm"></span>
                                    </div>

                                    <div>
                                        <label class="text-sm font-semibold mb-2" for="contact_number">Contact Number</label>
                                        <input type="text" id="contact_number" name="contact_number" required class="border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" placeholder="Enter your contact number">
                                        <span id="contactNumberError" class="text-red-500 mt-1 text-sm"></span>
                                    </div>

                                    <div>
                                        <label class="text-sm font-semibold mb-2" for="email">Email Address</label>
                                        <input type="email" id="email" name="email" required class="border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" placeholder="Enter your email address">
                                        <span id="emailError" class="text-red-500 mt-1 text-sm"></span>
                                    </div>

                                    <!-- Valid ID Upload Field -->
                                    <div class="mb-10">
                                        <label class="font-bold text-sm ml-1">Valid ID</label>
                                        <input name="valid_id" type="file" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" required />
                                    </div>

                                    <div>
                                        <label class="text-sm font-semibold mb-2" for="agreement">
                                            <input type="checkbox" id="agreement" name="agreement" required class="mr-2">I agree to the terms and conditions
                                        </label>
                                        <span id="agreementError" class="text-red-500 mt-1 text-sm"></span>
                                    </div>

                                    <div class="modal-footer mt-4">
                                        <button type="submit" class="bg-orange-600 text-white rounded-md px-4 py-2 hover:bg-orange-700">Submit Inquiry</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<script>
    // Fade out success message after 4 seconds
    setTimeout(() => {
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            successMessage.classList.add('fade-out');
            setTimeout(() => successMessage.remove(), 1000); // Remove the element after fading out
        }
    }, 2000);

    function resetModal(roomId) {
        document.getElementById('inquiryForm').reset();
        document.getElementById('agreement').checked = false;
        document.querySelectorAll('.text-red-500').forEach(el => el.textContent = ''); // Clear error messages
    }
</script>
@endsection
