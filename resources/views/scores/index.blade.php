@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Scores</div>
                    <div class="card-body">
                        <a href="{{ url('/scores/create') }}" class="btn btn-success btn-sm" title="Add New Score">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/scores') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>#</th><th>Candidate Id</th><th>Yesr Id</th><th>Polling Unit Id</th><th>Sub District Id</th><th>Electorate Id</th><th>District Id</th><th>Province Id</th><th>Score</th><th>Round</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($scores as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->candidate_id }}</td><td>{{ $item->year_id }}</td><td>{{ $item->polling_unit_id }}</td><td>{{ $item->sub_district_id }}</td><td>{{ $item->electorate_id }}</td><td>{{ $item->district_id }}</td><td>{{ $item->province_id }}</td><td>{{ $item->score }}</td><td>{{ $item->round }}</td>
                                        <td>
                                            <a href="{{ url('/scores/' . $item->id) }}" title="View Score"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/scores/' . $item->id . '/edit') }}" title="Edit Score"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/scores' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Score" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $scores->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
