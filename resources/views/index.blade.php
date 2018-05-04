@extends('layouts.dashboard')

@section('content')

        <div class="row">
            <div class="col-md-6 @if(auth()->user()->type == "1")
                    col-xl-3
                    @else
                    col-xl-6
                    @endif">
                <div class="c-card">
                <span class="c-icon c-icon--info u-mb-small">
                  <i class="feather icon-activity"></i>
                </span>

                    <h3 class="c-text--subtitle">Trips</h3>
                    <h1>N0.00</h1>
                </div>
            </div>
@if(auth()->user()->type == "1")
            <div class="col-md-6 col-xl-3">
                <div class="c-card">
                <span class="c-icon c-icon--danger u-mb-small">
                  <i class="feather icon-anchor"></i>
                </span>

                    <h3 class="c-text--subtitle">Trucks</h3>
                    <h1>{{ $trucks }}</h1>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="c-card">
                <span class="c-icon c-icon--success u-mb-small">
                  <i class="feather icon-users"></i>
                </span>

                    <h3 class="c-text--subtitle">Drivers</h3>
                    <h1>{{ $drivers }}</h1>
                </div>
            </div>
@endif
            <div class="col-md-6  @if(auth()->user()->type == "1")
                    col-xl-3
                    @else
                    col-xl-6
                    @endif">
                <div class="c-card">
                <span class="c-icon c-icon--warning u-mb-small">
                  <i class="feather icon-zap"></i>
                </span>

                    <h3 class="c-text--subtitle">Revenue</h3>
                    <h1>N0.00</h1>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="c-card">
                <h4 class="c-card__title">No Trip !! </h4>
                <p>No trip was found in your account</p>
            </div>
        </div>

@endsection
