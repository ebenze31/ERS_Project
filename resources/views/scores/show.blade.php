@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Score {{ $score->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/scores') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/scores/' . $score->id . '/edit') }}" title="Edit Score"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('scores' . '/' . $score->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Score" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $score->id }}</td>
                                    </tr>
                                    <tr><th> Candidate Id </th><td> {{ $score->candidate_id }} </td></tr><tr><th> Yesr Id </th><td> {{ $score->year_id }} </td></tr><tr><th> Polling Unit Id </th><td> {{ $score->polling_unit_id }} </td></tr><tr><th> Sub District Id </th><td> {{ $score->sub_district_id }} </td></tr><tr><th> Electorate Id </th><td> {{ $score->electorate_id }} </td></tr><tr><th> District Id </th><td> {{ $score->district_id }} </td></tr><tr><th> Province Id </th><td> {{ $score->province_id }} </td></tr><tr><th> Score </th><td> {{ $score->score }} </td></tr><tr><th> Round </th><td> {{ $score->round }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
