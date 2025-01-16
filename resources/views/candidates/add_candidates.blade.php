
@extends('layouts.theme_admin')
@section('content')

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
            max-width: 500px;
            /* Increase size in mobile */
            max-height: 500px;
            /* Increase size in mobile */
        }
    }

    .btn-test {
        border-radius: 50px !important;
        color: #000;
        border: 1px solid #000 !important;
    }

    .btn-test:hover {
        background-color: #000;
        color: #fff !important;
    }

    .btn-test:not(.collapsed) {
        background-color: #000;
        color: #fff;
    }
</style>
<button class="  btn btn-test @if ($errors->any()) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
    เพิ่มจากไฟล์ Excel
</button>
<button class=" btn btn-test @if (!$errors->any()) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
    เพิ่มรายบุคคล
</button>

<div class="accordion accordion-flush" id="accordionFlushExample">
    <div class="accordion-item">
        <div id="flush-collapseOne" class="accordion-collapse collapse @if (!$errors->any()) show @endif" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                <div class="card">

                    <div class="d-flex justify-content-between px-4">
                        <h1 class=" mt-3">
                            เพิ่มจากไฟล์ Excel
                        </h1>

                        <div>
                            <a href="{{ url('/Excel/Template_candidates.xlsx') }}" download>
                                <button class="btn btn-info float-end mt-3" type="submit">
                                    Template Excel
                                </button>

                            </a>
                        </div>
                    </div>
                    <form id="uploadForm" class="row  p-4">
                        <div class="col-12 col-md-6 col-lg-4">
                            <label for="year_id" class="control-label">เลือกรอบการเลือกตั้ง</label>
                            <select class="form-control" name="year_id" id="year_id" onchange="check_disabled_btn();">

                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="type" class="control-label">{{ 'ประเภทผู้สมัคร' }}</label>
                                <div class="row">
                                    <div id="select-wrapper">
                                        <!-- Select Dropdown -->
                                        <select class="form-control" id="type-select">
                                            <option value="">เลือกประเภทผู้สมัคร</option>
                                            @foreach($type_candidates as $item_2)
                                            <option value="{{ $item_2->name }}">{{ $item_2->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="input-wrapper" class="d-none">
                                        <!-- Input Field -->
                                        <input type="text" class="form-control" id="type-input" placeholder="กรอกประเภทผู้สมัคร">
                                    </div>
                                </div>

                                <!-- Hidden Input -->
                                <input class="d-none" name="type" id="type_hidden">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <label>เพิ่มไฟล์ Excel เพื่อเพิ่มรายชื่อผู้สมัคร</label>
                            <input class="form-control" type="file" id="excelFile" accept=".xlsx, .xls" />
                        </div>
                        <div class="mt-3">

                            <button id="btn_submit_candidates" class="btn btn-success float-end" disabled type="submit">เพิ่มรายชื่อผู้สมัคร</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion-item">

        <div id="flush-collapseTwo" class="accordion-collapse collapse @if ($errors->any()) show @endif" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                <div class="card p-3">
                    <h1 class=" mt-3">
                        เพิ่มรายบุคคล
                    </h1>

                    @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif

                    <form id="myForm_CreateCandidate" method="POST" action="{{ url('/candidates') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @include ('candidates.form', ['formMode' => 'create'])

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<button type="button" class="btn btn-secondary btn-block w-100 d-none" id="toggle-input">
                                    เพิ่มข้อมูลใหม่
                                </button>
<script>

    document.addEventListener('DOMContentLoaded', (event) => {
       getData();
    });

    function check_disabled_btn(){

        let year_id = document.querySelector('#year_id').value;
        let type_candidates = document.querySelector('#type_hidden').value;
            // console.log(year_id);
            // console.log(type_candidates);

        if(year_id && type_candidates){
            document.querySelector('#btn_submit_candidates').removeAttribute('disabled');
        }
        else{
            document.querySelector('#btn_submit_candidates').setAttribute('disabled', '');
        }

    }

    function getData () {
        fetch("{{ url('/') }}/api/get_data_years")
        .then(response => {
            if (!response.ok) {
                throw new Error("Network ตอบสนองไม่ OK " + response.statusText);
            }
            return response.json();
        })
        .then(result => {
            // console.log(result);
            selectElectionVote(result) // ฟังก์ชันเพิ่มข้อมูลใน select พรรคการเมือง กับ select ปี/รอบการเลือกตั้ง
        }).catch(error => {
            console.error('Error:', error);
        });
    }

    // ==================================== สลับ input ประเภทผู้สมัคร ========================================================
    const selectWrapper = document.getElementById('select-wrapper');
    const inputWrapper = document.getElementById('input-wrapper');
    const selectElement = document.getElementById('type-select');
    const inputElement = document.getElementById('type-input');
    const hiddenInput = document.getElementById('type_hidden');
    const toggleButton = document.getElementById('toggle-input');

    // กำหนดค่าจาก Select ไปยัง Hidden Input
    selectElement.addEventListener('change', function () {
        hiddenInput.value = this.value; // เมื่อเลือกจาก Select จะเก็บค่าใน Hidden Input
        check_disabled_btn();
    });

    // กำหนดค่าจาก Input ไปยัง Hidden Input
    inputElement.addEventListener('input', function () {
        hiddenInput.value = this.value; // เมื่อพิมพ์ใน Input จะเก็บค่าใน Hidden Input
        check_disabled_btn();
    });

    // ฟังก์ชันสลับระหว่าง Select และ Input
    toggleButton.addEventListener('click', function () {
        if (selectWrapper.classList.contains('d-none')) {
            // แสดง Select และซ่อน Input
            selectWrapper.classList.remove('d-none');
            inputWrapper.classList.add('d-none');
            toggleButton.textContent = 'เพิ่มข้อมูลใหม่';
            document.querySelector('#type-input').value = "";

            // อัปเดต Hidden Input จาก Select
            hiddenInput.value = selectElement.value;
        } else {
            // แสดง Input และซ่อน Select
            selectWrapper.classList.add('d-none');
            inputWrapper.classList.remove('d-none');
            toggleButton.textContent = 'ตัวเลือก';
            document.querySelector('#type-select').value = "";

            // อัปเดต Hidden Input จาก Input
            hiddenInput.value = inputElement.value;
        }
        check_disabled_btn();
    });

    // ตั้งค่าเริ่มต้นให้ Hidden Input
    hiddenInput.value = selectElement.value; // ค่าเริ่มต้นมาจาก Select

    function selectElectionVote(result) {
        //============================== select ปีและรอบการเลือกตั้ง  ======================================

        const selectedYearId = '{{ isset($candidate->year_id) ? $candidate->year_id : ''}}';
        // console.log("selectedYearId :"+selectedYearId);

        const yearSelect = document.querySelector("#year_id");
        yearSelect.innerHTML = ""; // ล้างตัวเลือกเดิม

        const defaultOption_Year = document.createElement("option");
        defaultOption_Year.value = "";
        defaultOption_Year.textContent = "เลือกปี";
        yearSelect.appendChild(defaultOption_Year);

        for (let year of result['years']) {
            const option = document.createElement("option");
            option.value = year.id;
            option.textContent = `ปี ${parseInt(year.year) + 543} : รอบ ${year.round}`;

            // เช็คว่าปีนี้เป็นค่า selected หรือไม่
            if (selectedYearId && selectedYearId == year.id) {
                option.selected = true;
            }

            yearSelect.appendChild(option);
        }

    }

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("uploadForm").addEventListener("submit", async (e) => {
            e.preventDefault();

            const fileInput = document.getElementById("excelFile");
            const file = fileInput.files[0];

            if (!file) {
                alert("Please select an Excel file.");
                return;
            }

            let year_id = document.querySelector('#year_id').value;
            let type_candidates = document.querySelector('#type_hidden').value;
            const apiUrl = `{{ url('/') }}/api/excel_add_candidates`;

            const formData = new FormData();
            formData.append("file", file);
            formData.append("year_id", year_id);
            formData.append("type_candidates", type_candidates);

            try {
                const response = await fetch(apiUrl, {
                    method: "POST",
                    body: formData,
                });

                if (!response.ok) {
                    throw new Error(`Error: ${response.statusText}`);
                }

                const result = await response.text();
                console.log("API Response:", result);
                if(result == "SUCCESS"){
                    window.location.href = "{{ url('/') }}" + "/candidates";
                }
            } catch (error) {
                console.error("Error:", error);
            }
        });
    });
</script>
@endsection
