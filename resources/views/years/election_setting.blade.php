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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="modal_create_year" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-4">
                <div class="modal-header">
                    <span class="h3" style="font-weight: bold;">เพิ่มปี/รอบการเลือกตั้ง</span>
                    <button class="btn btn-secondary " id="close_modal_create_year" type="button" class="close " data-dismiss="modal" aria-label="Close" onclick="clearFormFields()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modal_body" class="modal-body">
                    <style>
                        .font-weight-bold{
                            font-weight: bold;
                        }
                    </style>

                    <div id="form_create_year">
                        <div class="row mb-2">
                            <div class="col-4 form-group mt-2 {{ $errors->has('year') ? 'has-error' : '' }}">
                                <label for="year" class="font-weight-bold control-label">{{ 'ปีการเลือกตั้ง (พ.ศ.)' }}</label>
                                @php
                                    $currentYearAD = date('Y'); // ปี ค.ศ.
                                @endphp
                                <select required class="form-control" name="year" id="year">
                                    @for ($i = $currentYearAD; $i <= $currentYearAD + 2; $i++)
                                        <option value="{{ $i }}" {{ isset($year->year) && $year->year == $i ? 'selected' : '' }}>
                                            {{ $i + 543 }} <!-- แสดงปี พ.ศ. -->
                                        </option>
                                    @endfor
                                </select>
                                {{-- {!! $errors->first('year', '<p class="help-block text-danger">:message</p>') !!} --}}
                            </div>
                            <div class="col-4 form-group mt-2 {{ $errors->has('round') ? 'has-error' : '' }}">
                                <label for="round" class="font-weight-bold control-label">{{ 'รอบการเลือกตั้ง' }}</label>
                                <input  class="form-control" name="round" type="number" id="round" min="1"value="{{ isset($year->round) ? $year->round : '' }}">
                                {{-- {!! $errors->first('round', '<p class="help-block text-danger">:message</p>') !!} --}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-10">
                                <div class="row mt-3">
                                    <span class=" font-weight-bold">ประเภทผู้สมัครที่เปิดใช้ (optional)</span>
                                    <div id="checkbox-group" class="d-flex flex-wrap gap-3 ">
                                        @forEach($type_candidates as $type)
                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    name="candidate_types[]"
                                                    id="candidate-type-{{ $type->id }}"
                                                    value="{{ $type->name }}"
                                                    class="form-check-input"
                                                    onclick="updateActiveInput()"
                                                    >
                                                <label for="candidate-type-{{ $type->id }}" class="form-check-label">
                                                    {{ $type->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="d-none form-group mt-2 {{ $errors->has('active') ? 'has-error' : '' }}">
                                        <label for="active" class="control-label">{{ 'Active' }}</label>
                                        <input readonly class="form-control" name="active" type="text" id="active"
                                            value="{{ isset($year->active) ? $year->active : '' }}">
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <span class=" font-weight-bold">แสดงพรรคการเมือง (optional)</span>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="showPartiesCheckbox" onclick="updateShowPartiesInput()">
                                        <label class="form-check-label" for="showParties">แสดงผล</label>
                                    </div>
                                    <div class="d-none form-group mt-2 {{ $errors->has('show_parties') ? 'has-error' : '' }}">
                                        <label for="show_parties" class="control-label">{{ 'show_parties' }}</label>
                                        <input readonly class="form-control" name="show_parties" type="text" id="show_parties"
                                            value="{{ isset($year->show_parties) ? $year->show_parties : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4 " >
                            <button class="btn btn-primary w-25" onclick="submitForm()">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Header Section -->
        <!-- Title -->
        <div class="container">
            <!-- Title Section -->
            <div class="row">
                <div class="col-12 text-center mb-3">
                    <span id="header_year" class="fs-4 fw-medium text-dark">
                        ตั้งค่าการเลือก ปี - รอบการเลือกตั้งที่ -
                    </span>
                </div>
            </div>

            <!-- Dropdown and Button Section -->
            <div class="row align-items-center justify-content-between p-3 bg-white">
                <!-- Dropdown Wrapper -->
                <div class="col-12 col-md-3" id="select-wrapper">
                    {{-- <select class="form-control dropdown" id="years_select" onchange="getData();">
                        <option value="">เลือกปีการเลือกตั้ง</option>
                        @foreach($years as $item)
                            <option value="{{ $item->id }}">ปี {{$item->year + 543}} : รอบ {{$item->round}}</option>
                        @endforeach
                    </select> --}}
                </div>

                <!-- Add Button -->
                <div class="col-12 col-md-3 text-center text-md-end mt-3 mt-md-0">
                    <button class="btn btn-danger fw-bold py-2 px-4 w-100 w-md-auto" data-toggle="modal" data-target=".bd-example-modal-lg">
                        เพิ่มปีการเลือกตั้ง
                    </button>
                </div>
            </div>
        </div>


        <!-- Card Data Section -->
        <div id="card_data_year" class="mt-4"></div>
    </div>

<script>

    let year_id;
    let userProvince = '{{ Auth::user()->province }} ';
    let yearsSelect = '';
    let selectedYearDropdown = '';
    document.addEventListener('DOMContentLoaded', (event) => {
        createYearSelect(@json($years));
    });

    function createYearSelect(years) {
        console.log(years);
        yearsSelect = years;

        let select_wrapper = document.getElementById('select-wrapper');
        select_wrapper.innerHTML = '';

        let select = document.createElement('select');
        select.classList.add('form-control', 'dropdown');
        select.id = 'years_select';

        // ฟังก์ชันที่ใช้เก็บค่าที่เลือกใน selectedYearDropdown
        select.onchange = function (e) {
            selectedYearDropdown = e.target.value;  // เก็บค่า id ของปีที่เลือก
            getData();
            console.log("selected: " + selectedYearDropdown);
        };

        // สร้าง <option> ตัวแรก
        let firstOption = document.createElement('option');
        firstOption.value = '';
        firstOption.textContent = 'เลือกปีการเลือกตั้ง';
        select.appendChild(firstOption);

        // สร้าง <option> สำหรับแต่ละปี
        yearsSelect.forEach(function (item) {
            let option = document.createElement('option');
            option.value = item.id;

            // ตรวจสอบสถานะของปีและเพิ่มข้อความ (เปิดใช้งานล่าสุด) ถ้าสถานะเป็น 'Yes'
            if (item.status === 'Yes') {
                // สร้างข้อความหลัก (ปีและรอบ)
                var mainText = 'ปี ' + (parseInt(item.year) + 543) + ' : รอบ ' + item.round;

                // สร้างข้อความที่ต้องการแสดงเพิ่มเติม
                var additionalText = ' <span class="text-success">(เปิดใช้งานล่าสุด)</span>';

                // รวมข้อความหลักและข้อความเพิ่มเติม
                option.innerHTML = mainText + additionalText; // ใช้ innerHTML เพื่อรวมข้อความทั้งสอง
            } else {
                // ถ้า status ไม่ใช่ 'Yes', ให้แสดงปีและรอบปกติ
                option.textContent = 'ปี ' + (parseInt(item.year) + 543) + ' : รอบ ' + item.round;
            }

            // ตรวจสอบว่า id ของ option ตรงกับปีที่เลือกก่อนหน้านี้หรือไม่
            if (item.id == selectedYearDropdown) {
                option.selected = true;  // ถ้าตรงกัน ให้เลือก option นี้
            }

            select.appendChild(option);
        });

        // เพิ่ม <select> ลงใน select_wrapper
        select_wrapper.appendChild(select);
    }


    function submitForm() {
        let isValid = true;

        // ลบข้อความ error เก่าก่อน
        document.querySelectorAll('.help-block.text-danger').forEach(el => el.remove());

        // ตรวจสอบปีการเลือกตั้ง
        const yearInput = document.getElementById('year');
        if (!yearInput.value.trim()) {
            showError(yearInput, 'กรุณาเลือกปีการเลือกตั้ง');
            isValid = false;
        }

        // ตรวจสอบรอบการเลือกตั้ง
        const roundInput = document.getElementById('round');
        if (!roundInput.value.trim() || roundInput.value <= 0) {
            showError(roundInput, 'กรุณากรอกข้อมูลรอบการเลือกตั้ง');
            isValid = false;
        }

        // ถ้าข้อมูลไม่ถูกต้อง ให้หยุดการส่งฟอร์ม
        if (!isValid) {
            event.preventDefault();
        }

        // รวบรวมข้อมูล
        const data = {
            userProvince: userProvince,
            year: yearInput.value,
            round: roundInput.value,
            active: active.value,
            province: userProvince ? userProvince : null,
            show_parties: document.getElementById('showPartiesCheckbox').checked ? 'Yes' : null,
        };

        createDataYear(data);
    };

    // ฟังก์ชันแสดงข้อความ error
    function showError(input, message) {
        const errorElement = document.createElement('p');
        errorElement.className = 'help-block text-danger';
        errorElement.textContent = message;

        // ตรวจสอบว่า input อยู่ในกลุ่ม form-group หรือไม่
        const formGroup = input.closest('.form-group') || input.closest('#checkbox-group');
        if (formGroup) {
            formGroup.appendChild(errorElement);
        }
    }

    function createDataYear(data) {
        // ดึงค่า value ของ option ที่ถูกเลือก
        const selectedValue = document.getElementById('years_select').value;
        console.log(data);
        // ใช้ fetch ส่งข้อมูลแบบ POST
        fetch("{{ url('/') }}/api/create_new_year", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(data), // แปลงข้อมูลเป็น JSON
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        // ถ้ามีข้อมูลซ้ำ หรือข้อผิดพลาดจาก API
                        if (err.error) {
                            alert(err.error); // แจ้งเตือนข้อความจาก backend
                            throw new Error(err.error); // หยุดการทำงาน
                        }
                    });
                }
                return response.json();
            })
            .then(result => {
                console.log("Response from server:", result);
                alert("สร้างข้อมูลสำเร็จ!");
                createYearSelect(result.data);

                // ปิด modal
                $('#close_modal_create_year').click();
                clearFormFields();
            })
            .catch(error => {
                console.error("Error:", error);
                // alert("เกิดข้อผิดพลาดในการสร้างข้อมูล");
            });
    }

    // ฟังก์ชันสำหรับอัพเดตข้อมูล
    async function updateYearSettings() {
        // หาค่าของ checkbox ที่เกี่ยวข้อง
        const activeCandidates = [];
        const checkboxes = document.querySelectorAll('#candidateTypeCheckboxes .form-check-input');
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                activeCandidates.push(checkbox.value); // ใช้ชื่อของผู้สมัคร (candidate.name) เป็นค่า
            }
        });

        // เช็คค่า showParties
        const showParties = document.getElementById('showParties').checked ? 'Yes' : null;

        // เช็คค่า toggle switch ของ status
        const status = document.getElementById('toggle_checkbox').checked ? 'Yes' : null;

        // สร้าง payload สำหรับส่งไปยัง server
        const data_for_update = {
            year_id: year_id,
            active: activeCandidates.join(','),
            show_parties: showParties,
            status: status,
            userProvince: userProvince,
        };

        // ส่งข้อมูลไปอัพเดตที่ฐานข้อมูล
        try {
            const response = await fetch('{{ url('/') }}/api/update_new_year', {
                method: 'POST',
                headers: {
                   "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify(data_for_update)
            });

            const result = await response.json();
            if (result.success) {
                console.log('ข้อมูลอัพเดตสำเร็จ');
                // ตรวจสอบว่า result.data มีโครงสร้างที่ถูกต้องหรือไม่
                if (result.data && Array.isArray(result.data)) {
                    createYearSelect(result.data);  // ส่งข้อมูลที่มีโครงสร้างเป็น Array
                } else {
                    console.error('ข้อมูลที่ได้รับจาก API ไม่ถูกต้อง');
                }

            } else {
                console.log('เกิดข้อผิดพลาดในการอัพเดต');
            }
        } catch (error) {
            console.error('Error updating settings:', error);
        }
    }

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
                console.log(result['active']);

                year_id = result['id']; // ตั้งให้ ไอดีปี เป็นไอดีของปีที่เลือก

                const cardDataYear = document.getElementById('card_data_year');
                cardDataYear.innerHTML = "";
                if (result['year'] && result['round']) {
                    document.querySelector('#header_year').innerHTML ="ตั้งค่าการเลือก ปี " + (parseInt(result['year']) + 543) +" รอบการเลือกตั้งที่ " + result['round'];

                    card_html = `
                    <div class="card  p-3 rounded">
                        <div class="row">
                            <div class="col-10 mb-3">
                                <div class="row">
                                    <span class="mb-2">ประเภทผู้สมัครที่เปิดใช้</span>
                                    <div class="d-flex flex-wrap gap-3 " id="candidateTypeCheckboxes">
                                    </div>
                                </div>

                                <div class="my-3">
                                    <span class="mb-2">แสดงพรรคการเมือง</span>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="showParties" ${result['show_parties'] === 'Yes' ? 'checked' : ''}>
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
                } else {
                    document.querySelector('#header_year').innerHTML ="ตั้งค่าการเลือก ปี - รอบการเลือกตั้งที่ -";
                    card_html = '';
                }


                cardDataYear.insertAdjacentHTML('afterbegin', card_html); // แทรกบนสุด

                // แยกค่าจาก result['active'] ถ้ามีค่า
                const activeValues = result['active'] ? result['active'].split(',') : [];

                // สร้าง checkbox สำหรับแต่ละประเภทผู้สมัครจาก type_candidates
                const checkboxContainer = document.getElementById('candidateTypeCheckboxes');
                result['type_candidates'].forEach(candidate => {
                    const div = document.createElement('div');
                    div.classList.add('form-check');

                    const input = document.createElement('input');
                    input.type = 'checkbox';
                    input.classList.add('form-check-input');
                    input.id = `option_${candidate.id}`;
                    input.value = candidate.name; // ใช้ name เป็นค่า

                    // เช็คว่า active มีค่าตรงกับ candidate.name หรือไม่
                    if (activeValues.includes(candidate.name)) {
                        input.checked = true;  // ถ้ามีให้ติ๊ก checkbox
                    }

                    const label = document.createElement('label');
                    label.classList.add('form-check-label');
                    label.setAttribute('for', input.id);
                    label.textContent = candidate.name;  // ตั้งชื่อ checkbox ตามค่าจาก candidate.name

                    div.appendChild(input);
                    div.appendChild(label);
                    checkboxContainer.appendChild(div);
                });

                // สำหรับ update candidateTypeCheckboxes
                document.querySelectorAll('#candidateTypeCheckboxes .form-check-input').forEach(checkbox => {
                    checkbox.addEventListener('change', updateYearSettings);
                });

                // สำหรับ update showParties
                document.getElementById('showParties').addEventListener('change', updateYearSettings);

                // สำหรับ update showParties
                document.getElementById('toggle_checkbox').addEventListener('change', updateYearSettings);



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

        // if (statusValue === 'Yes') {
        //     updateData("Yes");
        // } else {
        //     updateData("");
        // }

    }

    // function updateData(status) {
    //     console.log(year_id);
    //     console.log(status);

    //     fetch("{{ url('/') }}/api/activeStatusYear" + "?year_id="+year_id + "&status="+status)
    //         .then(response => {
    //             if (!response.ok) {
    //                 throw new Error("Network ตอบสนองไม่ OK " + response.statusText);
    //             }
    //             return response.json();
    //         })
    //         .then(result => {
    //             console.log(result);
    //         }).catch(error => {
    //             console.error('Error:', error);
    //         });
    // }

    function updateActiveInput() {
        // ดึงค่า checkbox ที่ถูกติ๊กในกลุ่ม
        const checkedValues = Array.from(
            document.querySelectorAll('#checkbox-group input[type="checkbox"]:checked')
        ).map(checkbox => checkbox.value);

        // อัปเดตค่าใน input "active"
        const activeInput = document.getElementById('active');
        activeInput.value = checkedValues.join(',');
    }

    function updateShowPartiesInput() {
        // ดึงค่า checkbox
        const checkbox = document.getElementById('showPartiesCheckbox');

        // ดึง input "show_parties"
        const showPartiesInput = document.getElementById('show_parties');

        // อัปเดตค่าตามสถานะของ checkbox
        showPartiesInput.value = checkbox.checked ? 'Yes' : null;
    }

    // ฟังก์ชันเคลียร์ค่าในฟอร์มใน modal
    function clearFormFields() {
        // เคลียร์ค่าใน input field
        document.getElementById('year').value = new Date().getFullYear(); // เลือกปีปัจจุบัน
        document.getElementById('round').value = '';

        // เคลียร์ค่าใน checkbox
        document.querySelectorAll('#checkbox-group input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });

        // เคลียร์ค่าใน input ที่ไม่ได้แสดง (เช่น active, show_parties)
        document.getElementById('active').value = '';
        document.getElementById('show_parties').value = '';

        // รีเซ็ตสถานะ checkbox "แสดงผล"
        document.getElementById('showPartiesCheckbox').checked = false;
    }

</script>


@endsection
