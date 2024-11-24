<!-- @extends('layouts.app2')

@section('contents')
<div class="contact-section new_home_web relative py-12 bg-gray-100">
  <div class="container mx-auto px-4 max-w-6xl">
    
    <div class="text-center mb-10">
      <h6 class="text-orange-600 font-semibold">| Contact Us</h6>
      <h2 class="text-4xl font-semibold mb-4">Get In Touch With Our Agents</h2>
      <p class="text-gray-600 max-w-2xl mx-auto">
        If you have any questions about renting, you can use this to contact us.
      </p>
      <div class="h-1 w-20 bg-red-500 mx-auto mt-4"></div>
    </div>

    <div class="flex flex-col lg:flex-row gap-10">

      <div class="w-full lg:w-7/12">
        <div id="map" class="mb-6">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3970.215740537843!2d120.573089!3d15.2224146!2m3!1f75!2f114.93!3f102.97!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bbd36e1f223c25%3A0x93e004ae9aa1fd79!2sYour%20Location!5e0!3m2!1sen!2sph!4v1635334228832!5m2!1sen!2sph" 
            width="100%" 
            height="400" 
            style="border:0; border-radius: 10px; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15);" 
            allowfullscreen="" 
            loading="lazy">
          </iframe>
        </div>

        <div class="flex flex-col sm:flex-row justify-between gap-6">
          <div class="flex items-center gap-4">
            <i class="bi bi-telephone-fill text-red-500 text-2xl"></i>
            <div>
              <h6 class="font-semibold text-gray-700">09999999999</h6>
              <span class="text-gray-500 text-sm">Phone Number</span>
            </div>
          </div>
          <div class="flex items-center gap-4">
            <i class="bi bi-envelope-fill text-red-500 text-2xl"></i>
            <div>
              <h6 class="font-semibold text-gray-700">apartment_system@gmail.com</h6>
              <span class="text-gray-500 text-sm">Business Email</span>
            </div>
          </div>
        </div>

      </div>

      <div class="w-full lg:w-5/12">
        <form id="contact-form" action="{{ route('contact.store') }}" method="POST" class="bg-white shadow-lg rounded-lg p-8">
          @csrf
          <div class="grid grid-cols-1 gap-6">
            <input class="input border-2 border-gray-300 rounded px-4 h-12" type="text" name="full_name" placeholder="Full Name" required>
            <input class="input border-2 border-gray-300 rounded px-4 h-12" type="email" name="email" placeholder="Email Address" required>
            <input class="input border-2 border-gray-300 rounded px-4 h-12" type="tel" name="phone_number" placeholder="Phone Number">
            <textarea class="textinput border-2 border-gray-300 rounded px-4 py-2 h-48" name="message" placeholder="Your Message" required></textarea>
          </div>
          <button type="submit" class="send w-full h-12 bg-red-500 text-white font-semibold rounded mt-4 hover:bg-red-600 transition-colors">
            Send Message
          </button>
        </form>
      </div>

    </div>
  </div>
</div>
@endsection -->
