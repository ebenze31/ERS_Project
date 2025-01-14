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
                    if(result == "SUCCESS"){
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
                @if( Auth::user()->role == "dev-admin" )
                <button id="btn_create_user_units" class="btn btn-info float-end" onclick="create_user_units();">
                    สร้างรหัสผู้ใช้
                </button>
                @endif
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
                                    <th>จำนวนผู้มีสิทธิ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($polling_units as $item)
                                <tr>
                                    <td>{{ $item->name_district }}</td>
                                    <td>{{ $item->name_electorate }}</td>
                                    <td>{{ explode(" ",$item->name_polling_unit)[0] }}</td>
                                    <td>{{ explode(" ",$item->name_polling_unit)[2] }}</td>
                                    <td>{{ $item->name_user }}</td>
                                    <td>{{ $item->eligible_voters }}</td>
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
        document.addEventListener("DOMContentLoaded", function() {
            
        });

        function create_user_units(){
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
                if (data) {
                    // console.log("Data received:", data.users);
                    createExcelFile(data,province); // ส่งข้อมูลไปสร้างไฟล์ Excel
                } else {
                    alert("ไม่มีข้อมูลสำหรับสร้างผู้ใช้");
                }
            });
        }

        function createExcelFile(usersData,province) {
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
            const fileName = "รหัสผู้ใช้งาน_"+province+".xlsx";
            XLSX.writeFile(workbook, fileName);

            document.querySelector('#btn_create_user_units').innerHTML = `สร้างรหัสผู้ใช้เรียบร้อย`;
        }

    </script>
    <!-- จบข้อมูลหน่วย -->
    @endif

</div>
    
@endsection
