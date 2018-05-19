@extends('layouts.dashboard')

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="c-table-responsive@wide c-card">
                <h4>Add Company</h4>
                <br/>

                @include('errors.showerror2')


                <form action="{{ url('/add/company') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="c-field u-mb-medium">
                                <label class="c-field__label" for="user-name">Company Name</label>
                                <input class="c-input" type="text" name="name" value="{{ old('name') }}" required id="user-name">
                            </div>

                            <div class="c-field u-mb-medium">
                                <label class="c-field__label" for="user-name">Address</label>
                                <input placeholder="Address" class="c-input form-control" required name="address">
                            </div>

                            <div class="c-field u-mb-medium">
                                <label class="c-field__label" for="user-email">Bank Name</label>
                                {!! Form::select('bank_id',$banks, '',['class' => 'c-select__input form-control','required']) !!}
                            </div>

                            <div class="c-field u-mb-medium">
                                <label class="c-field__label" for="user-phone">Account Name</label>
                                <input class="c-input form-control" name="account_name" required>
                            </div>

                            <div class="c-field u-mb-medium">
                                <label class="c-field__label" for="user-phone">Account No</label>
                                <input class="c-input form-control" name="account_no" required>
                            </div>

                        </div>


                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-7 col-xl-2 u-mr-auto u-mb-xsmall">
                            <button class="c-btn c-btn--success c-btn--fullwidth" style="float: right!important;" type="submit">Add Company</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>


@endsection
