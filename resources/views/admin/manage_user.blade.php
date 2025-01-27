@extends('layouts.theme_admin')

@section('content')
    <style>
        .width_responsive {
            width: 27% !important;
        }
        .flex_left{
            flex: 0 0 60%;
        }
        .flex_right{
            flex: 0 0 30%;
        }

        /* สำหรับหน้าจอมือถือ */
        @media (max-width: 768px) {
            .width_responsive {
                width: 100% !important;
            }
            .flex_left{
                flex: 0 0 100%;
            }
            .flex_right{
                flex: 0 0 100%;
            }
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 100px; /* ปรับความกว้าง */
            height: 30px; /* ปรับความสูงให้เหมาะสม */
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

        .toggle-switch input[type="checkbox"]:checked + .toggle-switch-background {
            background-color: #05c46b;
            box-shadow: inset 0 0 0 2px #04b360;
        }

        .toggle-switch input[type="checkbox"]:checked + .toggle-switch-background .toggle-switch-handle {
            transform: translateX(65px); /* ระยะการเลื่อนของปุ่ม */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2), 0 0 0 3px #05c46b;
        }

        .toggle-switch input[type="checkbox"]:checked + .toggle-switch-background::after {
            content: "active";
            position: absolute;
            top: 50%;
            left: 15%; /* ตำแหน่งข้อความ */
            transform: translateY(-50%);
            color: #fff;
            font-size: 16px; /* ขนาดข้อความ */
            font-weight: bold;
        }
    </style>

    </style>
    <!-- ข้อมูลหน่วย -->
    <div class="row justify-content-center p-4">
        <div class="card-header">
            <h4>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="m-2">จัดการผู้ใช้</p>
                    <p id="span_count_user" class="m-2" ></p>
                </div>
            </h4>
        </div>
        <div class="card-body">
            <div class="card">
                <!-- Use d-flex for a single row layout -->
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 m-4">
                    <!-- Left side: Search Inputs and Button -->
                    <form method="GET" action="{{ url('/manage_user') }}" accept-charset="UTF-8" class="d-flex flex-wrap gap-2 align-items-center flex_left" enctype="multipart/form-data">
                        <select id="search_district" name="search_district" class="form-control mb-0 width_responsive" onchange="get_District()">
                            <option value="">ค้นหาจากอำเภอ</option>
                            @foreach($data_district as $district)
                                <option value="{{ $district->id }}"
                                    {{ (isset($data_search['search_district']) && $data_search['search_district'] == $district->id) ? 'selected' : '' }}>
                                    {{ $district->name_district }}
                                </option>
                            @endforeach
                        </select>

                        <select id="search_electorate" name="search_electorate" class="form-control mb-0 width_responsive" onchange="get_PollingUnit();">
                            <option value="">ค้นหาจากเขตเลือกตั้ง</option>
                            @if(isset($data_search['search_electorate']))
                                <option selected value="{{ $data_search['search_electorate'] }}">{{ $data_search['search_electorate'] }}</option>
                            @endif
                        </select>

                        <select id="search_polling_unit" name="search_polling_unit" class="form-control mb-0 width_responsive">
                            <option value="">ค้นหาจากหน่วย</option>
                            @if(isset($data_search['search_polling_unit']))
                                <option selected value="{{ $data_search['search_polling_unit'] }}">{{ $data_search['search_polling_unit'] }}</option>
                            @endif
                        </select>

                        <!-- ใช้ d-inline-block เพื่อจัดแนวกับ input -->
                        <button type="submit" class="btn btn-primary d-inline-block align-items-center" >
                            <i class="fa-solid fa-magnifying-glass" style="margin-right: 0px !important;"></i>
                        </button>

                        <!-- Clear button -->
                        <button type="button" class="btn btn-secondary d-inline-block align-items-center"   onclick="clearSelects()">
                            <i class="fa-solid fa-trash " style="margin-right: 0px !important;"></i>
                        </button>

                        <script>
                            // ฟังก์ชันในการเคลียร์ค่า select
                            function clearSelects() {
                                // เคลียร์ค่าของแต่ละ select
                                document.getElementById('search_district').value = '';
                                document.getElementById('search_electorate').value = '';
                                document.getElementById('search_polling_unit').value = '';

                                // เรียกฟังก์ชันที่ต้องการหลังจากเคลียร์ค่าของ select
                                get_District();  // ถ้าจำเป็นต้องเรียกฟังก์ชันนี้หลังจากการเคลียร์
                                get_PollingUnit();  // ถ้าจำเป็นต้องเรียกฟังก์ชันนี้หลังจากการเคลียร์
                            }
                        </script>
                    </form>

                    <!-- Right side: Clear Data Button -->
                    <div class="flex_right d-flex justify-content-end gap-1" >
                        <button id="btn_add_status_user" type="button" class="btn btn-success m-1">
                            เปิดสถานะทั้งหมด
                        </button>
                        <button id="btn_clear_status_user" type="button" class="btn btn-danger m-1">
                            ปิดสถานะทั้งหมด
                        </button>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_users" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ชื่อ</th>
                                    <th>เบอร์</th>
                                    <th>เบอร์ 2</th>
                                    <th>อำเภอ</th>
                                    <th>เขตเลือกตั้งที่</th>
                                    <th>ตำบล</th>
                                    <th>หน่วยเลือกตั้งที่</th>
                                    <th class="text-center">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody id="users_body">
                                <!-- DATA -->
                            </tbody>
                        </table>
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

    <script>
        let userProvince = '{{ $province }}';

        document.addEventListener('DOMContentLoaded', (event) => {
            getdata_user();
            get_District();
            get_PollingUnit();
        });
        // คะแนนเฉลี่ยต่อเคสเจ้าหน้าที่
        function getdata_user() {

            let dataSearch = @json($data_search);

            let searchParams = new URLSearchParams();

            if (dataSearch.search_district) {
                searchParams.append('search_district', dataSearch.search_district);
            }
            if (dataSearch.search_electorate) {
                searchParams.append('search_electorate', dataSearch.search_electorate);
            }
            if (dataSearch.search_polling_unit) {
                searchParams.append('search_polling_unit', dataSearch.search_polling_unit);
            }

            fetch("{{ url('/') }}/api/manage_user_data?userProvince=" + userProvince + "&" + searchParams.toString())
                .then(response => {
                    if (!response.ok) {
                        console.log("response ไม่ตอบสนอง");
                    }
                    return response.json();
                })
                .then(result => {
                    console.log("Response from server:", result);

                    // Clear existing rows
                    const tbody = document.getElementById("users_body");
                    tbody.innerHTML = "";

                    const count_span_count_user = document.querySelector('#span_count_user');
                    count_span_count_user.innerHTML = `(ทั้งหมด ${result['count']} รายการ)`;

                    // สร้าง array ของ user_id
                    const user_ids = result['users'].map(item => item['user_id']);

                    const btn_add_status_user = document.querySelector('#btn_add_status_user');
                    btn_add_status_user.setAttribute('onclick', `multiConfirmUserToggle(${JSON.stringify(user_ids)}, "open_status")`);

                    const btn_clear_status_user = document.querySelector('#btn_clear_status_user');
                    btn_clear_status_user.setAttribute('onclick', `multiConfirmUserToggle(${JSON.stringify(user_ids)}, "close_status")`);

                    // Generate rows dynamically
                    result['users'].forEach(item => {
                        let html_view = `
                                <label class="toggle-switch">
                                    <input
                                        id="toggle_checkbox_user_${item['user_id']}"
                                        type="checkbox"
                                        onchange="confirmUserToggle(${item['user_id']})"
                                        ${item['status_user'] === 'active' ? 'checked' : ''}
                                    >
                                    <div class="toggle-switch-background">
                                        <div class="toggle-switch-handle"></div>
                                    </div>
                                </label>
                           `;

                        let row = document.createElement("tr");
                        row.setAttribute("id", "tr_" + item['user_id']);

                        row.innerHTML = `
                        <td>${item.name_user ? item.name_user : ''}</td>
                        <td>${item.phone_1_user ? item.phone_1_user : ''}</td>
                        <td>${item.phone_2_user ? item.phone_2_user : ''}</td>
                        <td>${item.name_district ? item.name_district : ''}</td>
                        <td>${item.name_electorate  ? item.name_electorate : ''}</td>
                        <td>${item.name_polling_unit.split(" ")[0]  ? item.name_polling_unit.split(" ")[0] : ''}</td>
                        <td>${item.name_polling_unit.split(" ")[2]  ? item.name_polling_unit.split(" ")[2] : ''}</td>
                        <td class="text-center">${html_view}</td>
                    `;

                        tbody.appendChild(row);
                    });

                })
                .catch(error => {
                    console.error("Error:", error);
                    // alert("เกิดข้อผิดพลาดในการสร้างข้อมูล");
                });
        }

        function confirmUserToggle(user_id) {
            const toggleElement = document.getElementById('toggle_checkbox_user_'+user_id);
            const isChecked = toggleElement.checked;

            if (isChecked) {
                // ถ้า checkbox ติ๊ก (เปิดสถานะ)
                Swal.fire({
                    title: "<h2 style='font-weight: bold;' class='text-success'>เปิดสถานะ?</h2>",
                    html: "<p style='font-size: 1.5rem; font-weight:bold;'>ต้องการเปิดสถานะหรือไม่</p>",
                    // icon: "info",
                    showCancelButton: true,
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก"
                }).then((result) => {
                    if (result.isConfirmed) {
                        setUserToggle(user_id, true , "open"); // ส่งสถานะเปิด
                        Swal.fire({
                            title: "สถานะถูกเปิดแล้ว!",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        toggleElement.checked = false; // ย้อนกลับค่า
                    }
                });
            } else {
                // ถ้า checkbox ไม่ติ๊ก (ปิดสถานะ)
                Swal.fire({
                        title: "<h2 style='font-weight: bold;'>ปิดสถานะ?</h2>",
                        html: "<p style='font-size: 1.5rem;'>ต้องการปิดสถานะและล้างข้อมูลด้วยหรือไม่?</p>",
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: "ปิดสถานะและล้างข้อมูล",
                        denyButtonText: "ปิดสถานะอย่างเดียว",
                        cancelButtonText: "ยกเลิก",
                        customClass: {
                            confirmButton: 'btn-danger', // สีปุ่มของ Confirm
                            denyButton: 'btn-primary', // สีปุ่มของ Deny
                            cancelButton: 'btn-secondary'    // สีปุ่มของ Cancel
                        },
                    }).then((result) => {
                    if (result.isConfirmed) {
                        // ลบข้อมูล
                        setUserToggle(user_id, false, "delete");
                        Swal.fire({
                            title: "<h3 style='font-weight: bold;'>สถานะถูกปิดและลบข้อมูลแล้ว</h3>",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else if (result.isDenied) {
                        // ไม่ลบข้อมูล
                        setUserToggle(user_id, false ,"not_delete"); // ส่ง parameter ว่าง
                        Swal.fire({
                            title:"<h3 style='font-weight: bold;'>สถานะถูกปิดแล้ว (ข้อมูลไม่ถูกลบ)?</h3>",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        // กดยกเลิก
                        toggleElement.checked = true; // ย้อนกลับค่า
                    }
                });
            }
        }

        async function setUserToggle(user_id, isActive, toggle_status) {
            const currentStatus = isActive ? 'active' : null;
            console.log(currentStatus);

            const data_for_update = {
                user_id: user_id,
                status: currentStatus,
                toggle_status,
            };

            try {
                const response = await fetch('{{ url('/') }}/api/update_manage_user', {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(data_for_update)
                });
                const result = await response.json();
                console.log(result);

                if (result.success) {
                    console.log('ข้อมูลอัพเดตสำเร็จ');

                    const item = result.data; // ดึงข้อมูลจาก result.data

                    let html_view = `
                        <label class="toggle-switch">
                            <input
                                id="toggle_checkbox_user_${item.user_id}"
                                type="checkbox"
                                onchange="confirmUserToggle(${item.user_id})"
                                ${item.status_user === 'active' ? 'checked' : ''}
                            >
                            <div class="toggle-switch-background">
                                <div class="toggle-switch-handle"></div>
                            </div>
                        </label>
                    `;

                    // ค้นหา <tr> ที่มี id ตรงกับ "tr_" + item.user_id
                    let row = document.querySelector(`#tr_${item.user_id}`);

                    if (row) {
                        // ถ้าเจอ <tr> ให้แทนที่เนื้อหาด้านใน
                        row.innerHTML = `
                            <td>${item.name_user ? item.name_user : ''}</td>
                            <td>${item.phone_1_user ? item.phone_1_user : ''}</td>
                            <td>${item.phone_2_user ? item.phone_2_user : ''}</td>
                            <td>${item.name_district ? item.name_district : ''}</td>
                            <td>${item.name_electorate ? item.name_electorate : ''}</td>
                            <td>${item.name_polling_unit ? item.name_polling_unit.split(" ")[0] : ''}</td>
                            <td>${item.name_polling_unit ? item.name_polling_unit.split(" ")[2] : ''}</td>
                            <td class="text-center">${html_view}</td>
                        `;
                    } else {
                        console.error(`ไม่พบแถวที่มี ID #tr_${item.user_id}`);
                    }
                }

                else {
                    console.log('เกิดข้อผิดพลาดในการอัพเดตข้อมูล');
                }
            } catch (error) {
                console.error('Error updating settings:', error);
            }
        }

        function multiConfirmUserToggle(user_ids, status) {
            let count_user_id = user_ids.length;  // ใช้ length เพื่อหาจำนวนของ array
            let html_count = '<a class="text-danger">'+count_user_id+'</a>';
            if (status === "open_status") {
                // ถ้า checkbox ติ๊ก (เปิดสถานะ)
                Swal.fire({
                    title: "<h2 style='font-size: 2.5rem; font-weight: bold;' class='text-success'>เปิดสถานะ?</h2>",
                    html: "<p style='font-size: 1.5rem; font-weight:bold;'>ต้องการเปิดสถานะผู้ใช้ทั้งหมด " + html_count + " รายการหรือไม่?</p>",
                    // icon: "info",
                    showCancelButton: true,
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก"
                }).then((result) => {
                    if (result.isConfirmed) {
                        multiSetUsersToggle(user_ids, true, "open"); // ส่งสถานะเปิด
                        Swal.fire({
                            title: "สถานะทั้งหมดถูกเปิดแล้ว!",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            } else {
                // ถ้า checkbox ไม่ติ๊ก (ปิดสถานะ)
                Swal.fire({
                    title: "<h2 style='font-size: 2.5rem; font-weight: bold;' class='text-danger'>ปิดสถานะ?</h2>",
                    html: "<p style='font-size: 1.5rem; font-weight:bold;'>ต้องการปิดสถานะและล้างข้อมูลผู้ใช้ทั้งหมด " + html_count + " รายการหรือไม่?</p>",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "ปิดสถานะและล้างข้อมูล",
                    denyButtonText: "ปิดสถานะอย่างเดียว",
                    cancelButtonText: "ยกเลิก",
                    customClass: {
                        confirmButton: 'btn-danger', // สีปุ่มของ Confirm
                        denyButton: 'btn-primary', // สีปุ่มของ Deny
                        cancelButton: 'btn-secondary'    // สีปุ่มของ Cancel
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ลบข้อมูล
                        multiSetUsersToggle(user_ids, false, "delete");
                        Swal.fire({
                            title: "<h3 style='font-weight: bold;'>สถานะถูกปิดและลบข้อมูลแล้ว</h3>",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else if (result.isDenied) {
                        // ไม่ลบข้อมูล
                        multiSetUsersToggle(user_ids, false, "not_delete"); // ส่ง parameter ว่าง
                        Swal.fire({
                            title: "<h3 style='font-weight: bold;'>สถานะถูกปิดแล้ว (ข้อมูลไม่ถูกลบ)</h3>",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {

                    }
                });
            }
        }

        async function multiSetUsersToggle(user_ids, isActive, toggle_status) {
            const currentStatus = isActive ? 'active' : null;
            console.log(currentStatus);

            const data_for_update = {
                user_ids: user_ids, // ส่งเป็น array
                status: currentStatus,
                toggle_status,
            };

            try {
                const response = await fetch('{{ url('/') }}/api/multi_update_manage_users', {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(data_for_update),
                });

                const result = await response.json();
                console.log(result);

                if (result.success) {
                    console.log('ข้อมูลอัพเดตสำเร็จ');

                    const updatedUsers = result.data; // รับข้อมูลผู้ใช้ที่อัพเดตแล้วจาก backend

                    updatedUsers.forEach((item) => {
                        let html_view = `
                            <label class="toggle-switch">
                                <input
                                    id="toggle_checkbox_user_${item.user_id}"
                                    type="checkbox"
                                    onchange="confirmUserToggle(${item.user_id})"
                                    ${item.status_user === 'active' ? 'checked' : ''}
                                >
                                <div class="toggle-switch-background">
                                    <div class="toggle-switch-handle"></div>
                                </div>
                            </label>
                        `;

                        // ค้นหา <tr> ที่มี id ตรงกับ "tr_" + item.user_id
                        let row = document.querySelector(`#tr_${item.user_id}`);

                        if (row) {
                            // อัปเดตแค่คอลัมน์ที่เกี่ยวข้อง (สถานะและข้อมูลอื่นๆ)
                            const tdStatus = row.querySelector('td.text-center');
                            if (tdStatus) {
                                tdStatus.innerHTML = html_view; // อัปเดตสถานะ
                            }

                            // อัปเดตข้อมูลที่เหลือในแถว
                            row.querySelector('td:nth-child(1)').textContent = item.name_user || '';
                            row.querySelector('td:nth-child(2)').textContent = item.phone_1_user || '';
                            row.querySelector('td:nth-child(3)').textContent = item.phone_2_user || '';
                            row.querySelector('td:nth-child(4)').textContent = item.name_district || '';
                            row.querySelector('td:nth-child(5)').textContent = item.name_electorate || '';
                            row.querySelector('td:nth-child(6)').textContent = (item.name_polling_unit ? item.name_polling_unit.split(" ")[0] : '');
                            row.querySelector('td:nth-child(7)').textContent = (item.name_polling_unit ? item.name_polling_unit.split(" ")[2] : '');
                        } else {
                            console.error(`ไม่พบแถวที่มี ID #tr_${item.user_id}`);
                        }
                    });
                } else {
                    console.log('เกิดข้อผิดพลาดในการอัพเดตข้อมูล');
                }
            } catch (error) {
                console.error('Error updating settings:', error);
            }
        }

        function get_District () {
            let provinceId = '{{ $data_province->id }}';
            let districtId = document.getElementById('search_district').value;  // district_id ที่ได้จากการเลือกใน dropdown

            let search_electorate = '{{ $data_search['search_electorate'] }}';

            // ส่ง request ไปยัง API
            fetch('{{ url('/') }}/api/get_district', {
                method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                body: JSON.stringify({
                    province_id: provinceId,
                    district_id: districtId
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // ถ้ามีข้อมูลมา ให้สร้าง dropdown ใหม่
                let electorateSelect = document.getElementById('search_electorate');
                electorateSelect.innerHTML = '';  // ล้างค่าปัจจุบันก่อน

                // เพิ่มตัวเลือกแรก
                let firstOption = document.createElement('option');
                firstOption.value = '';
                firstOption.textContent = 'ค้นหาจากเขตเลือกตั้ง';
                electorateSelect.appendChild(firstOption);

                // เพิ่มตัวเลือกจากข้อมูลที่ได้
                data.electorates.forEach(function(electorate) {
                    let option = document.createElement('option');
                    option.value = electorate.id;
                    option.textContent = electorate.name_electorate;

                    // ถ้าค่าของ selectedElectorate ตรงกับ electorate.id, ให้เลือก option นี้
                    if (search_electorate && search_electorate == electorate.id) {
                        option.selected = true;
                    }

                    electorateSelect.appendChild(option);
                });

            })
            .catch(error => {
                console.error('Error:', error);
            });
        };

        function get_PollingUnit() {
            let provinceId = '{{ $data_province->id }}';
            let districtId = document.getElementById('search_district').value;  // district_id ที่ได้จากการเลือกใน dropdown
            let electorateId = document.getElementById('search_electorate').value;  // electorate_id ที่ได้จากการเลือกใน dropdown

            let search_polling_unit = '{{ $data_search['search_polling_unit'] }}';

            // ส่ง request ไปยัง API
            fetch('{{ url('/') }}/api/get_polling_unit', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    province_id: provinceId,
                    district_id: districtId,
                    electorate_id: electorateId
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // ถ้ามีข้อมูลมา ให้สร้าง dropdown ใหม่สำหรับ polling_unit
                let pollingUnitSelect = document.getElementById('search_polling_unit');
                pollingUnitSelect.innerHTML = '';  // ล้างค่าปัจจุบันก่อน

                // เพิ่มตัวเลือกแรก
                let firstOption = document.createElement('option');
                firstOption.value = '';
                firstOption.textContent = 'ค้นหาจากหน่วยเลือกตั้ง';
                pollingUnitSelect.appendChild(firstOption);

                // สร้าง object เพื่อเก็บชื่อที่ซ้ำกัน
                let pollingUnitsMap = {};

                // แยกข้อมูลจาก polling_units และรวมค่าที่ซ้ำกัน
                data.polling_units.forEach(function(pollingUnit) {
                    let nameParts = pollingUnit.name_polling_unit.split(' '); // แยกจากช่องว่าง
                    let baseName = nameParts[0]; // ใช้แค่ส่วนแรก (index 0)

                    // ถ้ายังไม่มีชื่อใน pollingUnitsMap ให้สร้างใหม่
                    if (!pollingUnitsMap[baseName]) {
                        pollingUnitsMap[baseName] = [];
                    }

                    // เก็บ id ของ polling unit ในแต่ละชื่อ
                    pollingUnitsMap[baseName].push(pollingUnit.id);
                });

                console.log("pollingUnitsMap :"+pollingUnitsMap);

                // เพิ่มตัวเลือกจากข้อมูลที่ได้
                for (let baseName in pollingUnitsMap) {
                    // สร้าง option สำหรับแต่ละ polling unit ที่ไม่ซ้ำกัน
                    let option = document.createElement('option');
                    option.value = baseName;
                    option.textContent = baseName;  // แสดงแค่ชื่อหลัก

                    if (search_polling_unit && search_polling_unit == baseName) {
                        option.selected = true;
                    }

                    pollingUnitSelect.appendChild(option);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        };



    </script>
@endsection
