@extends('layouts.theme_admin')

@section('content')
<div class="container mt-4">
    <div class="row">
        <h2 class="text-center mb-4">ผลคะแนนการเลือกตั้ง</h2>

        {{-- @foreach ($data as $result) --}}
            <div class="col-12 col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{ $result->district }</span>
                        <a href="{ route('election.details', $result->id) }" class="btn btn-sm btn-primary">ดูข้อมูลเพิ่มเติม</a>
                    </div>
                    <div class="card-body d-flex align-items-center">
                        <img src="{ asset('images/' . $result->candidate_image) }" alt="รูปผู้สมัคร" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        <div class="ms-3">
                            <h5 class="mb-1">{ $result->candidate_name }</h5>
                            <p class="mb-0 text-muted">{ number_format($result->votes) } คะแนน</p>
                        </div>
                    </div>
                </div>
            </div>
        {{-- @endforeach --}}

    </div>
</div>
@endsection

