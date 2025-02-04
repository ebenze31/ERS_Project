@extends('layouts.theme_admin')

@section('content')

    <style>
        /* สำหรับ PC */
        @media (min-width: 768px) {
            .width_mode{
                width: 75%;
                margin-top: 1.5rem;
                margin-bottom: 1rem;
                padding: 16px; /* เทียบเท่า p-4 */
            }
        }

        /* สำหรับ Mobile */
        @media (max-width: 767.98px) {
            .width_mode{
                width: 100%;
                margin-top: 1.5rem;
                margin-bottom: 1rem;
                padding: 8px; /* เทียบเท่า p-1 */
            }
        }
    </style>

    <!-- Card -->
    <div class="d-flex justify-content-center align-items-center flex-shrink-0 w-100">
        <div class="card bg-white shadow width_mode">
            <div class="card-body">
                @php
                    $pollingUnitParts = explode(' ', $data_polling_units->name_polling_unit);
                    $index0 = $pollingUnitParts[0] ?? '';
                    $index2 = $pollingUnitParts[2] ?? '';
                @endphp

                <p class="card-text h4 text-center" style="font-weight: bold;">
                    อำเภอ {{ $data_polling_units->name_district ? $data_polling_units->name_district : ''}}&nbsp;&nbsp;
                    เขตเลือกตั้งที่ {{ $data_polling_units->name_electorate ? $data_polling_units->name_electorate : ''}}&nbsp;&nbsp;
                    {{-- @if($data_polling_units->name_sub_districts)
                        ตำบล {{ $data_polling_units->name_sub_districts }}&nbsp;&nbsp;
                    @endif --}}
                    ตำบล {{ $index0 }}&nbsp;&nbsp;
                    เขตเลือกตั้งที่ {{ $index2 }}&nbsp;&nbsp;
                </p>
                <p class="card-text h4 text-center" style="font-weight: bold;">
                    {{-- เจ้าหน้าที่ {{ $data_polling_units->name_user ? $data_polling_units->name_user : ''}}&nbsp;&nbsp; --}}
                    จำนวนผู้มีสิทธิ {{ $data_polling_units->eligible_voters ? $data_polling_units->eligible_voters : ''}}&nbsp;&nbsp;
                </p>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center align-items-center flex-shrink-0 w-100">
        <div class="width_mode bg-light shadow  rounded-3 ">
            <p class="fs-4 fw-bold text-dark text-center mb-4">คะแนนที่ลงไว้ล่าสุด</p>
            <div id="div_record_score">
                <!-- record_score -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            get_record_score();
        });

        function get_record_score() {
            fetch("{{ url('/') }}/api/get_vote_score_history/" + "{{ $polling_unit_id }}")
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network ตอบสนองไม่ OK " + response.statusText);
                    }
                    return response.json();
                })
                .then(result => {
                    console.log(result);
                    if (result) {
                        let check_round = "";
                        for (let i = 0; i < result.length; i++) {
                            let div_record_score = document.querySelector('#div_record_score');

                            // ตรวจสอบว่ามี div สำหรับ round นี้หรือไม่
                            let div_of_round = document.querySelector(`#div_of_round_${result[i].round}`);
                            if (!div_of_round) {
                                // สร้าง div ใหม่สำหรับรอบที่ยังไม่มี
                                check_round = result[i].round;
                                let datetime = result[i].created_at;
                                let time = datetime.split(" ")[1].slice(0, 5);

                                let html_round = `
                                    <div class="card mb-3" >
                                        <div class="p-3 text-center bg-white">
                                            <h5 class="mb-0 fw-bold">ครั้งที่ ${result[i].round}</h5>
                                        </div>
                                        <div id="div_of_round_${result[i].round}" class="card-body">
                                        </div>
                                        <div class="p-2 d-flex justify-content-between align-items-center px-3 py-3 bg-white">
                                            <p class="mb-0 fw-bold">โดย {{ $data_polling_units->name_user }}</p>
                                            <p class="mb-0 text-muted">เวลา ${time} น.</p>
                                        </div>
                                    </div>
                                `;
                                div_record_score.insertAdjacentHTML('afterbegin', html_round); // แทรกบนสุด
                                div_of_round = document.querySelector(
                                `#div_of_round_${result[i].round}`); // อัปเดต div_of_round
                            }

                            // เพิ่มข้อมูลของผู้สมัครลงใน div ของรอบนี้
                            let html = `
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="mb-0 fw-bold text-dark">
                                            เบอร์ ${result[i].number_candidate} ${result[i].name_candidate}
                                        </p>
                                        <p class="mb-0 text-muted">${result[i].score} คะแนน</p>
                                    </div>
                                `;
                            div_of_round.insertAdjacentHTML('beforeend', html); // แทรกด้านล่างใน div ของรอบนั้น
                        }
                    }


                }).catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>

@endsection
