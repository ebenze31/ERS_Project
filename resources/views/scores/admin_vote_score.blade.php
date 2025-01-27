@extends('layouts.theme_admin')

@section('content')

   <!-- ข้อมูลหน่วย -->
   <div class="row justify-content-center p-4">
    <div class="card-body">
        <div class="card">
            <!-- From Uiverse.io by guilhermeyohan --> 
            <div class="card-body">

                <button id="btn_view_max_all" class="btn btn-sm btn-primary" style="width:150px;" onclick="click_view_max_round('all');">
                    ทั้งหมด
                </button>
                <button id="btn_view_max_Yes" class="btn btn-sm btn-outline-success" style="width:150px;" onclick="click_view_max_round('Yes');">
                    ลงคะแนนแล้ว
                </button>
                <button id="btn_view_max_No" class="btn btn-sm btn-outline-secondary" style="width:150px;" onclick="click_view_max_round('No');">
                    ไม่มีการเพิ่มคะแนน
                </button>

                <span id="count_display" style="margin-left: 15px;">
                    0 รายการ
                </span>

                <button class="btn btn-sm btn-warning float-end mx-2" onclick="confirm_clear_name_user('all');">
                    ล้างคะแนนทั้งหมด
                </button>

                <div class="table-responsive mt-3">
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
                                <th>จำนวนครั้ง</th>
                                <th>จำนวนผู้มีสิทธิ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="polling_units_body">
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
        getdata_admin_vote_score();

        setInterval(() => {
            getdata_admin_vote_score();
        }, 300000);
        // }, 5000);
    });
    // คะแนนเฉลี่ยต่อเคสเจ้าหน้าที่
    function getdata_admin_vote_score() {

        // console.log('getdata_admin_vote_score');

        fetch("{{ url('/') }}/api/admin_vote_score?userProvince=" + userProvince)
        .then(response => {
                if (!response.ok) {
                   console.log("response ไม่ตอบสนอง");
                }
                return response.json();
            })
            .then(result => {
                // console.log(result);

                document.getElementById('count_display').textContent = `${result['count']} รายการ`;

                // Clear existing rows
                const tbody = document.getElementById("polling_units_body");
                tbody.innerHTML = "";

                // Generate rows dynamically
                result['polling_units'].forEach(item => {
                    let html_view;
                    if (item['user_id']) {
                        html_view = `
                            <center>
                                <a href="{{ url('/') }}/admin_vote_score_view/${item['id']}" title="View Score">
                                    <button class="btn btn-info btn-sm">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </button>
                                </a>
                            </center>`;
                    } else {
                        html_view = `
                            <center>
                                <a class="disabled" href="" title="View Score">
                                    <button class="btn btn-secondary btn-sm">
                                        <i class="fa-solid fa-eye-slash" aria-hidden="true"></i> View
                                    </button>
                                </a>
                            </center>`;
                    }

                    let row = document.createElement("tr");
                        row.setAttribute("id", "tr_"+item['id']);

                    if(item.max_round){
                        row.setAttribute("max_round", "Yes");
                    }
                    else{
                        row.setAttribute("max_round", "No");
                    }

                    row.innerHTML = `
                        <td>${item.name_district}</td>
                        <td>${item.name_electorate}</td>
                        <td>${item.name_polling_unit.split(" ")[0]}</td>
                        <td>${item.name_polling_unit.split(" ")[2]}</td>
                        <td>${item.name_user}</td>
                        <td>${item.phone_1_user ?? ''}</td>
                        <td>${item.phone_2_user ?? ''}</td>
                        <td>${item.max_round ?? 'ไม่มีการเพิ่ม'}</td>
                        <td>${item.eligible_voters}</td>
                        <td>${html_view}</td>
                    `;

                    tbody.appendChild(row);

                    // fetch("{{ url('/') }}/api/check_count_score_unit/" + item['id'] + "/" + "{{ Auth::user()->province }}")
                    //     .then(response => response.text())
                    //     .then(data => {
                    //         console.log(data);
                    //         if (data) {
                                
                    //         } 
                    //     });

                    
                });

            })
            .catch(error => {
                console.error("Error:", error);
                // alert("เกิดข้อผิดพลาดในการสร้างข้อมูล");
            });
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
                        title: "ต้องการลบคะแนน ทั้งหมด?<br><span style='font-size: 18px;color:red;'>คะแนนของทุกหน่วยในรอบการเลือกตั้งนี้จะถูกลบ</span>",
                        showDenyButton: false,
                        showCancelButton: true,
                        confirmButtonText: "ลบ",
                        cancelButtonText: "ยกเลิก",
                        icon: "question"
                        // denyButtonText: `Don't save`
                    }).then((result) => {
                        // Handle the confirmation result
                        if (result.isConfirmed) {
                            clear_score(id)
                        }
                    });
            }

        }

    function clear_score(id){
        // console.log(id);

        if(id != "all"){
            let tr = document.querySelector('#tr_'+id);
            // console.log(tr);
        }

        fetch("{{ url('/') }}/api/clear_score/" + id + "/" + "{{ Auth::user()->id }}" + "/" + "{{ $data_Year->id }}")
            // .then(response => response.json())
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

    function click_view_max_round(type){
        // console.log(type);

        // ปุ่มทั้งหมด
        const btnAll = document.getElementById('btn_view_max_all');
        const btnYes = document.getElementById('btn_view_max_Yes');
        const btnNo = document.getElementById('btn_view_max_No');

        // รีเซ็ต class ให้ปุ่มทุกปุ่มกลับไปเป็น outline
        btnAll.classList.remove('btn-primary');
        btnAll.classList.add('btn-outline-primary');

        btnYes.classList.remove('btn-success');
        btnYes.classList.add('btn-outline-success');

        btnNo.classList.remove('btn-secondary');
        btnNo.classList.add('btn-outline-secondary');

        // ตั้งค่า class สำหรับปุ่มที่ถูกเลือก
        if (type === 'all') {
            btnAll.classList.remove('btn-outline-primary');
            btnAll.classList.add('btn-primary');
        } else if (type === 'Yes') {
            btnYes.classList.remove('btn-outline-success');
            btnYes.classList.add('btn-success');
        } else if (type === 'No') {
            btnNo.classList.remove('btn-outline-secondary');
            btnNo.classList.add('btn-secondary');
        }

        const rows = document.querySelectorAll('#table_polling_units tbody tr');
        let count = 0; // ตัวนับสำหรับแถวที่แสดงผล

        rows.forEach(row => {
            // ดึงค่า max_round ของแต่ละ tr
            const maxRound = row.getAttribute('max_round');

            // ตรวจสอบ type และจัดการการแสดงผล
            if (type === 'all') {
                // แสดงทุกแถว
                row.style.display = '';
                count++; // เพิ่มตัวนับ
            } else if (type === 'Yes' && maxRound === 'Yes') {
                // แสดงเฉพาะแถวที่ max_round = Yes
                row.style.display = '';
                count++; // เพิ่มตัวนับ
            } else if (type === 'No' && maxRound === 'No') {
                // แสดงเฉพาะแถวที่ max_round = No
                row.style.display = '';
                count++; // เพิ่มตัวนับ
            } else {
                // ซ่อนแถวที่ไม่ตรงกับเงื่อนไข
                row.style.display = 'none';
            }
        });

        document.getElementById('count_display').textContent = `${count} รายการ`;
    }

</script>
@endsection
