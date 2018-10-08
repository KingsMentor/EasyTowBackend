@extends('layouts.homepage')

@section('content')

    <div class="content clearfix">

        <!-- Full Width Slider Section -->
        <div class="section-block featured-media page-intro small tm-slider-parallax-container">
            <div class="tm-slider-container full-width-slider" data-parallax data-parallax-fade-out data-animation="slide" data-scale-under="1140">
                <ul class="tms-slides">
                    <li class="tms-slide" data-image data-force-fit data-overlay-bkg-color="#000000" data-overlay-bkg-opacity="0.3">
                        <div class="tms-content">
                            <div class="tms-content-inner center">
                                <div class="row flex">
                                    <div class="column width-6 offset-3">
                                        <div>
                                            <h1 class="tms-caption mb-0 color-white"
                                                data-animate-in="preset:slideInUpShort;duration:1000ms;delay:100ms;"
                                                data-no-scale
                                            >Contact Us</h1>
                                            <div class="clear"></div>
                                            <p class="tms-caption lead mb-0 mb-mobile-20 color-white opacity-07"
                                               data-animate-in="preset:slideInUpShort;duration:1000ms;delay:100ms;"
                                               data-no-scale
                                            >Stay in the loop with Easytow</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <img data-src="/images/bg.jpg" data-retina src="/images/bg.jpg" alt=""/>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Full Width Slider Section -->

        <!-- About Intro -->
        <div class="section-block replicable-content">
            <div class="row">
                <div class="column width-8 offset-2 center">
                    <p class="lead">Don't get stranded
                        Easytow just made it easy
                        Easytow is an app that makes being stranded cool.</p>
                </div>
            </div>
        </div>
        <!-- About Intro End -->

        <!--Contact Form -->
        <div class="section-block replicable-content contact-2 no-padding-top">
            <div class="row">
                <div class="column width-8 offset-2 center">
                    <h2 class="mb-30">Say Hello</h2>
                    <div class="contact-form-container">
                        <form class="contact-form" action="php/send-email.php" method="post" novalidate>
                            <div class="row">
                                <div class="column width-6">
                                    <div class="field-wrapper">
                                        <input type="text" name="fname" class="form-fname form-element rounded medium" placeholder="First Name*" tabindex="1" required>
                                    </div>
                                </div>
                                <div class="column width-6">
                                    <div class="field-wrapper">
                                        <input type="text" name="lname" class="form-lname form-element rounded medium" placeholder="Last Name" tabindex="2">
                                    </div>
                                </div>
                                <div class="column width-6">
                                    <div class="field-wrapper">
                                        <input type="email" name="email" class="form-email form-element rounded medium" placeholder="Email address*" tabindex="3" required>
                                    </div>
                                </div>
                                <div class="column width-6">
                                    <div class="field-wrapper">
                                        <input type="text" name="website" class="form-wesite form-element rounded medium" placeholder="Website" tabindex="4">
                                    </div>
                                </div>
                                <div class="column width-6">
                                    <input type="text" name="honeypot" class="form-honeypot form-element rounded medium">
                                </div>
                            </div>
                            <div class="row">
                                <div class="column width-12">
                                    <div class="field-wrapper">
                                        <textarea name="message" class="form-message form-element rounded medium" placeholder="Message*" tabindex="7" required></textarea>
                                    </div>
                                    <input type="submit" value="Send Email" class="form-submit button rounded medium bkg-theme bkg-hover-theme color-white color-hover-white">
                                </div>
                            </div>
                        </form>
                        <div class="form-response"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--Contact Form End -->

    </div>
@endsection