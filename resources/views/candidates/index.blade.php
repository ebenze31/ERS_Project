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
<div class="card">
    <div class="row justify-content-center p-4">
        <div class="col-7">
            <form id="uploadForm" class="row">
                <div class="col-12 mb-3">
                    <label for="year_id" class="control-label">เลือกรอบการเลือกตั้ง</label>
                    <select class="form-control" name="year_id" id="year_id" onchange="check_disabled_btn();">

                    </select>
                </div>
                <div class="col-12 mb-3">
                    <!-- ประเภทผู้สมัคร -->
                    <div class="form-group">
                        <label for="type" class="control-label">{{ 'ประเภทผู้สมัคร' }}</label>
                        <div class="row">
                            <div class="col-8">
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
                            <div class="col-4">
                                <!-- Toggle Button -->
                                <button type="button" class="btn btn-secondary btn-block w-100" id="toggle-input">
                                    เพิ่มข้อมูลใหม่
                                </button>
                            </div>
                        </div>

                        <!-- Hidden Input -->
                        <input class="d-none" name="type" id="type_hidden">
                    </div>
                </div>
                <div class="col-12">
                    <label>เพิ่มไฟล์ Excel เพื่อเพิ่มรายชื่อผู้สมัคร</label>
                </div>
                <div class="col-9">
                    <input class="form-control" type="file" id="excelFile" accept=".xlsx, .xls" />
                </div>
                <div class="col-3">
                    <button id="btn_submit_candidates" class="btn btn-success float-end" disabled type="submit">เพิ่มรายชื่อผู้สมัคร</button>
                </div>
                <hr class="mt-3 mb-3">
                <div class="col-12">
                    <a href="{{ url('/candidates/create') }}" class="btn btn-secondary btn-sm" title="Add New Candidate">
                        <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายชื่อผู้สมัครแบบรายบุคคล
                    </a>
                </div>
            </form>
        </div>
        <div class="col-5">
            <a href="{{ url('/Excel/Template_candidates.xlsx') }}" download>
                <button class="btn btn-info float-end mt-3" type="submit">
                    Download Template Excel
                </button>
            </a>
        </div>
    </div>
</div>
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
                    window.location.reload();
                }
            } catch (error) {
                console.error("Error:", error);
            }
        });
    });
</script>

<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Candidates</div>
                <div class="card-body">
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
                                        @elseif(!empty($item->img_url))
                                            <img src="{{ $item->img_url }}" class="logo-img">
                                        @else
                                            <img src="{{ url('images/stickerline/PNG/1.png') }}" class="logo-img">
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
