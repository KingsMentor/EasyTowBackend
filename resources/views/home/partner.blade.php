@extends('layouts.home')

@section('content')

    <!-- Content -->
    <div class="content clearfix">

        <!-- Intro Section -->
        <div id="home" class="section-block hero-2-4 window-height clear-height-on-tablet" style="background: url('{{ url('/images/partner.jpg') }}')">
            <div class="media-overlay bkg-black opacity-05"></div>
            <div class="row flex v-align-middle">
                <div class="column width-12">
                    <div class="row flex one-column-on-tablet">
                        <div class="column width-6 v-align-middle">
                            <div>
                                <h1 class="color-white">Be a Partner with EasyTow</h1>
                                <p class="lead color-white">Earn good money with your Van.</p>
                                <a href="#about" class="scroll-link button rounded medium border-white bkg-hover-green color-white color-hover-white left mb-80">
                                    More Info
                                </a>
                            </div>
                        </div>
                        <div class="column width-5 offset-1">
                            <div class="signup-box box rounded xlarge mb-0 bkg-white shadow">
                                @if(!auth()->check())
                                    <h3>Login an Account</h3>
                                    <div class="register-form-container">
                                        @include('errors.showerrors')
                                        <form class="register-form" method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <div class="row">

                                                <div class="column width-12">
                                                    <div class="field-wrapper">
                                                        <label class="color-charcoal">Email:</label>
                                                        <input type="email" name="email" value="{{ old('email') }}" class="form-email form-element rounded medium" placeholder="johndoe@gmail.com" required>

                                                        @if ($errors->has('email'))
                                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="column width-12">
                                                    <div class="field-wrapper">
                                                        <label class="color-charcoal">Password:</label>
                                                        <input type="password" name="password" class="form-password form-element rounded medium" placeholder="•••••••• (8 or more characters)" required>
                                                        @if ($errors->has('password'))
                                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="column width-12 mt-10 center">
                                                    <input type="submit" value="Login" style="width: 100%;" class="form-submit button rounded medium bkg-green bkg-hover-theme bkg-focus-green color-white color-hover-white no-margins">
                                                </div>
                                            </div>
                                        </form>
                                        <div class="form-response show"></div>
                                    </div>
                                @else
                                    <h3>Welcome back, {{auth()->user()->first_name}} {{ auth()->user()->last_name }}</h3>
                                    <a href="{{ url('/home') }}" class="form-submit button rounded medium bkg-green bkg-hover-theme bkg-focus-green color-white color-hover-white no-margins">
                                        Continue ->
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Intro Section End -->

        <!-- About Section -->
        <div id="about" class="section-block replicable-content">
            <div class="row flex boxes one-column-on-tablet">
                <div class="column width-12 ">
                    <div>
                        <div class="row">
                            <div class="column width-10 offset-1">
                                <h3 class="mb-30">Why EasyTow?</h3>
                                <p class="lead mb-50">Easy Tow is a GPS-based mobile application which helps people to find the
                                    closest Tow Vehicle based on the user’s current position and vehicle to be towed</p>
                            </div>
                        </div>
                        <div class="row flex">
                            <div class="column width-3 offset-1">
                                <h4 class="mb-30">Earn money</h4>
                                <p class="mb-50">Drive with Easytow and earn extra income.</p>
                            </div>
                            <div class="column width-3">
                                <h4 class="mb-30">Drive anytime</h4>
                                <p class="mb-50">Work with your own schedule. No minimum hours and no boss..</p>
                            </div>
                            <div class="column width-3 offset-1">
                                <h4 class="mb-30">No monthly fees</h4>
                                <p class="mb-50"> No risk, you only pay when you earn.</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About Section End -->

        <!-- Hero 5 Section -->
        <div id="how-it-works" class="section-block hero-5 hero-5-5 right clear-height show-media-column-on-mobile bkg-grey-ultralight">
            <div class="media-column width-5 horizon" data-animate-in="preset:slideInRightShort;duration:1000ms;delay:200ms;" data-threshold="0.6"></div>
            <div class="row">
                <div class="column width-6">
                    <div class="hero-content split-hero-content">
                        <div class="hero-content-inner left horizon" data-animate-in="preset:slideInLeftShort;duration:1000ms;delay:200ms;" data-threshold="0.6">
                            <h3 class="mb-30">How It Works</h3>
                            <p class="lead mb-50">Morbi nec ultrices tellus. Fusce id est quis orci faucibus congue. Aliquam erat volutpat. Phasellus tortor velit, ornare at ullamcorper at. Ut enim ad minim veniam.</p>
                            <div class="row flex one-column-on-tablet">
                                <div class="column width-6">
                                    <div class="feature-column medium left">
                                        <span class="feature-icon icon-mobile color-green"></span>
                                        <div class="feature-text">
                                            <h4>On Mobile</h4>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                        </div>
                                    </div>
                                    <div class="feature-column medium left">
                                        <span class="feature-icon icon-browser color-green"></span>
                                        <div class="feature-text">
                                            <h4>On Desktop</h4>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="column width-6">
                                    <div class="feature-column medium left">
                                        <span class="feature-icon icon-tablet color-green"></span>
                                        <div class="feature-text">
                                            <h4>On Tablet</h4>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                        </div>
                                    </div>
                                    <div class="feature-column medium left">
                                        <span class="feature-icon icon-upload color-green"></span>
                                        <div class="feature-text">
                                            <h4>Frequent Updates</h4>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero 5 Section End -->



        <!-- Custom Call to Action Section -->
        <div class="section-block pt-60 pb-60 bkg-grey-ultralight">
            <div class="row flex two-columns-on-tablet">
                <div class="column width-5 offset-1 v-align-middle horizon" data-animate-in="preset:slideInLeftShort;duration:1000ms;delay:0;" data-threshold="1">
                    <p class="lead">Drive and earn, sign up today!</p>
                </div>
                <div class="column width-5 center v-align-middle horizon" data-animate-in="preset:slideInRightShort;duration:1000ms;delay:300;" data-threshold="1">
                    <div>
                        <a href="#home" class="scroll-link button rounded medium full-width bkg-green color-white bkg-hover-green color-hover-white no-marginsk">Create an Account</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Custom Call to Action Section End -->

    </div>
    <!-- Content End -->

    <!-- Footer -->


@endsection