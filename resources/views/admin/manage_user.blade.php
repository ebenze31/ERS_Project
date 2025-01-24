@extends('layouts.theme_admin')

@section('content')
    <style>
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
                จัดการผู้ใช้
                <span id="span_count_polling_units" class="d-none" style="font-size: 14px;"></span>
                <button class="btn btn-warning float-end mx-2" onclick="confirm_clear_name_user('all');">
                    ปุ่ม
                </button>
            </h4>
        </div>
        <div class="card-body">
            <div class="card">
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
        });
        // คะแนนเฉลี่ยต่อเคสเจ้าหน้าที่
        function getdata_user() {

            fetch("{{ url('/') }}/api/manage_user_data?userProvince=" + userProvince)
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

                    const count_polling_units = document.querySelector('#span_count_polling_units');
                    count_polling_units.innerHTML = `(ทั้งหมด ${result['count']} หน่วย)`;

                    // Generate rows dynamically
                    result['users'].forEach(item => {
                        let html_view = `
                                <label class="toggle-switch">
                                    <input id="toggle_checkbox_user" type="checkbox" onchange="setUserToggle(${item['user_id']})" ${item['status_user'] === 'active' ? 'checked' : ''}>
                                    <div class="toggle-switch-background">
                                        <div class="toggle-switch-handle"></div>
                                    </div>
                                </label>
                           `;

                        let row = document.createElement("tr");
                        row.setAttribute("id", "tr_" + item['id']);

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

        async function setUserToggle(user_id) {
            const toggleElement = document.getElementById('toggle_checkbox_user');
            const currentStatus = toggleElement.checked ? 'active' : null;

            const data_for_update = {
                user_id: user_id,
                status: currentStatus,
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
                if (result.success && currentStatus === (toggleElement.checked ? 'active' : null)) {
                    console.log('ข้อมูลอัพเดตสำเร็จ');
                } else {
                    console.log('เกิดข้อผิดพลาดหรือข้อมูลไม่ตรง');
                }
            } catch (error) {
                console.error('Error updating settings:', error);
            }
        }

    </script>
@endsection
