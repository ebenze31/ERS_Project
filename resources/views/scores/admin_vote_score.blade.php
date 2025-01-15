@extends('layouts.theme_admin')

@section('content')
   <!-- ข้อมูลหน่วย -->
   <div class="row justify-content-center p-4">
    <div class="card-header">
        <h4>
            หน่วยเลือกตั้ง <span id="span_count_polling_units" style="font-size: 14px;"></span>
            <button id="btn_create_user_units" class="btn btn-info float-end" onclick="create_user_units();">
                สร้างรหัสผู้ใช้
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
                                <th>เจ้าหน้าที่</th>
                                <th>จำนวนผู้มีสิทธิ</th>
                                <th>จำนวนผู้มาใช้สิทธิ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="polling_units_body">
                            {{-- @foreach($polling_units as $item)
                            <tr>
                                <td>{{ $item->name_district }}</td>
                                <td>{{ $item->name_electorate }}</td>
                                <td>{{ explode(" ",$item->name_polling_unit)[0] }}</td>
                                <td>{{ explode(" ",$item->name_polling_unit)[2] }}</td>
                                <td>{{ $item->name_user }}</td>
                                <td>{{ $item->eligible_voters }}</td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

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
                console.log("Response from server:", result);

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
                            <a href="{{ url('/') }}/admin_vote_score_view/${item['user_id']}" title="View Score">
                                <button class="btn btn-info btn-sm">
                                    <i class="fa fa-eye" aria-hidden="true"></i> View
                                </button>
                            </a>`;
                    } else {
                        html_view = `
                            <a href="" title="View Score">
                                <button class="btn btn-secondary btn-sm">
                                    <i class="fa fa-eye" aria-hidden="true"></i> View
                                </button>
                            </a>`;
                    }
                    const row = document.createElement("tr");

                    row.innerHTML = `
                        <td>${item.name_district}</td>
                        <td>${item.name_electorate}</td>
                        <td>${item.name_polling_unit.split(" ")[0]}</td>
                        <td>${item.name_polling_unit.split(" ")[2]}</td>
                        <td>${item.name_user ? item.name_user : ''}</td>
                        <td>${item.eligible_voters}</td>
                        <td></td>
                        ${html_view}
                    `;

                    tbody.appendChild(row);
                });

            })
            .catch(error => {
                console.error("Error:", error);
                // alert("เกิดข้อผิดพลาดในการสร้างข้อมูล");
            });
    }

</script>
@endsection
