@extends('layouts.dashboard')

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="c-table-responsive@wide c-card">
                <h4>Add Driver</h4>
                <br/>

                @include('errors.showerror2')

                <div class="c-alert c-alert--info alert u-mb-medium">
                    <span class="c-alert__icon">
                      <i class="feather icon-info"></i>
                    </span>

                    <div class="c-alert__content">
                        <h4 class="c-alert__title">Information</h4>
                        <p>Kindly add a valid information because all information would be verified.</p>
                    </div>

                    <button class="c-close" data-dismiss="alert" type="button">×</button>
                </div>
                <form action="{{ url('/add/driver') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="c-field u-mb-medium">
                                <label class="c-field__label" for="user-name">Name</label>
                                <input class="c-input" type="text" name="name" value="{{ old('name') }}" id="user-name">
                            </div>

                            <div class="c-field u-mb-medium">
                                <label class="c-field__label" for="user-name">Email</label>
                                <input class="c-input" type="text" name="email" value="{{ old('email') }}" id="email">
                            </div>

                            <div class="c-field u-mb-medium">
                                <label class="c-field__label" for="user-name">Phone No</label>
                                <input class="c-input" type="text" name="phone_no" value="{{ old('phone_no') }}" id="user-name">
                            </div>

                            <div class="c-field u-mb-medium">
                                <label class="c-field__label" for="user-email">Profile Pic</label>
                                <input class="c-input" type="file" name="profile_pic" id="user-email">
                                <span style="color: red;font-size: 13px;">jpg, png, gif files supported</span>

                            </div>
                            <div class="c-field u-mb-medium">
                                <label class="c-field__label" for="user-phone">Driver's License</label>
                                <input class="c-input" type="file" name="license" id="user-email">
<span style="color: red;font-size: 13px;">only pdf, docx, doc files supported</span>
                            </div>
                            <div class="c-field u-mb-medium">
                                <label class="c-field__label" for="user-phone">Truck</label>
                                {!! Form::select('truck_id',$trucks,old('truck_id'),['class' => "c-select__input"]) !!}
                            </div>

                            <div class="c-field u-mb-medium">
                                <label class="c-field__label" for="user-name">Password</label>
                                <input class="c-input" type="password" name="password" value="{{ old('password') }}" id="password">
                            </div>

                        </div>


                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-7 col-xl-2 u-mr-auto u-mb-xsmall">
                            <button class="c-btn c-btn--success c-btn--fullwidth" style="float: right!important;" type="submit">Add Driver</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>


@endsection
