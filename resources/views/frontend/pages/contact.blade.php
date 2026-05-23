@extends('frontend.layouts.app')
@section('title', 'Contacts')
@section('content')
<main>
        <!-- BREADCRUMB SECTION START -->
        <div class="ul-breadcrumb">
            <div class="wow animate__fadeInUp">
                <h2 class="ul-breadcrumb-title">Contact</h2>
                <div class="ul-breadcrumb-nav">
                    <a href="{{route('home')}}">Home</a>
                    <span class="separator"><i class="flaticon-aro-left"></i></span>
                    <span class="current-page">Contact</span>
                </div>
            </div>
        </div>
        <!-- BREADCRUMB SECTION END -->


        <!-- CONTACT SECTION START -->
        <div class="ul-inner-page-content-wrapper">
            <div class="ul-inner-page-container">
                <div class="ul-contact">
                    <div class="row g-0">
                        <!-- contact infos -->
                        <div class="col-md-5">
                            <div class="ul-contact-infos-wrapper">
                                <div class="heading">
                                    <h3 class="ul-contact-infos-title">{{ $contact->title ?? 'Contact Information' }}</h3>
                                    <span class="ul-contact-infos-sub-title">{{ $contact->description ?? 'Say something to start a live chat!' }}</span>
                                </div>

                                <!-- infos -->
                                <div class="ul-contact-infos">
                                    <a href="tel:+10123456789" class="ul-contact-info"><i class="flaticon-telephone"></i> {{ $contact->phone ?? '+1012 3456 789' }}</a>
                                    <a href="mailto:{{$contact->email ?? 'demo@gmail.com'}}" class="ul-contact-info"><i class="flaticon-mail"></i> {{ $contact->email ?? 'demo@gmail.com' }}</a>
                                    <div class="ul-contact-info">
                                        <i class="flaticon-location-pin"></i>
                                        <span class="txt">{{ $contact->address ?? '132 Dartmouth Street Boston, Massachusetts 02156 United States' }}</span>
                                    </div>
                                </div>

                                <!-- socials -->
                                <div class="ul-contact-socials">
                                    <a href="#"><i class="flaticon-twitter-1"></i></a>
                                    <a href="#"><i class="flaticon-instagram"></i></a>
                                    <a href="#"><i class="flaticon-linkedin"></i></a>
                                </div>
                            </div>
                        </div>

                        <!-- form -->
                        <div class="col-md-7">
                            <div class="ul-contact-form-wrapper">

                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <!-- Validation Errors -->
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('contact.store') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="contact-first-name">First Name</label>
                                        <input type="text" name="first_name" id="contact-first-name" placeholder="John">
                                    </div>

                                    <div class="form-group">
                                        <label for="contact-last-name">Last Name</label>
                                        <input type="text" name="last_name" id="contact-last-name" placeholder="Doe">
                                    </div>

                                    <div class="form-group">
                                        <label for="contact-email">Email</label>
                                        <input type="email" name="email" id="contact-email" placeholder="demo@TechInTix.com">
                                    </div>

                                    <div class="form-group">
                                        <label for="contact-phone">Phone Number</label>
                                        <input type="tel" name="phone" id="contact-phone" placeholder="+1 012 3456 789">
                                    </div>

                                    <div class="form-group">
                                        <span class="contact-inner-title">Select Subject?</span>
                                        <div class="ul-contact-form-subjects">
                                            <div class="ul-radio">
                                                <label for="contact-subject-1">
                                                    <input type="radio" name="subject" value="General Inquiry" id="contact-subject-1" checked>
                                                    <span class="checkmark"><i class="flaticon-check-2"></i></span>
                                                    <span class="txt">General Inquiry</span>
                                                </label>
                                            </div>
                                            <div class="ul-radio">
                                                <label for="contact-subject-2">
                                                    <input type="radio" name="subject" value="Support" id="contact-subject-2">
                                                    <span class="checkmark"><i class="flaticon-check-2"></i></span>
                                                    <span class="txt">Support</span>
                                                </label>
                                            </div>
                                            <div class="ul-radio">
                                                <label for="contact-subject-3">
                                                    <input type="radio" name="subject" value="Partnership" id="contact-subject-3">
                                                    <span class="checkmark"><i class="flaticon-check-2"></i></span>
                                                    <span class="txt">Partnership</span>
                                                </label>
                                            </div>
                                            <div class="ul-radio">
                                                <label for="contact-subject-4">
                                                    <input type="radio" name="subject" value="Other" id="contact-subject-4">
                                                    <span class="checkmark"><i class="flaticon-check-2"></i></span>
                                                    <span class="txt">Other</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="contact-message">Message</label>
                                        <textarea name="message" id="contact-message" placeholder="Write Message"></textarea>
                                    </div>

                                    <button type="submit" class="ul-btn">Send Message</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d41294.67553538239!2d90.4051752801728!3d23.81973204385709!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c64e5249ad39%3A0x2392867b037e718e!2sKuril%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1732511385236!5m2!1sen!2sbd" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="ul-contact-map"></iframe>
        <!-- CONTACT SECTION END -->



        <!-- APP AD SECTION START -->
        <div class="ul-app-ad ul-app-ad--contact wow animate__fadeInUp">
            <div class="ul-app-ad-container">
                <div class="ul-app-ad-content">
                    <div class="row align-items-start gy-5">
                        <!-- txt -->
                        <div class="col-lg-7">
                            <div class="ul-app-ad-txt">
                                <span class="ul-section-sub-title">Download App</span>
                                <h2 class="ul-section-title">Download Our Real Estate Mobile App <span class="colored">15% Off</span></h2>
                                <div class="ul-app-ad-btns">
                                    <button>
                                        <i class="flaticon-play"></i>
                                        <span>
                                            <span class="sub-title">Get in on</span>
                                            <span class="title">Apps Store</span>
                                        </span>
                                    </button>
                                    <button>
                                        <i class="flaticon-play"></i>
                                        <span>
                                            <span class="sub-title">Get in on</span>
                                            <span class="title">Google Play</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- img -->
                        <div class="col-lg-5">
                            <div class="ul-app-ad-imgs">
                                <div class="ul-app-ad-img">
                                    <!-- qr code -->
                                    <img src="{{ asset('assets') }}/img/app-ad-qr-code.jpg" alt="QR Code" class="ul-app-ad-qr-code">
                                    <!-- app screenshot 1 -->
                                    <img src="{{ asset('assets') }}/img/app-ad-ss-1.png" alt="App screenshot" class="ul-app-ad-ss-1">
                                </div>
                                <div class="ul-app-ad-img">
                                    <!-- app screenshot 2 -->
                                    <img src="{{ asset('assets') }}/img/app-ad-ss-2.png" alt="App Screenshot" class="ul-app-ad-ss-2">
                                </div>

                                <!-- vector -->
                                <img src="{{ asset('assets') }}/img/app-ad-img-vector.svg" alt="vector" class="vector">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- APP AD SECTION END -->
    </main>
@endsection