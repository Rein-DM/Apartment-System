@extends('layouts.app2')

@section('contents')
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

  <div class="main-banner">
    <div class="owl-carousel owl-banner">
      <div class="item item-1">
        <div class="header-text">
          <span class="category">Philippines, <em>Dau</em></span>
          <h2>Hurry!<br>Get the Best Villa for you</h2>
        </div>
      </div>
      <div class="item item-2">
        <div class="header-text">
          <span class="category">Melbourne, <em>Australia</em></span>
          <h2>Be Quick!<br>Get the best villa in town</h2>
        </div>
      </div>
      <div class="item item-3">
        <div class="header-text">
          <span class="category">Miami, <em>South Florida</em></span>
          <h2>Act Now!<br>Get the highest level penthouse</h2>
        </div>
      </div>
    </div>
  </div>

  <div class="featured section">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="left-image">
            <img src="{{ asset('admin_assets/assets/images/featured.jpg')}}" alt="">
            <!-- <a href="#"> 
                <img src="{{ asset('admin_assets/assets/images/featured-icon.png')}}" alt="">
            </a> -->
          </div>
        </div>
        <div class="col-lg-5">
          <div class="section-heading">
            <h6>| Featured</h6>
            <h2>Best Appartment &amp; Sea view</h2>
          </div>
          <div class="accordion" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Best useful links
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Experience the epitome of modern living at Mabalacat Dorm, where exceptional tenant management and convenient amenities create an unparalleled community just steps away from your ideal home.</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  How does this work
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Discover how Mabalacat Dorm works seamlessly to enhance tenant monitoring and management, combining efficiency and comfort to create an unforgettable living experience for all residents.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Why is Villa Agency the best
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Mabalacat Dorm is the best web application for enhanced tenant monitoring and management, offering intuitive features that streamline communication, improve accountability, and ensure a secure, efficient living experience for both tenants and property managers.
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="info-table">
            <ul>
              <li>
                <img src="assets/images/info-icon-01.png" alt="" style="max-width: 52px;">
                <h4>250 m2<br><span>Total Flat Space</span></h4>
              </li>
              <li>
                <img src="assets/images/info-icon-02.png" alt="" style="max-width: 52px;">
                <h4>Contract<br><span>Contract Ready</span></h4>
              </li>
              <li>
                <img src="assets/images/info-icon-03.png" alt="" style="max-width: 52px;">
                <h4>Payment<br><span>Payment Process</span></h4>
              </li>
              <li>
                <img src="assets/images/info-icon-04.png" alt="" style="max-width: 52px;">
                <h4>Safety<br><span>24/7 Under Control</span></h4>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="video section">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 offset-lg-4">
          <div class="section-heading text-center">
            <h6>| Video View</h6>
            <h2>Get Closer View & Different Feeling</h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="video-content">
    <div class="container">
      <div class="row">
        <div class="col-lg-10 offset-lg-1">
          <div class="video-frame">
            <img src="assets/images/video-frame.jpg" alt="">
            <a href="https://youtube.com" target="_blank"><i class="fa fa-play"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="fun-facts">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="wrapper">
            <div class="row">
              <div class="col-lg-4">
                <div class="counter">
                  <h2 class="timer count-title count-number" data-to="34" data-speed="1000"></h2>
                   <p class="count-text ">Buildings<br>Finished Now</p>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="counter">
                  <h2 class="timer count-title count-number" data-to="12" data-speed="1000"></h2>
                  <p class="count-text ">Years<br>Experience</p>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="counter">
                  <h2 class="timer count-title count-number" data-to="24" data-speed="1000"></h2>
                  <p class="count-text ">Awwards<br>Won 2023</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section best-deal">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="section-heading">
            <h6>| Best Deal</h6>
            <h2>Find Your Best Deal Right Now!</h2>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="tabs-content">
            <div class="row">
              <div class="nav-wrapper ">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="appartment-tab" data-bs-toggle="tab" data-bs-target="#appartment" type="button" role="tab" aria-controls="appartment" aria-selected="true">Appartment</button>
                  </li>
                  <!-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="villa-tab" data-bs-toggle="tab" data-bs-target="#villa" type="button" role="tab" aria-controls="villa" aria-selected="false">Villa House</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="penthouse-tab" data-bs-toggle="tab" data-bs-target="#penthouse" type="button" role="tab" aria-controls="penthouse" aria-selected="false">Penthouse</button>
                  </li>
                </ul> -->
              </div>              
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="appartment" role="tabpanel" aria-labelledby="appartment-tab">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="info-table">
                        <ul>
                          <li>Total Flat Space <span>185 m2</span></li>
                          <li>Floor number <span>26th</span></li>
                          <li>Number of rooms <span>4</span></li>
                          <li>Parking Available <span>Yes</span></li>
                          <li>Payment Process <span>Bank</span></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <img src="{{ asset('admin_assets/assets/images/deal-01.jpg')}}" alt="Logo">
                    </div>
                    <div class="col-lg-3">
                      <h4>Extra Info About Property</h4>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod tempor pack incididunt ut labore et dolore magna aliqua quised ipsum suspendisse. 
                      <br><br>When you need free CSS templates, you can simply type TemplateMo in any search engine website. In addition, you can type TemplateMo Portfolio, TemplateMo One Page Layouts, etc.</p>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="villa" role="tabpanel" aria-labelledby="villa-tab">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="info-table">
                        <ul>
                          <li>Total Flat Space <span>250 m2</span></li>
                          <li>Floor number <span>26th</span></li>
                          <li>Number of rooms <span>5</span></li>
                          <li>Parking Available <span>Yes</span></li>
                          <li>Payment Process <span>Bank</span></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <img src="assets/images/deal-02.jpg" alt="">
                    </div>
                    <div class="col-lg-3">
                      <h4>Detail Info About Villa</h4>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod tempor pack incididunt ut labore et dolore magna aliqua quised ipsum suspendisse. <br><br>Swag fanny pack lyft blog twee. JOMO ethical copper mug, succulents typewriter shaman DIY kitsch twee taiyaki fixie hella venmo after messenger poutine next level humblebrag swag franzen.</p>
                      <div class="icon-button">
                        <a href="property-details.html"><i class="fa fa-calendar"></i> Schedule a visit</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="penthouse" role="tabpanel" aria-labelledby="penthouse-tab">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="info-table">
                        <ul>
                          <li>Total Flat Space <span>320 m2</span></li>
                          <li>Floor number <span>34th</span></li>
                          <li>Number of rooms <span>6</span></li>
                          <li>Parking Available <span>Yes</span></li>
                          <li>Payment Process <span>Bank</span></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <img src="assets/images/deal-03.jpg" alt="">
                    </div>
                    <div class="col-lg-3">
                      <h4>Extra Info About Penthouse</h4>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod tempor pack incididunt ut labore et dolore magna aliqua quised ipsum suspendisse. <br><br>Swag fanny pack lyft blog twee. JOMO ethical copper mug, succulents typewriter shaman DIY kitsch twee taiyaki fixie hella venmo after messenger poutine next level humblebrag swag franzen.</p>
                      <div class="icon-button">
                        <a href="property-details.html"><i class="fa fa-calendar"></i> Schedule a visit</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


    <!-- Contact Us Section -->
    <div class="contact-content">
        <div class="contact-section new_home_web relative py-12 bg-gray-100">
            <div class="container mx-auto px-4 max-w-6xl">
                <!-- Header Section -->
                <div class="text-center mb-10">
                    <h6 class="text-orange-600 font-semibold">| Contact Us</h6>
                    <h2 class="text-4xl font-semibold mb-4">Get In Touch With Our Agents</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        If you have any questions about renting, you can use this to contact us.
                    </p>
                    <div class="h-1 w-20 bg-red-500 mx-auto mt-4"></div>
                </div>
                <div class="flex flex-col lg:flex-row gap-10">
                    <!-- Left Section - Map and Contact Details -->
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
                    <!-- Right Section - Contact Form -->
                    <div class="w-full lg:w-5/12">
                      <!-- Loading overlay -->
                      <div id="loading-overlay" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
                          <div class="text-white text-lg">
                            <div class="fixed inset-0 flex space-x-2 justify-center items-center bg-black bg-opacity-50 h-screen">
                                <span class="sr-only">Loading...</span>
                                <div class="h-8 w-8 bg-orange-600 rounded-full animate-bounce" style="animation-delay: -0.3s;"></div>
                                <div class="h-8 w-8 bg-orange-600 rounded-full animate-bounce" style="animation-delay: -0.15s;"></div>
                                <div class="h-8 w-8 bg-orange-600 rounded-full animate-bounce"></div>
                            </div>
                          </div>
                      </div>
                      <!-- Contact Form -->
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
    </div>
</div>


<!-- Include jQuery and SweetAlert2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#contact-form').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Show loading overlay
        $('#loading-overlay').removeClass('hidden');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                // Hide loading overlay
                $('#loading-overlay').addClass('hidden');

                // Show success alert and reload page on confirmation
                Swal.fire({
                    title: 'Success!',
                    text: 'Your message has been sent successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            },
            error: function(xhr) {
                // Hide loading overlay
                $('#loading-overlay').addClass('hidden');

                // Show error alert
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error sending your message. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>
@endsection
