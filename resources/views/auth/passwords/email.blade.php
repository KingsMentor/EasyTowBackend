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
                            <h3>Forgot Password</h3>
                            <div class="login-form-container">

                                <div class="card-body">
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Send Password Reset Link') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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
