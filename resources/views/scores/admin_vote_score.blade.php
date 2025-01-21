@extends('layouts.theme_admin')

@section('content')
   <!-- ข้อมูลหน่วย -->
   <div class="row justify-content-center p-4">
    <div class="card-header">
        <h4>
            การลงคะแนน
            <span id="span_count_polling_units" class="d-none" style="font-size: 14px;"></span>
            <button class="btn btn-warning float-end mx-2" onclick="confirm_clear_name_user('all');">
                ล้างคะแนนทั้งหมด
            </button>
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
    });
    // คะแนนเฉลี่ยต่อเคสเจ้าหน้าที่
    function getdata_admin_vote_score() {

        fetch("{{ url('/') }}/api/admin_vote_score?userProvince=" + userProvince)
        .then(response => {
                if (!response.ok) {
                   console.log("response ไม่ตอบสนอง");
                }
                return response.json();
            })
            .then(result => {
                // console.log("Response from server:", result);

                // Clear existing rows
                const tbody = document.getElementById("polling_units_body");
                tbody.innerHTML = "";

                const count_polling_units = document.querySelector('#span_count_polling_units');
                count_polling_units.innerHTML = `(ทั้งหมด ${result['count']} หน่วย)`;

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

                    row.innerHTML = `
                        <td>${item.name_district}</td>
                        <td>${item.name_electorate}</td>
                        <td>${item.name_polling_unit.split(" ")[0]}</td>
                        <td>${item.name_polling_unit.split(" ")[2]}</td>
                        <td>${item.eligible_voters}</td>
                        <td>${html_view}</td>
                    `;

                    tbody.appendChild(row);
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
                        title: "ต้องการลบคะแนน ทั้งหมด?",
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

</script>
@endsection
