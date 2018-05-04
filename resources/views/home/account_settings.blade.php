@extends('layouts.dashboard')

@section('content')


    <div class="container">
        <form action="{{ url('update/account') }}" method="post">
            @csrf
        <div class="row">
            <div class="col-12">
                <nav class="c-tabs">
                    <div class="c-tabs__list nav nav-tabs" id="myTab" role="tablist">
                        <a class="c-tabs__link active show" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                    <span class="c-tabs__link-icon">
                      <i class="feather icon-settings"></i>
                    </span>Account Settings
                        </a>

                    </div>
                    <div class="c-tabs__content tab-content" id="nav-tabContent">
                        <div class="c-tabs__pane active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
@include('errors.showerror2')

                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="c-field u-mb-medium">
                                        <label class="c-field__label" for="user-name">First Name</label>
                                        <input class="c-input" type="text" name="first_name" value="{{ auth()->user()->first_name }}" id="user-name">
                                    </div>


                                    <div class="c-field u-mb-medium">
                                        <label class="c-field__label" for="user-email">Email Address</label>
                                        <input class="c-input" type="text" name="email" disabled value="{{ auth()->user()->email }}" id="user-email">
                                    </div>
                                    <div class="c-field u-mb-xsmall">
                                        <label class="c-field__label" for="user-plan">Account type</label>
                                        <div class="c-select">
                                            <select class="c-select__input" id="select_reg" onchange="registration_type()" name="type">
                                                <option>Select registration Type</option>
                                                <option value="0" {{ (auth()->user()->type== "0") ? "selected" : "" }}>Individual</option>
                                                <option value="1" {{ (auth()->user()->type== "1") ? "selected" : "" }}>Company</option>
                                            </select>
                                        </div>
                                    </div>




                                    <div class="c-alert c-alert--info alert u-mb-medium" id="individual" style="display: none;">
                                        As an individual you can only add a driver and register a vehicle to your account
                                    </div>

                                    <div class="c-alert c-alert--info alert u-mb-medium" id="company"  style="display: none;">
                                        As an organisation you can register multiple drivers and multiple vehicles
                                    </div>

                                    <div class="c-field u-mb-medium">
                                        <label class="c-field__label" for="user-email">Address</label>
                                        <input class="c-input" type="text" name="address" value="{{ auth()->user()->address }}" id="user-email">
                                    </div>


                                </div>

                                <div class="col-xl-4">

                                    <div class="c-field u-mb-medium">
                                        <label class="c-field__label" for="user-name">Last Name</label>
                                        <input class="c-input" type="text" name="last_name" value="{{ auth()->user()->last_name }}" id="user-name">
                                    </div>


                                    <div class="c-field u-mb-medium">
                                        <label class="c-field__label" for="user-phone">Phone Number</label>
                                        <input class="c-input" type="tel" id="user-phone" name="phone_no" value="{{ auth()->user()->phone_no }}">
                                    </div>

                                    <div class="c-field u-mb-medium" id="company_form">
                                        <label class="c-field__label" for="user-email">Company Name</label>
                                        <input placeholder="Company name..." class="c-input"   value="{{ auth()->user()->company_name }}" name="company_name">

                                    </div>
                                </div>

                                <div class="col-xl-4">


                                    <div class="c-field u-mb-medium">
                                        <label class="c-field__label" for="user-name">Account Name</label>
                                        <input class="c-input" type="text" name="account_name" value="{{ auth()->user()->account_name }}" id="user-name">
                                    </div>

                                    <div class="c-field u-mb-medium">
                                        <label class="c-field__label" for="user-name">Bank Name</label>
                                        <input class="c-input" type="text" name="bank_name" value="{{ auth()->user()->bank_name }}" id="user-name">
                                    </div>

                                    <div class="c-field u-mb-medium">
                                        <label class="c-field__label" for="user-name">Account No</label>
                                        <input class="c-input" type="text" name="account_no" value="{{ auth()->user()->account_no }}" id="user-name">
                                    </div>



                                </div>

                                </div>

                            <span class="c-divider u-mv-medium"></span>

                            <div class="row">
                                <div class="col-12 col-sm-7 col-xl-2 u-mr-auto u-mb-xsmall">
                                    <button type="submit" class="c-btn c-btn--info c-btn--fullwidth">Save Settings</button>
                                </div>

                                <div class="col-12 col-sm-5 col-xl-3 u-text-right">
                                    <button class="c-btn c-btn--danger c-btn--fullwidth c-btn--outline" type="button" data-toggle="modal" data-target="#modal-delete">Delete My Account</button>

                                    <div class="c-modal c-modal--small modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete">
                                        <div class="c-modal__dialog modal-dialog" role="document">
                                            <div class="c-modal__content">
                                                <div class="c-modal__body">
                                    <span class="c-modal__close" data-dismiss="modal" aria-label="Close">
                                        <i class="feather icon-x"></i>
                                    </span>

                                                    <span class="c-icon c-icon--danger c-icon--large u-mb-small">
                                      <i class="feather icon-alert-triangle"></i>
                                    </span>
                                                    <h3 class="u-mb-small">Do you want to delete your account?</h3>

                                                    <p class="u-mb-medium">By deleting you account, you no longer have access to your dashboard, members and your information.</p>

                                                    <p>This Feature is Disabled</p>
                                                </div>
                                            </div><!-- // .c-modal__content -->
                                        </div><!-- // .c-modal__dialog -->
                                    </div><!-- // .c-modal -->
                                </div>
                            </div>
                        </div>

                        </div>
                </nav>
            </div>
        </div>
        </form>
    </div>
@endsection
