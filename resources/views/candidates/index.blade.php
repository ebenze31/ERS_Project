@extends('layouts.theme_admin')
<style>
    .logo-img {
        width: 30%;
        max-width: 50px;
        max-height: 50px;
        object-fit: contain;
    }

    /* Media query for mobile */
    @media (max-width: 768px) {
        .logo-img {
            width: 100%;
            max-width: 500px;  /* Increase size in mobile */
            max-height: 500px; /* Increase size in mobile */
        }
    }
</style>
@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Candidates</div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">

                            <a href="{{ url('/candidates/create') }}" class="btn btn-success btn-sm" title="Add New Candidate">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add New
                            </a>

                            <form autocomplete="off" method="GET" action="{{ url('/candidates') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right w-25" role="search">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                    <span class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>

                            <br/>
                            <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ชื่อ-สกุล</th>
                                        <th>รูป</th>
                                        <th>เบอร์</th>
                                        <th>Province Id</th>
                                        {{-- <th>District Id</th>
                                        <th>Electorate Id</th>
                                        <th>Sub District Id</th>
                                        <th>Political Partie Id</th> --}}
                                        <th>Year Id</th>
                                        <th>ประเภทผู้สมัคร</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($candidates as $item)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;">{{ $item->name }}</td>
                                        <td style="vertical-align: middle;" class="col-4 col-md-2">
                                            @if(!empty($item->img))
                                                <img src="{{ url('/storage'."/" . $item->img) }}" class="logo-img">
                                            @else
                                                <img src="{{ url('img/stickerline/PNG/10.png') }}" class="logo-img">
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">{{ $item->number }}</td>
                                        <td style="vertical-align: middle;">{{ $item->province_id }}</td>
                                        {{-- <td>{{ $item->district_id }}</td>
                                        <td>{{ $item->electorate_id }}</td>
                                        <td>{{ $item->sub_district_id }}</td>
                                        <td>{{ $item->political_partie_id }}</td> --}}
                                        <td style="vertical-align: middle;">{{ $item->year_id }}</td>
                                        <td style="vertical-align: middle;">{{ $item->type }}</td>
                                        <td style="vertical-align: middle; text-align: right; p-2">
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
