@extends('layouts.theme_admin')
@section('content')
<div class="card">
    <div class="row">

        <div class="col-md-12">
            <div class="">
                <div class="card-header">Candidates</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ผู้สมัคร</th>
                                    <th>เบอร์</th>
                                    <th>อำเภอ</th>
                                    <th>เขต</th>
                                    <th>ประเภทผู้สมัคร</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($candidates as $item)
                                <tr>
                                    <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: middle;">
                                        <div class="flex align-items-center">
                                            @if(!empty($item->img))
                                            <img src="{{ url('storage')}}/{{ $item->img }}" width="100" class="logo-img me-2">
                                            @elseif(!empty($item->img_url))
                                            <img src="{{ $item->img_url }}" width="100" class="logo-img me-2">
                                            @else
                                            <img src="{{ url('images/stickerline/PNG/1.png') }}" width="100" class="logo-img me-2">
                                            @endif
                                            {{ $item->name }}
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        {{ $item->number }}
                                    </td>
                                    <td style="vertical-align: middle;">
                                        {{ $item->name_district }}
                                    </td>
                                    <td style="vertical-align: middle;">
                                        {{ $item->name_electorate }}
                                    </td>
                                    <td style="vertical-align: middle;">{{ $item->type }}</td>
                                    <!-- <td style="vertical-align: middle; text-align: right; p-2">
                                        <a href="{{ url('/candidates/' . $item->id) }}" title="View Candidate"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                        <a href="{{ url('/candidates/' . $item->id . '/edit') }}" title="Edit Candidate"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                        <form method="POST" action="{{ url('/candidates' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Candidate" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                        </form>
                                    </td> -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection