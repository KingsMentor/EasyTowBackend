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
                                    <a class="c-tabs__link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Trips</a>
                                    <a class="c-tabs__link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Logs</a>
                                </div>
                                <div class="c-tabs__content tab-content" id="nav-tabContent">
                                    <div class="c-tabs__pane active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="c-feed">
                                            <div class="c-feed__item">
                                               No trip found
                                            </div>


                                        </div><!-- // .c-feed -->
                                    </div>
                                    <div class="c-tabs__pane" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">No Log Found</div>
                                </div>
                            </nav>
                        </div>

                        <div class="col-md-5">
                            <div class="c-card">
                                @if($truck->driver_id)
                                <div class="u-text-center">
                                    <div class="c-avatar c-avatar--large u-mb-small u-inline-flex">
                                        <img src="{{ url('/').$truck->driver->profile_pic }}" class="img-responsive c-avatar__img"/>
                                    </div>

                                    <h5>{{ $truck->driver->name }}</h5>
                                </div>

                                <span class="c-divider u-mv-small"></span>

                                <span class="c-text--subtitle">License</span>
                                <p class="u-mb-small u-text-large"><a href="{{ url('/').$truck->driver->license }}" target="_blank">View Document</a></p>

                                <span class="c-text--subtitle">Phone NUMBER</span>
                                <p class="u-mb-small u-text-large">{{ $truck->driver->phone_no }}</p>

                                    @else
                                    <p>No Driver found, if you have a driver click the button below.</p>
                                    <button class="c-btn c-btn--info c-btn--fullwidth c-btn--outline" data-toggle="modal" data-target="#modal-delete">Select A Driver</button>

                                    <div class="c-modal c-modal--small modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete">
                                        <div class="c-modal__dialog modal-dialog" role="document">
                                            <div class="c-modal__content">
                                                <div class="c-modal__body">
                                    <span class="c-modal__close" data-dismiss="modal" aria-label="Close">
                                        <i class="feather icon-x"></i>
                                    </span>

<h3>Add a Driver</h3><br/>
                                                    @if($drivers)
                                                   <form action="{{ url('add/driver/truck') }}" method="post">
                                                   @csrf
                                                        <label style="float:left;">Select a Driver</label>
                                                       {!! Form::select('driver_id',["Select a Driver"] + $drivers,'',['class' => 'c-select__input']) !!}
<br/>
<input type="hidden" name="id" value="{{ $truck->id }}"/>
                                                    <div class="u-text-center">
                                                        <a href="#" class="c-btn c-btn--info c-btn--outline u-mr-small" data-dismiss="modal" aria-label="Close">Cancel</a>
                                                        <button type="submit" class="c-btn c-btn--info">Add</button>
                                                    </div>
                                                   </form>
                                                        @else
                                                        <a href="{{ url('add/driver')  }}" class="c-btn c-btn--info c-btn--fullwidth c-btn--outline">Add A Driver</a>

                                                    @endif
                                                </div>
                                            </div><!-- // .c-modal__content -->
                                        </div><!-- // .c-modal__dialog -->
                                    </div><!-- // .c-modal -->

                                @endif






                            </div>

                            <div class="c-card">
                                <h4>Truck Details</h4>

                                <div class="o-media u-mb-small">
                                    <div class="o-media__img u-mr-xsmall">
                                        <p>Manufacturer:</p>
                                    </div>

                                    <div class="o-media__body u-flex u-justify-between">
                                        <p>{{ $truck->manufacturer }}</p>
                                    </div>
                                </div>



                                <div class="o-media u-mb-small">
                                    <div class="o-media__img u-mr-xsmall">
                                        <p>Model:</p>

                                    </div>

                                    <div class="o-media__body u-flex u-justify-between">
                                        <p>{{ $truck->model }}</p>
                                    </div>
                                </div>

                                <div class="o-media u-mb-small">
                                    <div class="o-media__img u-mr-xsmall">
                                        <p>Year:</p>
                                    </div>

                                    <div class="o-media__body u-flex u-justify-between">
                                        <p>{{ $truck->year }}</p>
                                    </div>
                                </div>

                                <div class="o-media">
                                    <div class="o-media__img u-mr-xsmall">
                                        <p>Plate No:</p>

                                    </div>

                                    <div class="o-media__body u-flex u-justify-between">
                                        <p>{{ $truck->plate_no }}</p>

                                    </div>
                                </div>


                                <div class="o-media">
                                    <div class="o-media__img u-mr-xsmall">
                                        <p>Chasis No:</p>

                                    </div>

                                    <div class="o-media__body u-flex u-justify-between">
                                        <p>{{ $truck->chasis_no }}</p>

                                    </div>
                                </div>



                                <div class="o-media">
                                    <div class="o-media__img u-mr-xsmall">
                                        <p>Engine No:</p>

                                    </div>

                                    <div class="o-media__body u-flex u-justify-between">
                                        <p>{{ $truck->engine_no }}</p>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>


                        </div>
            </div>





@endsection
