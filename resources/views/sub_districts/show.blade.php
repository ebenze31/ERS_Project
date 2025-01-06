@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Sub_district {{ $sub_district->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/sub_districts') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/sub_districts/' . $sub_district->id . '/edit') }}" title="Edit Sub_district"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('sub_districts' . '/' . $sub_district->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Sub_district" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $sub_district->id }}</td>
                                    </tr>
                                    <tr><th> Name Sub Districts </th><td> {{ $sub_district->name_sub_districts }} </td></tr><tr><th> Province Id </th><td> {{ $sub_district->province_id }} </td></tr><tr><th> District Id </th><td> {{ $sub_district->district_id }} </td></tr><tr><th> Electorate Id </th><td> {{ $sub_district->electorate_id }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
