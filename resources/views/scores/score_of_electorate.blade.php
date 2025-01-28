@extends('layouts.theme_admin')

@section('content')

<style>
/* The switch - the box around the slider */
.switch {
 font-size: 17px;
 position: relative;
 display: inline-block;
 width: 62px;
 height: 35px;
}

/* Hide default HTML checkbox */
.switch input {
 opacity: 1;
 width: 0;
 height: 0;
}

/* The slider */
.slider {
 position: absolute;
 cursor: pointer;
 top: 0;
 left: 0;
 right: 0;
 bottom: 0px;
 background: #fff;
 transition: .4s;
 border-radius: 30px;
 border: 1px solid #ccc;
}

.slider:before {
 position: absolute;
 content: "";
 height: 1.9em;
 width: 1.9em;
 border-radius: 16px;
 left: 1.2px;
 top: 0;
 bottom: 0;
 background-color: white;
 box-shadow: 0 2px 5px #999999;
 transition: .4s;
}

input:checked + .slider {
 background-color: #5fdd54;
 border: 1px solid transparent;
}

input:checked + .slider:before {
 transform: translateX(1.5em);
}
</style>

<!-- ข้อมูลหน่วย -->
<div class="row justify-content-center p-4">
    <div class="card-body">
        <div class="card">
            <div class="card-body">
                <div>
                    <h3 class="text-danger">
                        * หากเปิดการเพิ่มคะแนนแบบ Manual แล้ว การแสดงผลคะแนนของเขตนั้นๆ จะยึดจากคะแนนในส่วนนี้เป็นหลักโดยจะไม่นำคะแนนของแต่ละหน่วยในเขตเลือกตั้งนั้นๆ มารวมกันในการแสดงผล
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="card border-top border-0 border-4 border-primary">
                    <div id="div_content" class="card-body p-5">

                        @php
                            $check_name_district = "" ;
                            $check_first = "Yes" ;
                        @endphp
                        @foreach ($groupedData as $electorateId => $candidates)
                            <div class="row electorate">

                                @if( $check_name_district != $candidates->first()->name_district )
                                    @php
                                        $check_name_district = $candidates->first()->name_district ;
                                        if( $check_first == "Yes" ){
                                            $class_div = "" ;
                                            $check_first = "No" ;
                                        }else{
                                            $class_div = "mt-5" ;
                                        }
                                    @endphp
                                    <div class="col-12 {{ $class_div }}">
                                        <h2>{{ $candidates->first()->name_district }}</h2>
                                    </div>
                                @endif

                                @php
                                    $check_checked = "" ;
                                    $check_readonly = "readonly" ;
                                    if($candidates->first()->check_score_of_electorate == "Yes"){
                                        $check_checked = "checked" ;
                                        $check_readonly = "" ;
                                    }
                                @endphp

                                <div class="col-1">
                                    <label class="switch">
                                        <input id="open_{{$electorateId}}" type="checkbox" onclick="click_checkbox_open('{{$electorateId}}');" {{ $check_checked }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="col-11">
                                    <h5>เขตเลือกตั้งที่ {{ $candidates->first()->name_electorate }}</h5>
                                </div>

                                @foreach ($candidates as $candidate)

                                    @php
                                        $check_value = "" ;
                                        if($candidates->first()->check_score_of_electorate == "Yes"){
                                            $check_value = $candidate->score_of_electorate ;
                                        }
                                    @endphp

                                    <div class="col-md-6 mt-3">
                                        <label for="" class="form-label">
                                            เบอร์ {{ $candidate->number }} {{ $candidate->name }}
                                        </label>
                                        <input id="candidate_id_{{ $candidate->id }}" type="number" input_for="{{$electorateId}}" class="form-control" id="" min="0" {{ $check_readonly }} value="{{ $check_value }}">
                                    </div>
                                @endforeach
                            </div>
                            <hr style="height: 1.5px; background-color: red; border: none;margin: 20px 0;">
                        @endforeach


                        <center>
                            <button class="btn btn-success mt-3" style="width:50%;" onclick="click_submitScores();">
                                ยืนยันการกรอกคะแนน
                            </button>
                        </center>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .disabled {
        pointer-events: none;
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    let userProvince = '{{ $province }}';

    document.addEventListener('DOMContentLoaded', (event) => {

    });

    function click_checkbox_open(electorateId){
        let input_open = document.querySelector('#open_' + electorateId);
            // console.log(electorateId);
            // console.log(input_open.checked);

        // เลือก input ทั้งหมดที่มี attribute input_for="{{$electorateId}}"
        let input_for = document.querySelectorAll('[input_for="'+electorateId+'"]');
        
        input_for.forEach(input => {
            if (input_open.checked) {
                input.removeAttribute('readonly');
            } else {
                input.setAttribute('readonly', true);
                input.value = "";
            }
        });
    }

    function click_submitScores(){

        let div_data_user = document.createElement('div');

        Swal.fire({
            title: "ยืนยันการส่งคะแนนหรือไม่ ?",
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยกเลิก",
            // denyButtonText: `Don't save`
        }).then((result) => {
            // Handle the confirmation result
            if (result.isConfirmed) {
                submitScores();
            }
        });
    }

    let array_scores = {};  // ตัวแปรสำหรับเก็บข้อมูลในรูปแบบที่ต้องการ

    function submitScores() {
        // ค้นหา checkbox ที่มีการ checked และมี id เป็น open_{{$electorateId}}
        let checkedCheckboxes = document.querySelectorAll('input[id^="open_"]:checked');
        
        checkedCheckboxes.forEach(checkbox => {
            let electorateId = checkbox.id.replace('open_', '');  // เอาค่า electorateId จาก id ของ checkbox
            
            // ค้นหาทุก input ที่มี input_for="{{$electorateId}}"
            let candidateInputs = document.querySelectorAll(`input[input_for="${electorateId}"]`);
            
            candidateInputs.forEach(input => {
                let value = input.value;  // เก็บค่า value ของ input
                
                // เช็คว่ามี ElectorateId นี้ในอาร์เรย์แล้วหรือยัง
                if (!array_scores[electorateId]) {
                    array_scores[electorateId] = {};  // สร้างอาร์เรย์ย่อยสำหรับ ElectorateId นี้
                }

                // เก็บค่า value ของ candidate ที่ตรงกับ ElectorateId และ CandidateId
                let candidateId = input.id.replace('candidate_id_', '');
                array_scores[electorateId][candidateId] = value;
                
                // console.log(`Electorate['${electorateId}']['${candidateId}'] = ${value}`);
            });
        });

        sendScoresToAPI(array_scores);
    }

    function sendScoresToAPI(candidatesData) {
        fetch("{{ url('/') }}/api/send_score_of_electorate", {
            method: 'POST',
            body: JSON.stringify(candidatesData),  // แปลงเป็น JSON ก่อนส่ง
            headers: {
                'Content-Type': 'application/json'  // บอกให้เซิร์ฟเวอร์รู้ว่าเป็น JSON
            }
        })
        .then(function(response) {
            return response.text();
        })
        .then(function(data) {
            // console.log(data);
            if (data === "SUCCESS") {
                window.location.reload();
            }
        })
        .catch(function(error) {
            console.error(error);  // จัดการข้อผิดพลาด
        });
    }
</script>
@endsection
