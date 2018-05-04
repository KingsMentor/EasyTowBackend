@extends('layouts.dashboard')

@section('content')
    <h4 style="padding-left: 10px">All Drivers  <a href="{{ url('/add/driver') }}" class="c-btn c-btn--success" style="float:right">Add Driver</a>
    </h4>

    <br/>
    <div class="row">
        <div class="col-12">
            @include('errors.showerror2')
            <div class="c-table-responsive@wide">
                @if($drivers->count() > 0)
                    <table class="c-table">
                        <thead class="c-table__head">
                        <tr class="c-table__row">
                            <th class="c-table__cell c-table__cell--head">Name</th>
                            <th class="c-table__cell c-table__cell--head">Picture</th>
                            <th class="c-table__cell c-table__cell--head">Driver License</th>
                            <th class="c-table__cell c-table__cell--head">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($drivers as $driver)
                            <tr class="c-table__row">
                                <td class="c-table__cell">
                                    {{ $driver->name }}
                                </td>
                                <td class="c-table__cell"><img src="{{ url('/').$driver->profile_pic }}" style="height: 50px;" class="img-responsive"/></td>
                                <th class="c-table__cell"><a href="{{ url('/').$driver->license }}" target="_blank">View Document</a></th>

                                <td class="c-table__cell">
                                    <div class="c-dropdown dropdown">
                                        <a href="{{ url('driver/'.encrypt_decrypt('encrypt',$driver->id)) }}" class="c-btn c-btn--success">
                                            View Profile
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="col-md-12">
                        <div class="c-card">
                            <h4 class="c-card__title">No Driver found!! </h4>
                            <p>You can add a driver by clicking the add truck button above</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


@endsection
