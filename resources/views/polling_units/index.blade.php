@extends('layouts.theme_admin')

@section('content')
<div class="card">

    <!-- เพิ่มข้อมูลหน่วย -->
    @if( $count_units == 0 )
    <div class="row justify-content-center p-4">
        <div class="col-7">
            <form id="uploadForm" class="row">
                <div class="col-12">
                    <label>เพิ่มไฟล์ Excel เพื่อสร้างหน่วยเลือกตั้ง</label>
                </div>
                <div class="col-9">
                    <input class="form-control" type="file" id="excelFile" accept=".xlsx, .xls" />
                </div>
                <div class="col-3">
                    <button class="btn btn-success" type="submit">สร้างหน่วยเลือกตั้ง</button>
                </div>
            </form>
        </div>
        <div class="col-5">
            <a href="{{ url('/Excel/Template_polling_units.xlsx') }}" download>
                <button class="btn btn-info float-end mt-3" type="submit">
                    Download Template Excel
                </button>
            </a>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("uploadForm").addEventListener("submit", async (e) => {
                e.preventDefault();

                const fileInput = document.getElementById("excelFile");
                const file = fileInput.files[0];

                if (!file) {
                    alert("Please select an Excel file.");
                    return;
                }

                const apiUrl = `{{ url('/') }}/api/excel_add_polling_units`;

                const formData = new FormData();
                formData.append("file", file);

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
                    if (result == "SUCCESS") {
                        window.location.reload();
                    }
                } catch (error) {
                    console.error("Error:", error);
                }
            });
        });
    </script>
    <!-- จบเพิ่มข้อมูลหน่วย -->
    @else

    <!-- ข้อมูลหน่วย -->
    <div class="row justify-content-center p-4">
        <div class="card-header">
            <h4>
                หน่วยเลือกตั้ง <span style="font-size: 14px;">(ทั้งหมด {{ $count_units }} หน่วย)</span>
                <button id="btn_create_user_units" class="btn btn-info float-end mx-2 d-none" onclick="create_user_units();">
                    สร้างรหัสผู้ใช้
                </button>
                <button class="btn btn-warning float-end mx-2" onclick="confirm_clear_name_user('all');">
                    ล้างข้อมูลทั้งหมด
                </button>
                <a  class="btn btn-primary float-end mx-2" href="{{ url('/polling_units_no_register') }}">
                    ยังไม่ลงทะเบียน
                </a>
            </h4>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_polling_units" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>อำเภอ</th>
                                    <th>เขตเลือกตั้งที่</th>
                                    <th>ตำบล</th>
                                    <th>หน่วยเลือกตั้งที่</th>
                                    <th>เจ้าหน้าที่</th>
                                    <th>เบอร์</th>
                                    <th>เบอร์ 2</th>
                                    <th>จำนวนผู้มีสิทธิ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($polling_units as $item)
                                <tr id="tr_{{ $item->unit_id }}">
                                    <td>{{ $item->name_district }}</td>
                                    <td>{{ $item->name_electorate }}</td>
                                    <td>{{ explode(" ",$item->name_polling_unit)[0] }}</td>
                                    <td>{{ explode(" ",$item->name_polling_unit)[2] }}</td>
                                    <td>{{ $item->name_user }}</td>
                                    <td>{{ $item->phone_1_user }}</td>
                                    <td>{{ $item->phone_2_user }}</td>
                                    <td>{{ $item->eligible_voters }}</td>
                                    <td>
                                        <center>
                                            <button class="btn btn-warning btn-sm" onclick="confirm_clear_name_user('{{ $item->unit_id }}');">
                                                ล้างข้อมูลหน่วยนี้
                                            </button>
                                        </center>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        let div_data_user = document.createElement('div');

        document.addEventListener("DOMContentLoaded", function() {

        });

        function create_user_units() {
            let province = "{{ Auth::user()->province }}";
            document.querySelector('#btn_create_user_units').innerHTML =
                `
                    <div class="spinner-border text-light" role="status" style="scale: 0.7;"></div>
                    กำลังดำเนินการ
                `;

            fetch("{{ url('/') }}/api/create_user_units/" + province)
                .then(response => response.json())
                .then(data => {
                    // console.log(data);
                    if (data && data['status'] != "Empty polling units") {
                        // console.log("Data received:", data.users);
                        createExcelFile(data, province); // ส่งข้อมูลไปสร้างไฟล์ Excel
                    } else {
                        alert("ไม่มีข้อมูลสำหรับสร้างผู้ใช้");
                        document.querySelector('#btn_create_user_units').innerHTML = `สร้างรหัสผู้ใช้`;
                    }
                });
        }

        function createExcelFile(usersData, province) {
            // แปลงข้อมูลที่ได้เป็นรูปแบบที่ต้องการ
            const excelData = usersData.map(user => ({
                "อำเภอ": user.district,
                "เขต": user.electorate,
                "หน่วยเลือกตั้ง": user.polling_unit,
                "username": user.username,
                "password": user.password,
            }));

            // สร้างเวิร์กบุ๊กและเวิร์กชีต
            const worksheet = XLSX.utils.json_to_sheet(excelData); // สร้าง Sheet จาก JSON
            const workbook = XLSX.utils.book_new(); // สร้าง Workbook ใหม่
            XLSX.utils.book_append_sheet(workbook, worksheet, "Users Data"); // เพิ่ม Sheet เข้า Workbook

            // สร้างไฟล์ Excel และดาวน์โหลด
            const fileName = "รหัสผู้ใช้งาน_" + province + ".xlsx";
            XLSX.writeFile(workbook, fileName);

            document.querySelector('#btn_create_user_units').innerHTML = `สร้างรหัสผู้ใช้เรียบร้อย`;
        }


        function confirm_clear_name_user(id) {
            if (id != "all") {
                let tr = document.querySelector('#tr_' + id);
                let tds = tr.querySelectorAll('td'); // Select all <td> elements inside the <tr>

                // Loop through each <td> and log the text content

                // console.log(tr);

                div_data_user.innerHTML = '';
                if (tds[4].textContent == 'กรุณาเพิ่มชื่อของคุณ') {
                    Swal.fire({
                        icon: "error",
                        title: "เจ้าหน้าที่ยังไม่ได้กรอกข้อมูล",
                        showConfirmButton: false,
                        timer: 2000,

                    });
                } else {
                    let html_user = `
                            <div>
                                <p class="text-center text-[19px] text-[#000] font-bold">อำเภอ : ` + tds[0].textContent + `</p>
                                <p class="text-center text-[19px] text-[#000] font-bold">เขต : ` + tds[1].textContent + `</p>
                                <p class="text-center text-[19px] text-[#000] font-bold">ตำบล : ` + tds[2].textContent + `</p>
                                <p class="text-center text-[19px] text-[#000] font-bold">หน่วย : ` + tds[3].textContent + `</p>
                                <p class="text-center text-[19px] text-[#000] font-bold">เจ้าหน้าที่ : <span class="text-danger">` + tds[4].textContent + `</span></p>
                            </div>
                        `;
                    div_data_user.insertAdjacentHTML('afterbegin', html_user); // แทรกบนสุด 
                    Swal.fire({
                        title: "ต้องการลบข้อมูลเจ้าหน้าที่?",
                        html: div_data_user.innerHTML, // Use the innerHTML of the div
                        showDenyButton: false,
                        showCancelButton: true,
                        confirmButtonText: "ลบ",
                        cancelButtonText: "ยกเลิก",
                        // denyButtonText: `Don't save`
                    }).then((result) => {
                        // Handle the confirmation result
                        if (result.isConfirmed) {
                            clear_name_user(id)
                        }
                    });
                }
            }else{
                Swal.fire({
                        title: "ต้องการลบข้อมูลเจ้าหน้าที่ ทั้งหมด?",
                        showDenyButton: false,
                        showCancelButton: true,
                        confirmButtonText: "ลบ",
                        cancelButtonText: "ยกเลิก",
                        icon: "question"
                        // denyButtonText: `Don't save`
                    }).then((result) => {
                        // Handle the confirmation result
                        if (result.isConfirmed) {
                            clear_name_user(id)
                        }
                    });
            }

        }

        function clear_name_user(id) {

            fetch("{{ url('/') }}/api/clear_name_user/" + id + "/" + "{{ Auth::user()->id }}")
                .then(response => response.text())
                .then(data => {
                    // console.log(data);
                    if (data == "SUCCESS") {
                        // console.log(data);
                        Swal.fire({
                            title: "ลบข้อมูลเรียบร้อย",
                            icon: "success",
                            buttons: false,
                            timer: 3000,
                            showConfirmButton: false,
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
        }
    </script>
    <!-- จบข้อมูลหน่วย -->
    @endif

</div>

@endsection