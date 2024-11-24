@extends('layouts.app2')

@section('contents')
<div class="container mt-5">
    <!-- Room Images Title and Carousel Section -->
    <h2 class="text-center mb-3 text-lg font-bold">Room Images</h2>
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
            @if($room->occupied_image)
                <div class="carousel-item">
                    <img src="{{ asset('storage/' . $room->occupied_image) }}" alt="Occupied Image" class="d-block w-100" style="height: 300px; object-fit: contain;">
                </div>
            @endif
            @if($room->vacant_image)
                <div class="carousel-item">
                    <img src="{{ asset('storage/' . $room->vacant_image) }}" alt="Vacant Image" class="d-block w-100" style="height: 300px; object-fit: contain;">
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

    <!-- Main Room Details Container -->
    <div class="card p-4 bg-white rounded-lg shadow-md">
        <h2 class="text-3xl font-semibold mb-4">Room Details</h2>
        <ul class="list-unstyled">
            <li>Room Number: <span class="font-bold">{{ $room->room_number }}</span></li>
            <li>Price: <span class="font-bold">Php{{ number_format($room->price, 2) }}</span></li>
            <li>Description: <span class="font-bold">{{ $room->description }}</span></li>
            <li>Availability: <span class="font-bold">{{ $room->available ? 'Available' : 'Not Available' }}</span></li>
        </ul>

        <div class="main-button mt-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal">Book Now</button>
        </div>
    </div>
</div>

<!-- Include the modal component -->
@include('components.room-booking.apartment-booking')

@endsection
