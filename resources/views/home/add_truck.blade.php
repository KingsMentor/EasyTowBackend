@extends('layouts.dashboard')

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="c-table-responsive@wide c-card">
                <h4>Add Trucks</h4>
<br/>
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
                <form action="{{ url('/add/truck') }}" method="post">
@csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="c-field u-mb-medium">
                            <label class="c-field__label" for="user-name">Manufacturer</label>
                            <input class="c-input" type="text" name="manufacturer" id="user-name">
                        </div>

                        <div class="c-field u-mb-medium">
                            <label class="c-field__label" for="user-email">Model</label>
                            <input class="c-input" type="text" name="model" id="user-email">
                        </div>
                        <div class="c-field u-mb-medium">
                            <label class="c-field__label" for="user-phone">Year</label>
                            <select class="c-select__input" name="year">
                            @for($i = 1985; $i <= date('Y'); $i++)
                                 <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                            </select>
                        </div>
                        <div class="c-field u-mb-medium">
                            <label class="c-field__label" for="user-phone">Plate No</label>
                            <input class="c-input" type="text" name="plate_no" id="user-phone">
                        </div>

                    </div>


                </div>
                <div class="row">
                    <div class="col-12 col-sm-7 col-xl-2 u-mr-auto u-mb-xsmall">
                        <button class="c-btn c-btn--success c-btn--fullwidth" style="float: right!important;" type="submit">Add Truck</button>
                    </div>

                </div>
                </form>

            </div>
        </div>
    </div>


@endsection
