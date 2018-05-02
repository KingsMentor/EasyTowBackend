@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row u-justify-center">
            <div class="col-lg-12 u-text-center">

                <div class="container">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="c-alert c-alert--info u-mb-medium">
                <span class="c-alert__icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </span>

                                <div class="c-alert__content">
                                    <p class="c-alert__title" id="demo"></p>

                                    <p>For this features to be completed</p>
                                    <ul>
                                        <ol><p>Add A Car</p></ol>
                                        <ol><p>Add A Driver</p></ol>
                                        <ol><p>Upload of Images</p></ol>
                                    </ul>
                                </div>
                            </div><!-- // .c-alert -->

                            <nav class="c-tabs">
                                <div class="c-tabs__list nav nav-tabs" id="myTab" role="tablist">
                                    <a class="c-tabs__link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Activity</a>
                                    <a class="c-tabs__link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Documents</a>
                                </div>
                                <div class="c-tabs__content tab-content" id="nav-tabContent">
                                    <div class="c-tabs__pane active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="c-feed">
                                            <div class="c-feed__item">
                                                <div class="c-feed__item-content">
                                                    <h6 class="u-text-small">Updated Account</h6>
                                                </div>
                                                <p class="u-text-xsmall">{{ \Carbon\Carbon::parse(auth()->user()->created_at)->diffForHumans() }}</p>
                                            </div>


                                        </div><!-- // .c-feed -->
                                    </div>
                                    <div class="c-tabs__pane" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">No Document Found</div>
                                </div>
                            </nav>
                        </div>

                        <div class="col-md-5">
                            <div class="c-card">
                                <div class="u-text-center">
                                    <div class="c-avatar c-avatar--large u-mb-small u-inline-flex">
                                        <img class="c-avatar__img" src="http://via.placeholder.com/72" alt="Avatar">
                                    </div>

                                    <h5>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h5>
                                    @if(auth()->user()->company_name != "Company Name")
                                    <p>{{ auth()->user()->company_name }}</p>
                                        @endif
                                </div>

                                <span class="c-divider u-mv-small"></span>

                                <span class="c-text--subtitle">Email Address</span>
                                <p class="u-mb-small u-text-large">{{ auth()->user()->email }}</p>

                                <span class="c-text--subtitle">Phone NUMBER</span>
                                <p class="u-mb-small u-text-large">{{ auth()->user()->phone_no }}</p>

                                <span class="c-text--subtitle">Address</span>
                                <p class="u-mb-small u-text-large">{{ auth()->user()->address }}</p>

                                {{--<span class="c-text--subtitle u-block">Tags</span>--}}
                                {{--<a class="c-badge c-badge--small c-badge--info u-mb-xsmall" href="#">Sketch</a>--}}
                                {{--<a class="c-badge c-badge--small c-badge--info u-mb-xsmall" href="#">Photoshop</a>--}}
                                {{--<a class="c-badge c-badge--small c-badge--danger u-mb-xsmall" href="#">HTML</a>--}}
                                {{--<a class="c-badge c-badge--small c-badge--success u-mb-xsmall" href="#">CSS</a>--}}
                                {{--<a class="c-badge c-badge--small c-badge--fancy u-mb-xsmall" href="#">Figma</a>--}}
                                {{--<a class="c-badge c-badge--small c-badge--danger" href="#">AE</a>--}}
                            </div>

                            <div class="c-card">
                                <h4>Payments</h4>

                                <div class="o-media u-mb-small">
                                    <div class="o-media__img u-mr-xsmall">
                                        <p>Bank:</p>
                                    </div>

                                    <div class="o-media__body u-flex u-justify-between">
                                        <p>{{ auth()->user()->bank_name }}</p>
                                    </div>
                                </div>

                                <div class="o-media u-mb-small">
                                    <div class="o-media__img u-mr-xsmall">
                                        <p>Account Name:</p>

                                    </div>

                                    <div class="o-media__body u-flex u-justify-between">
                                        <p>{{ auth()->user()->account_name }}</p>
                                    </div>
                                </div>

                                <div class="o-media">
                                    <div class="o-media__img u-mr-xsmall">
                                        <p>Account No:</p>

                                    </div>

                                    <div class="o-media__body u-flex u-justify-between">
                                        <p>{{ auth()->user()->account_no }}</p>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                <script>
                    // Set the date we're counting down to
                    var countDownDate = new Date("May 3, 2018 9:00:00").getTime();

                    // Update the count down every 1 second
                    var x = setInterval(function() {

                        // Get todays date and time
                        var now = new Date().getTime();

                        // Find the distance between now an the count down date
                        var distance = countDownDate - now;

                        // Time calculations for days, hours, minutes and seconds
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Display the result in the element with id="demo"
                        document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                            + minutes + "m " + seconds + "s ";

                        // If the count down is finished, write some text
                        if (distance < 0) {
                            clearInterval(x);
                            document.getElementById("demo").innerHTML = "EXPIRED";
                        }
                    }, 1000);
                </script>
            </div>
        </div>





@endsection
