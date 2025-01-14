@extends('layouts.theme_admin')
@section('content')
    <style>
        /* From Uiverse.io by ErzenXz */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 70px;
            height: 30px;
            cursor: pointer;
        }

        .toggle-switch input[type="checkbox"] {
            display: none;
        }

        .toggle-switch-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #ddd;
            border-radius: 20px;
            box-shadow: inset 0 0 0 2px #ccc;
            transition: background-color 0.3s ease-in-out;
        }

        .toggle-switch-handle {
            position: absolute;
            top: 5px;
            left: 5px;
            width: 20px;
            height: 20px;
            background-color: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        .toggle-switch::before {
            content: "";
            position: absolute;
            top: -25px;
            right: -35px;
            font-size: 12px;
            font-weight: bold;
            color: #aaa;
            text-shadow: 1px 1px #fff;
            transition: color 0.3s ease-in-out;
        }

        .toggle-switch input[type="checkbox"]:checked+.toggle-switch-handle {
            transform: translateX(45px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2), 0 0 0 3px #05c46b;
        }

        .toggle-switch input[type="checkbox"]:checked+.toggle-switch-background {
            background-color: #05c46b;
            box-shadow: inset 0 0 0 2px #04b360;
        }

        .toggle-switch input[type="checkbox"]:checked+.toggle-switch:before {
            content: "On";
            color: #05c46b;
            right: -15px;
        }

        .toggle-switch input[type="checkbox"]:checked+.toggle-switch-background .toggle-switch-handle {
            transform: translateX(40px);
        }
    </style>
    <div class="container">
        <!-- Header Section -->
        <!-- Title -->
        <div class="container">
            <!-- Title Section -->
            <div class="row">
                <div class="col-12 text-center mb-3">
                    <span id="header_year" class="fs-4 fw-medium text-dark">

                    </span>
                </div>
            </div>

            <!-- Dropdown and Button Section -->
            <div class="row align-items-center justify-content-between p-3 bg-white">
                <!-- Dropdown Wrapper -->
                <div class="col-12 col-md-2" id="select-wrapper">
                    <select class="form-control dropdown" id="years_select" onchange="getData();">
                        <option value="">เลือกปีการเลือกตั้ง</option>
                        @foreach($years as $item)
                            <option value="{{ $item->id }}">ปี {{$item->year + 543}} : รอบ {{$item->round}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Add Button -->
                <div class="col-12 col-md-3 text-center text-md-end mt-3 mt-md-0">
                    <button class="btn btn-danger fw-bold py-2 px-4 w-100 w-md-auto">
                        เพิ่มปีการเลือกตั้ง
                    </button>
                </div>
            </div>
        </div>


        <!-- Card Data Section -->
        <div id="card_data_year" class="mt-4"></div>
    </div>


<script>
    document.addEventListener('DOMContentLoaded', (event) => {

    });

    let year_id;

    function getData() {
        // ดึงค่า value ของ option ที่ถูกเลือก
        const selectedValue = document.getElementById('years_select').value;
        console.log(selectedValue);
        fetch("{{ url('/') }}/api/getData_Election_Setting"+"?selected_year="+selectedValue)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network ตอบสนองไม่ OK " + response.statusText);
                }
                return response.json();
            })
            .then(result => {

                console.log(result);
                console.log(result['status']);
                year_id = result['id'];
                // setToggleFormData(result['status']);

                document.querySelector('#header_year').innerHTML =
                "ตั้งค่าการเลือก ปี " + (parseInt(result['year']) + 543) +
                " รอบการเลือกตั้งที่ " + result['round'];


                //============================== select ปีและรอบการเลือกตั้ง  ======================================

                // แทรก HTML ลงใน id="card_data_year"
                const cardDataYear = document.getElementById('card_data_year');
                cardDataYear.innerHTML = '';
                cardDataYear.innerHTML = `
                <div class="card  p-3 rounded">
                    <div class="row">
                        <div class="col-10 mb-3">
                            <div class="row">
                                <span class="mb-2">ประเภทผู้สมัครที่เปิดใช้</span>
                                <div class="d-flex flex-wrap gap-3 ">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="option2">
                                        <label class="form-check-label" for="option2">นายก อบจ.</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="option3">
                                        <label class="form-check-label" for="option3">ส. อบจ.</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="option4">
                                        <label class="form-check-label" for="option4">นายก อบต.</label>
                                    </div>
                                </div>
                            </div>

                            <div class="my-3">
                                <span class="mb-2">แสดงพรรคการเมือง</span>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="showParties">
                                    <label class="form-check-label" for="showParties">แสดงผล</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 mt-3 text-center">
                            <p id="toggle_status">${result['status'] === 'Yes' ? 'เปิดใช้งาน' : 'ปิดใช้งาน'}</p>
                            <label class="toggle-switch">
                                <input id="toggle_checkbox" type="checkbox" onchange="setToggle()" ${result['status'] === 'Yes' ? 'checked' : ''}>
                                <div class="toggle-switch-background">
                                    <div class="toggle-switch-handle"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                `;


            }).catch(error => {
                console.error('Error:', error);
            });
    }

    // ฟังก์ชันสำหรับตั้งค่า toggle
    function setToggle() {
        // ดึงสถานะของ checkbox
        const checkbox = document.getElementById('toggle_checkbox');
        const statusText = document.getElementById('toggle_status');
        const statusValue = checkbox.checked ? 'Yes' : '';
        // อัปเดตข้อความแสดงสถานะ
        statusText.textContent = checkbox.checked ? 'เปิดใช้งาน' : 'ปิดใช้งาน';

        if (statusValue === 'Yes') {
            updateData("Yes");
        } else {
            updateData("");
        }

    }

    function updateData(status) {
        console.log(year_id);
        console.log(status);

        fetch("{{ url('/') }}/api/activeStatusYear" + "?year_id="+year_id + "&status="+status)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network ตอบสนองไม่ OK " + response.statusText);
                }
                return response.json();
            })
            .then(result => {
                console.log(result);
            }).catch(error => {
                console.error('Error:', error);
            });
    }

</script>


@endsection
