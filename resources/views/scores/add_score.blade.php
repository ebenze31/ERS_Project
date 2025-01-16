@extends('layouts.theme')

@section('content')
<style>
    .bg-dark {
        background-color: #000;
    }

    .radio-inputs .radio input {
        display: none;
    }

    .radio-inputs .radio .name {
        display: flex;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        border-radius: 50rem;
        border: .5px solid #000;
        color: rgba(51, 65, 85, 1);
        transition: all .15s ease-in-out;
        margin: 0 3px;
    }

    .radio-inputs .radio input:checked+.name {
        background-color: var(--btn-color);
        border-color: var(--btn-color);
        font-weight: 600;
        color: #fff;
    }
</style>
<div class="container mx-auto">

    <div class="w-100 h-[calc(100dvh-96px)] mt-[48px] flex justify-center  h-100 overflow-auto  ">
        <div class="block max-w-[800px]  w-full  mt-5">
            <div class="w-full flex items-center justify-center flex-shrink-0 ">
                <div class="w-full bg-white shadow-lg border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3 p-5 ">
                    <p class="text-[33px] font-extrabold header-text">กรอกคะแนน</p>

                    <div class="mt-5 max-sm:block flex items-center justify-between">
                        <p class="max-sm:text-[14.5px] max-sm:text-[#939393] max-sm:font-medium text-[19px] font-bold">อำเภอ</p>
                        <p class="max-sm:text-[19px] max-sm:text-[#000] max-sm:font-bold text-[16px]">{{ $data_polling_units->name_district }}</p>
                    </div>
                    <hr class="mt-2 mb-3 ">

                    <div class="mt-5 max-sm:block flex items-center justify-between">
                        <p class="max-sm:text-[14.5px] max-sm:text-[#939393] max-sm:font-medium text-[19px] font-bold">เขตเลือกตั้งที่</p>
                        <p class="max-sm:text-[19px] max-sm:text-[#000] max-sm:font-bold text-[16px]">{{ $data_polling_units->name_electorate }}</p>
                    </div>
                    <hr class="mt-2 mb-3 ">

                    <div class="mt-5 max-sm:block flex items-center justify-between">
                        <p class="max-sm:text-[14.5px] max-sm:text-[#939393] max-sm:font-medium text-[19px] font-bold">ตำบล</p>
                        <p class="max-sm:text-[19px] max-sm:text-[#000] max-sm:font-bold text-[16px]">{{ explode(" ",$data_polling_units->name_polling_unit)[0] }}</p>
                    </div>
                    <hr class="mt-2 mb-3 ">

                    <div class="mt-5 max-sm:block flex items-center justify-between">
                        <p class="max-sm:text-[14.5px] max-sm:text-[#939393] max-sm:font-medium text-[19px] font-bold">หน่วยเลือกตั้งที่</p>
                        <p class="max-sm:text-[19px] max-sm:text-[#000] max-sm:font-bold text-[16px] ">{{ explode(" ",$data_polling_units->name_polling_unit)[2] }}</p>
                    </div>
                    <hr class="mt-2 mb-3 ">


                    <div id="div_radio_select" class="radio-inputs  w-full grid grid-flow-col max-sm:justify-stretch justify-start mt-10">
                        <!-- radio -->
                    </div>

                    <div id="div_show_candidates">
                        <!--  -->
                    </div>



                    <p class=" max-sm:px-0 max-sm:text-center text-end p-0 mt-5"> เจ้าหน้าที่ผู้กรอกคะแนน</p>
                    <p class=" max-sm:px-0 max-sm:text-center text-end p-0 text-[#db2d2e]"> <u>{{ Auth::user()->name }}</u></p>

                    <div class="carousel-nav flex justify-end gap-2 pt-2">
                        <button id="btn_send_score" class="btn-color max-sm:w-full md:px-6 carousel-nav-next rounded-full bg-dark p-1.5 text-white shadow-sm hover:bg-gray-950 text-center mt-0 focus-visible:outline focus-visible:outline-1 focus-visible:outline-offset-2 focus-visible:outline-gray-200 transition-all duration-300" onclick="send_score();" disabled>
                            ยืนยัน
                        </button>
                    </div>

                    <div class="flex max-sm:justify-center justify-end items-center">
                        <span class="max-sm:px-0 text-center py-3 me-2">เวลาปัจจุบัน</span>
                        <span class="max-sm:px-0 text-center py-3" id="current-time"></span>
                    </div>
                    <script>
                        function updateTime() {
                            const currentTimeElement = document.getElementById('current-time');
                            let currentDate = new Date();

                            let hours = currentDate.getHours().toString().padStart(2, '0');
                            let minutes = currentDate.getMinutes().toString().padStart(2, '0');
                            let seconds = currentDate.getSeconds().toString().padStart(2, '0');

                            let currentTime = `${hours}:${minutes}:${seconds}`;

                            currentTimeElement.textContent = currentTime;
                        }

                        // เรียกใช้ฟังก์ชัน updateTime ทุก 1 วินาที (1000 มิลลิวินาที)
                        setInterval(updateTime, 1000);

                        // เรียกใช้ครั้งแรกเพื่อแสดงเวลาทันที
                        updateTime();
                    </script>
                </div>

            </div>
            <div class="w-full flex items-center justify-center flex-shrink-0 ">

                <div class="w-full bg-white shadow-lg border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3 p-5 mt-8 mb-10">
                    <p class="text-[30px] font-extrabold header-text mb-5">คะแนนลงไว้ล่าสุด</p>
                    <div id="div_record_score">
                        <!-- record_score -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        get_active_years();
        get_record_score();
    });

    function get_active_years() {
        fetch("{{ url('/') }}/api/get_active_years/" + "{{ $data_user->province }}")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network ตอบสนองไม่ OK " + response.statusText);
                }
                return response.json();
            })
            .then(result => {
                // console.log(result);

                if (result) {
                    let type_active = result['active'];
                    let type_active_sp = type_active.split(',');
                    // console.log(type_active_sp);

                    for (let i = 0; i < type_active_sp.length; i++) {
                        let html = `
                        <label class="radio">
                            <input type="radio" name="radio" >
                            <span class="name max-sm:px-0 px-6 py-2" onclick="open_div_candidates('` + type_active_sp[i] + `');">
                                ` + type_active_sp[i] + `
                            </span>
                        </label>
                    `;
                        document.querySelector('#div_radio_select').insertAdjacentHTML('beforeend', html); // แทรกล่างสุด

                        let html_div_input = `
                        <div class="max-sm:block flex for_data_candidates" name="` + type_active_sp[i] + `" style="display: none;">
                            
                        </div>
                    `;

                        let div_show_candidates = document.querySelector('#div_show_candidates');
                        div_show_candidates.insertAdjacentHTML('beforeend', html_div_input); // แทรกล่างสุด

                        // รับข้อมูลผู้สมัคร
                        let data_arr = [];
                        data_arr = {
                            "year_id": result['id'],
                            "type": type_active_sp[i],
                            "electorate_id": "{{ $data_polling_units->electorate_id }}",
                        };

                        fetch("{{ url('/') }}/api/get_candidates_of_electorate_id", {
                            method: 'post',
                            body: JSON.stringify(data_arr),
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        }).then(function(response) {
                            return response.json();
                        }).then(function(data) {
                            // console.log(data);
                            if (data) {

                                let div_data_candidates = document.querySelector('div[name="' + type_active_sp[i] + '"]');

                                for (let xi = 0; xi < data.length; xi++) {
                                    let html_candidates = `
                                    <div class="form-group row mt-4 w-1/2 max-sm:w-full me-2 ">
                                        <label class="col-md-4 col-form-label text-md-right text-[#939393] text-[14.5px]">
                                            คะแนนเบอร์ ` + data[xi]['number'] + ` ` + data[xi]['name'] + `
                                        </label>
                                        <input type="number" id="candidate_id_` + data[xi]['id'] + `" scores_for="` + type_active_sp[i] + `" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 " required />
                                    </div>
                                `;
                                    div_data_candidates.insertAdjacentHTML('beforeend', html_candidates); // แทรกล่างสุด
                                }
                            }
                        }).catch(function(error) {
                            // console.error(error);
                        });

                    }
                }

            }).catch(error => {
                console.error('Error:', error);
            });
    }

    var current_select_type;

    function open_div_candidates(type) {
        // console.log(type);
        current_select_type = type;

        // ซ่อน element ทั้งหมดที่มี class for_data_candidates
        let elements = document.querySelectorAll('.for_data_candidates');
        elements.forEach(element => {
            element.style.display = 'none';
        });

        // แสดง div ที่มี attribute name ตรงกับ type
        let div_data_candidates = document.querySelector('div[name="' + type + '"]');
        if (div_data_candidates) {
            div_data_candidates.style.display = ''; // แก้ไขจาก div_data_candidates.display เป็น div_data_candidates.style.display
        } else {
            console.log('No div found with name:', type);
        }

        document.querySelector('#btn_send_score').removeAttribute('disabled');
    }

    function send_score() {
        // console.log(current_select_type);

        // ดึง input ทั้งหมดที่ตรงกับเงื่อนไข scores_for
        let div_data_candidates = document.querySelectorAll('input[scores_for="' + current_select_type + '"]');

        // สร้าง Array เพื่อเก็บผลลัพธ์
        let candidatesData = [];

        // วนลูปดึงข้อมูล id, value และ scores_for
        div_data_candidates.forEach(input => {
            candidatesData.push({
                id: input.id,
                value: input.value,
                user_id: "{{ Auth::user()->id }}",
            });
        });

        // แสดงผลลัพธ์
        // console.log(candidatesData);

        fetch("{{ url('/') }}/api/send_score", {
            method: 'post',
            body: JSON.stringify(candidatesData),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function(response) {
            return response.text();
        }).then(function(data) {
            // console.log(data);
            if (data == "SUCCESS") {
                show_popup_success();
            }
        }).catch(function(error) {
            // console.error(error);
        });

    }

    function get_record_score() {
        fetch("{{ url('/') }}/api/get_record_score/" + "{{ Auth::user()->id }}")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network ตอบสนองไม่ OK " + response.statusText);
                }
                return response.json();
            })
            .then(result => {
                // console.log(result);
                if (result) {

                    let check_round = "";
                    for (let i = 0; i < result.length; i++) {
                        let div_record_score = document.querySelector('#div_record_score');

                        // console.log(result[i].round);
                        if (check_round != result[i].round) {

                            check_round = result[i].round;
                            let datetime = result[i].created_at;
                            let time = datetime.split(" ")[1].slice(0, 5);

                            let html_round = `
                            <div>
                                <p class="text-center text-[19px] text-[#000] font-bold">ครั้งที่ ` + result[i].round + `</p>
                                <div id="div_of_round">

                                </div>
                                <div class="flex justify-between items-center mb-3">
                                    <p class="text-[16px] text-[#000] font-bold">โดย {{ Auth::user()->name }}</p>
                                    <p class="text-[16px] text-[#939393]">เวลา ` + time + ` น.</p>
                                </div>
                                <hr class="mt-2 mb-3">
                            </div>
                        `;
                            div_record_score.insertAdjacentHTML('afterbegin', html_round); // แทรกบนสุด
                        }

                        let div_of_round = document.querySelector('#div_of_round');
                        let html = `
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-[16px] text-[#000] font-bold">
                                    เบอร์ ` + result[i].number_candidate + ` ` + result[i].name_candidate + `
                                </p>
                                <p class="text-[16px] text-[#939393]">` + result[i].score + ` คะแนน</p>
                            </div>
                        </div>
                    `;
                        div_of_round.insertAdjacentHTML('beforeend', html); // แทรกบนสุด

                    }

                }
            }).catch(error => {
                console.error('Error:', error);
            });
    }

    function show_popup_success() {
        Swal.fire({
            title: "เพิ่มข้อมูลเรียบร้อย",
            icon: "success",
            buttons: false,
            timer: 3000,
            showConfirmButton: false,
        }).then(() => {
            location.reload();
        });


    }
</script>

@endsection