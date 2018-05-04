@extends('layouts.dashboard')

@section('content')
    <h4 style="padding-left: 10px">All Trucks  <a href="{{ url('/add/truck') }}" class="c-btn c-btn--success" style="float:right">Add Truck</a>
    </h4>

    <br/>
    <div class="row">
        <div class="col-12">
            <div class="c-table-responsive@wide">
                @if($trucks->count() > 0)
                <table class="c-table">
                    <thead class="c-table__head">
                    <tr class="c-table__row">
                        <th class="c-table__cell c-table__cell--head">Manufacturer</th>
                        <th class="c-table__cell c-table__cell--head">Model</th>
                        <th class="c-table__cell c-table__cell--head">Year</th>
                        <th class="c-table__cell c-table__cell--head">Plate No</th>
                        <th class="c-table__cell c-table__cell--head">Status</th>
                        <th class="c-table__cell c-table__cell--head">Driver</th>
                        <th class="c-table__cell c-table__cell--head">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($trucks as $truck)
                    <tr class="c-table__row">
                        <td class="c-table__cell">
                            {{ $truck->manufacturer }}
                        </td>
                        <td class="c-table__cell">{{ $truck->model }}</td>
                        <th class="c-table__cell">{{ $truck->year }}</th>
                        <td class="c-table__cell">{{ $truck->plate_no }}</td>
                        <td class="c-table__cell"><a class="c-badge c-badge--small c-badge--success" href="#">Pending</a></td>
                        <td class="c-table__cell">@if($truck->driver_id)
                                <a href="{{ url('/driver/'.encrypt_decrypt('encrypt',$truck->id)) }}">{{ optional($truck->driver)->name  }}</a>
                        @else
                                                      No Driver Selected
                        @endif</td>

                        <td class="c-table__cell">
                            <div class="c-dropdown dropdown">
                                <a href="{{ url('truck/'.encrypt_decrypt('encrypt',$truck->id)) }}" class="c-btn c-btn--success">
                                    View
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
                            <h4 class="c-card__title">No truck found!! </h4>
                            <p>You can add a truck by clicking the add truck button above</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


@endsection
