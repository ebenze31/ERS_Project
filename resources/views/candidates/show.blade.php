@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Candidate {{ $candidate->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/candidates') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/candidates/' . $candidate->id . '/edit') }}" title="Edit Candidate"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('candidates' . '/' . $candidate->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Candidate" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $candidate->id }}</td>
                                    </tr>
                                    <tr><th> Name </th><td> {{ $candidate->name }} </td></tr><tr><th> Img </th><td> {{ $candidate->img }} </td></tr><tr><th> Number </th><td> {{ $candidate->number }} </td></tr><tr><th> Province Id </th><td> {{ $candidate->province_id }} </td></tr><tr><th> District Id </th><td> {{ $candidate->district_id }} </td></tr><tr><th> Electorate Id </th><td> {{ $candidate->electorate_id }} </td></tr><tr><th> Sub District Id </th><td> {{ $candidate->sub_district_id }} </td></tr><tr><th> Political Partie Id </th><td> {{ $candidate->political_partie_id }} </td></tr><tr><th> Year Id </th><td> {{ $candidate->year_id }} </td></tr><tr><th> Type </th><td> {{ $candidate->type }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
