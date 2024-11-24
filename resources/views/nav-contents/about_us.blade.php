@extends('layouts.app2')

@section('contents')

<div id="about" class="bg-gray-100 py-10">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-4xl font-semibold text-gray-800">About Apartment System</h2>
        </div>
        
        <div class="flex flex-wrap -mx-4">
            <!-- single-well start-->
            <div class="w-full md:w-1/2 px-4 mb-6">
                <div class="overflow-hidden rounded-lg shadow-lg">
                    <a href="">
                        <img src="{{ asset('admin_assets/assets/images/about.jpg') }}" alt="About Image" class="w-full h-60 object-cover">
                    </a>
                </div>
            </div>
            <!-- single-well end-->
        </div>

        <div class="flex justify-center mt-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> <!-- Use grid with responsive columns -->
                <div class="border p-6 rounded-lg shadow-lg bg-white">
                    <h3 class="text-3xl font-semibold text-gray-800 mb-4">Who We Are</h3>
                    <p class="text-gray-700 mb-4">
                        Founded in 2024, our team comprises real estate professionals, technology enthusiasts, and customer service experts who share a common goal: to provide the best apartment search experience possible.
                    </p>
                </div>
                <div class="border p-6 rounded-lg shadow-lg bg-white">
                    <h3 class="text-3xl font-semibold text-gray-800 mb-4">Our Mission</h3>
                    <p class="text-gray-700 mb-4">
                        Our mission is to create a trusted marketplace where renters can find their ideal apartments and landlords can efficiently manage their properties.
                    </p>
                </div>
            </div>
        </div>
        <div class="mt-10">
            <h3 class="text-3xl font-semibold text-gray-800 mb-4">What We Offer</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="card bg-white rounded-lg shadow-lg p-6 transition-transform duration-300 scroll-card">
                    <h4 class="text-xl font-semibold text-gray-800 mb-2">Comprehensive Listings</h4>
                    <p class="text-gray-600">Browse a wide range of apartments in various neighborhoods, complete with detailed descriptions, high-quality images, and virtual tours.</p>
                </div>
                <div class="card bg-white rounded-lg shadow-lg p-6 transition-transform duration-300 scroll-card">
                    <h4 class="text-xl font-semibold text-gray-800 mb-2">Smart Search Tools</h4>
                    <p class="text-gray-600">Use our advanced search filters to find apartments that fit your specific needs, including budget, location, amenities, and more.</p>
                </div>
                <div class="card bg-white rounded-lg shadow-lg p-6 transition-transform duration-300 scroll-card">
                    <h4 class="text-xl font-semibold text-gray-800 mb-2">User-Friendly Interface</h4>
                    <p class="text-gray-600">Our platform is designed with you in mind, providing an intuitive experience whether you’re on desktop or mobile.</p>
                </div>
                <div class="card bg-white rounded-lg shadow-lg p-6 transition-transform duration-300 scroll-card">
                    <h4 class="text-xl font-semibold text-gray-800 mb-2">Property Management Solutions</h4>
                    <p class="text-gray-600">For landlords, we offer tools to streamline property management, including tenant screening, rent collection, and maintenance requests.</p>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <h3 class="text-3xl font-semibold text-gray-800 mb-4">Why Choose Us?</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="card bg-white rounded-lg shadow-lg p-6 transition-transform duration-300 scroll-card">
                    <h4 class="text-xl font-semibold text-gray-800 mb-2">Expertise</h4>
                    <p class="text-gray-600">Our team has extensive experience in the real estate market and understands the nuances of renting and property management.</p>
                </div>
                <div class="card bg-white rounded-lg shadow-lg p-6 transition-transform duration-300 scroll-card">
                    <h4 class="text-xl font-semibold text-gray-800 mb-2">Customer Support</h4>
                    <p class="text-gray-600">We pride ourselves on our exceptional customer service. Our team is always here to assist you with any questions or concerns.</p>
                </div>
                <div class="card bg-white rounded-lg shadow-lg p-6 transition-transform duration-300 scroll-card">
                    <h4 class="text-xl font-semibold text-gray-800 mb-2">Community Focus</h4>
                    <p class="text-gray-600">We believe in building communities. Our platform not only connects renters and landlords but also fosters relationships among neighbors.</p>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <h3 class="text-3xl font-semibold text-gray-800 mb-4">Join Us on This Journey</h3>
            <p class="text-gray-700 mb-4">
                Whether you’re searching for your next home or looking to list your property, Apartment System is here to help. Join us as we transform the rental experience and help you find a place to call home.
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('scroll', function() {
        const scrollCards = document.querySelectorAll('.scroll-card');
        const scrollPosition = window.scrollY;

        scrollCards.forEach((card, index) => {
            const offset = index * 10; 
            const moveAmount = Math.min((scrollPosition / 100) + offset, 0);
            const maxScroll = 400; 
            const opacity = Math.min(scrollPosition / maxScroll, 1); 


            card.style.transform = `translateX(${moveAmount}px)`; 
            card.style.opacity = opacity;
            card.style.transition = 'transform 0.5s ease-out, opacity 0.5s ease-out'; 
        });
    });
</script>

@endsection
