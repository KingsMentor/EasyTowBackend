@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row u-justify-center">
            <div class="col-lg-6 u-text-center">
                <h3 class="u-mb-small">Hello {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}, Welcome to EasyTow 🙂</h3>
                <p class="u-text-large u-mb-large">Update Profile to help us understand your needs better.</p>
            </div>
        </div>

        <div class="row">
           <div class="col-8" style="margin: 0px auto">
               <form id="regForm" style="margin: 0px auto;" method="post" action="{{ url('registration') }}" enctype="multipart/form-data">
                   <!-- One "tab" for each step in the form: -->
                   <div class="tab">
                       <h4 style="text-align: center;">Personal Information</h4>                   <br/>
@csrf
                       <label>First Name</label>
                       <p style="margin-bottom: 10px"><input placeholder="First name..." value="{{ auth()->user()->first_name }}" class="form-control" name="first_name"></p>

                       <label>Last Name</label>
                       <p style="margin-bottom: 10px"><input placeholder="Last name..." value="{{ auth()->user()->last_name }}" name="last_name"></p>


                       <label>Phone No</label>
                       <p style="margin-bottom: 10px"><input placeholder="Phone number" value="{{ auth()->user()->phone_no }}" name="phone_no"></p>
                       <br/>

                   </div>
                   <div class="tab">
                       <h4 style="text-align: center;">Registration Type</h4> <br/>
                       <label>You are registering as</label>
                       <p style="margin-bottom: 10px">
                           <select class="c-select__input" id="select_reg" onchange="registration_type()" name="type">
                                <option>Select registration Type</option>
                               <option value="0">Individual</option>
                               <option value="1">Company</option>
                               <option value="2">Affiliate Manager</option>
                           </select>
                       </p>
                       <p style="margin-bottom: 10px;display: none" id="company_form"><input placeholder="Company name..."   value="Company Name" name="company_name"></p>

                       <div class="c-alert c-alert--info alert u-mb-medium" id="individual" style="display: none;">
                            As an individual you can only add a driver and register a vehicle to your account
                       </div>

                       <div class="c-alert c-alert--info alert u-mb-medium" id="company"  style="display: none;">
                           As an organisation you can register multiple drivers and multiple vehicles
                       </div>
                   </div>
                   <div class="tab">
                       <h4 style="text-align: center;">Payment Detail</h4> <br/>
                       <label>Address</label>
                       <p style="margin-bottom: 10px"><input placeholder="Address" value="{{ auth()->user()->address }}" class="form-control" name="address"></p>

                       <label>Bank Name</label>
                       <p style="margin-bottom: 10px">
                           {!! Form::select('bank_id',$banks, '',['class' => 'form-control','style'=>'width: 100%;height:35px;']) !!}
                       </p>

                       <label>Account Name</label>
                       <p style="margin-bottom: 10px"><input placeholder="Account Name..." value="{{ auth()->user()->account_name }}" class="form-control" name="account_name"></p>


                       <label>Account No</label>
                       <p style="margin-bottom: 10px"><input placeholder="Account Name..." value="{{ auth()->user()->account_no }}" name="account_no"></p>


                        <br/>
                   </div>


                   <div style="overflow:auto;">

                       <div style="float:right;">
                           <button type="button" id="prevBtn" class="c-btn c-btn--success u-mb-xsmall" onclick="nextPrev(-1)">Previous</button>
                           <button type="button" id="nextBtn" class="c-btn c-btn--success u-mb-xsmall" onclick="nextPrev(1)">Next</button>
                       </div>
                   </div>
                   <!-- Circles which indicates the steps of the form: -->
                   <div style="text-align:center;margin-top:40px;">
                       <span class="step"></span>
                       <span class="step"></span>
                       <span class="step"></span>
                   </div>
               </form>

           </div>
        </div>




@endsection
