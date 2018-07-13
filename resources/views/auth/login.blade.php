@extends('layouts.login')

@section('content')

    <div class="content clearfix">

        <!-- Hero 5 Login Section -->
        <div class="section-block hero-5 window-height left show-media-column-on-mobile">
            <div class="media-column width-6 bkg-grey-ultralight">
                <div class="tm-slider-container content-slider window-height" data-animation="slide" data-nav-arrows="false" data-nav-pagination="false" data-pause-on-hover="false" data-speed="2000" data-auto-advance data-auto-advance-interval="5000" data-progress-bar="false" data-scale-under="0" data-width="722">
                    <ul class="tms-slides">
                        <li class="tms-slide" data-image data-force-fit data-as-bkg-image data-animation="fade">
                            <img data-src="{{ url('/images/bg.jpeg') }}" data-retina src="{{ url('/images/bg.jpeg') }}" alt=""/>
                        </li>
                        <li class="tms-slide" data-image data-force-fit data-as-bkg-image data-animation="fade">
                            <img data-src="{{ url('/images/bg.jpeg') }}" data-retina src="{{ url('/images/bg.jpeg') }}" alt=""/>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="column width-5 offset-7">
                    <div class="hero-content split-hero-content">
                        <div class="hero-content-inner left">
                            <h3>Sign in to continue</h3>
                            <p class="mb-20">Need an Agent account? <a href="{{ url('/') }}" class="fade-location">Click Here</a></p>
                            <div class="login-form-container">
                                    <form method="POST" class="login-form" action="{{ route('login') }}">
                                        @csrf
                                    <div class="row">
                                        <div class="column width-12">
                                            <div class="field-wrapper">
                                                <label class="color-charcoal">Email:</label>
                                                <input id="email" type="email" class="form-username form-element rounded medium{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                                @if ($errors->has('email'))
                                                    <span style="color: red" class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="column width-12">
                                            <div class="field-wrapper">
                                                <label class="color-charcoal">Password:</label>
                                                <input id="password" type="password" class="form-password form-element rounded medium{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                                @if ($errors->has('password'))
                                                    <span style="color: red" class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="column width-12">
                                            <div class="field-wrapper pt-0 pb-20">
                                                <input id="checkbox-1" class="form-element checkbox rounded" name="remember" type="checkbox">
                                                <label for="checkbox-1" class="checkbox-label no-margins">Remember Me</label>
                                            </div>
                                        </div>

                                        <div class="column width-12">
                                            <input type="submit" value="Sign In" class="form-submit button rounded medium bkg-green bkg-hover-theme bkg-focus-green color-white color-hover-white mb-0">
                                        </div>
                                    </div>
                                </form>
                                <p class="text-small mt-20">I forgot my password - <a href="{{ route('password.request') }}">Remind me</a>
                                </p>
                                <div class="form-response show"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero 5 Login Section End -->




        </div>
        <!-- Subscribe Advanced Modal End -->

    </div>



@endsection
