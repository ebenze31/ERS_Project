@extends('layouts.theme_admin')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Candidates</div>
                    <div class="card-body">
                        <a href="{{ url('/candidates/create') }}" class="btn btn-success btn-sm" title="Add New Candidate">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/candidates') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Name</th><th>Img</th><th>Number</th><th>Province Id</th><th>District Id</th><th>Electorate Id</th><th>Sub District Id</th><th>Political Partie Id</th><th>Year Id</th><th>Type</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($candidates as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td><td>{{ $item->img }}</td><td>{{ $item->number }}</td><td>{{ $item->province_id }}</td><td>{{ $item->district_id }}</td><td>{{ $item->electorate_id }}</td><td>{{ $item->sub_district_id }}</td><td>{{ $item->political_partie_id }}</td><td>{{ $item->year_id }}</td><td>{{ $item->type }}</td>
                                        <td>
                                            <a href="{{ url('/candidates/' . $item->id) }}" title="View Candidate"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/candidates/' . $item->id . '/edit') }}" title="Edit Candidate"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/candidates' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Candidate" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $candidates->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
