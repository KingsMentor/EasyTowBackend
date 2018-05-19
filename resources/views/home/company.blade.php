@extends('layouts.dashboard')

@section('content')
    <h4 style="padding-left: 10px">All Companies  <a href="{{ url('/add/company') }}" class="c-btn c-btn--success" style="float:right">Add Company</a>
    </h4>

    <br/>
    <div class="row">
        <div class="col-12">
            @include('errors.showerror2')
            <div class="c-table-responsive@wide">
                @if($companies->count() > 0)
                    <table class="c-table">
                        <thead class="c-table__head">
                        <tr class="c-table__row">
                            <th class="c-table__cell c-table__cell--head">Name</th>
                            <th class="c-table__cell c-table__cell--head">Address</th>
                            <th class="c-table__cell c-table__cell--head">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($companies as $company)
                            <tr class="c-table__row">
                                <td class="c-table__cell">
                                    {{ $company->name }}
                                </td>
                                <td class="c-table__cell">{{ $company->address }}</td>

                                <td class="c-table__cell">
                                    <div class="c-dropdown dropdown">
                                        <a onclick="delete_company('{{ url('company/delete/'.encrypt_decrypt('encrypt',$company->id)) }}')" class="c-btn c-btn--danger">
                                            Remove
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
                            <h4 class="c-card__title">No Company found!! </h4>
                            <p>You can add a company by clicking the add truck button above</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        function delete_company(url){
            var f = confirm("Are you sure you want to delete this company ?");
            if(f) {
                window.location = url;
            }
        }
    </script>

    @endsection
