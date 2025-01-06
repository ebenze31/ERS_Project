@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Polling_unit {{ $polling_unit->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/polling_units') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/polling_units/' . $polling_unit->id . '/edit') }}" title="Edit Polling_unit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('polling_units' . '/' . $polling_unit->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Polling_unit" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $polling_unit->id }}</td>
                                    </tr>
                                    <tr><th> Name Polling Unit </th><td> {{ $polling_unit->name_polling_unit }} </td></tr><tr><th> Province Id </th><td> {{ $polling_unit->province_id }} </td></tr><tr><th> District Id </th><td> {{ $polling_unit->district_id }} </td></tr><tr><th> Electorate Id </th><td> {{ $polling_unit->electorate_id }} </td></tr><tr><th> Sub District Id </th><td> {{ $polling_unit->sub_district_id }} </td></tr><tr><th> Eligible Voters </th><td> {{ $polling_unit->eligible_voters }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
