@extends('layouts.theme_admin')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <h2 class="text-center mb-4">ผลคะแนนการเลือกตั้ง</h2>

            @foreach ($scores as $result)
                <div class="col-12 col-md-4 mb-4">
                    <div class="card shadow-sm" style="border-radius: 1.5rem;">
                        <div class="card-header d-flex justify-content-between align-items-center"
                            style="border-top-left-radius: 1.5rem; border-top-right-radius: 1.5rem;">
                            <span>{ $result->district }</span>
                            <a href="{ route('election.details', $result->id) }" class="text-dark">เพิ่มเติม</a>
                        </div>
                        <div class="d-flex align-items-center mx-3 mt-2">
                            @if(!empty($result->img))
                                <img class="rounded-circle me-3" src="{{ url('/storage'."/" . $result->img) }}" alt="User Avatar" style="width: 48px; height: 48px;">
                            @else
                                <img class="rounded-circle me-3" src="https://placehold.co/48x48" alt="User Avatar" style="width: 48px; height: 48px;">
                            @endif
                            <div>
                                <h2 class="h5 mb-0">{{ $result->name }}</h2>
                                <p class="text-secondary mb-0">
                                    @if(!empty($result->political_party_logo))
                                        <img class="rounded-circle me-1" src="{{ url('/storage'."/" . $result->political_party_logo) }}" alt="User Avatar" style="width: 14px; height: 14px;">
                                    @else
                                        <img class="rounded-circle me-1" src="https://placehold.co/48x48" alt="User Avatar" style="width: 14px; height: 14px;">
                                    @endif
                                    {{ $result->political_party_name }}
                                </p>
                            </div>
                            <span class="ms-auto text-success fw-bold fs-4">904</span>
                        </div>
                        <hr class="mx-3 mb-2">
                        <div class="d-flex align-items-center mx-3 mb-2 ">
                            <div>
                                <h2 class="h6 mb-0">{{ $result->name }}</h2>
                                <p class="text-secondary mb-0">
                                    @if(!empty($result->political_party_logo))
                                        <img class="rounded-circle me-1" src="{{ url('/storage'."/" . $result->political_party_logo) }}" alt="User Avatar" style="width: 14px; height: 14px;">
                                    @else
                                        <img class="rounded-circle me-1" src="https://placehold.co/48x48" alt="User Avatar" style="width: 14px; height: 14px;">
                                    @endif
                                    {{ $result->political_party_name }}
                                </p>
                            </div>
                            <span class="ms-auto text-dark fs-5">222</span>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
@endsection
