@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row u-justify-center">
            <div class="col-lg-12 u-text-center">

                <div class="container">
                    <div class="row">
                        <div class="col-md-7">

                            <nav class="c-tabs">
                                <div class="c-tabs__list nav nav-tabs" id="myTab" role="tablist">
                                    <a class="c-tabs__link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Activities</a>
                                    {{--<a class="c-tabs__link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Logs</a>--}}
                                </div>
                                <div class="c-tabs__content tab-content" id="nav-tabContent">
                                    <div class="c-tabs__pane active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="c-feed">
                                            <div class="c-feed__item">
                                                No Activity found
                                            </div>


                                        </div><!-- // .c-feed -->
                                    </div>
                                    {{--<div class="c-tabs__pane" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">No Found Found</div>--}}
                                </div>
                            </nav>
                        </div>

                        <div class="col-md-5">
                            <div class="c-card">
                                    <div class="u-text-center">
                                        <div class="c-avatar c-avatar--large u-mb-small u-inline-flex">
                                            <img src="{{ url('/').$driver->profile_pic }}" class="img-responsive c-avatar__img"/>
                                        </div>

                                        <h5>{{ $driver->name }}</h5>
                                    </div>

                                    <span class="c-divider u-mv-small"></span>

                                    <span class="c-text--subtitle">License</span>
                                    <p class="u-mb-small u-text-large"><a href="{{ url('/').$driver->license }}" target="_blank">View Document</a></p>

                                    <span class="c-text--subtitle">Phone NUMBER</span>
                                    <p class="u-mb-small u-text-large">{{ $driver->phone_no }}</p>


                            </div>


                        </div>
                    </div>


                </div>
            </div>





@endsection
