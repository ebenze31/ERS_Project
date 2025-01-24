@extends('layouts.theme_admin')

@section('content')
<div class="card">


    <!-- ข้อมูลหน่วย -->
    <div class="row justify-content-center p-4">
        <div class="card-header">
            <h4>
                หน่วยเลือกตั้ง <span style="font-size: 14px;">(ทั้งหมด {{ $count_units }} หน่วย)</span>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_polling_units" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>อำเภอ</th>
                                    <th>ตำบล</th>
                                    <th>เขตเลือกตั้งที่</th>
                                    <!-- <th>ตำบล</th> -->
                                    <th>หน่วยเลือกตั้งที่</th>
                                    <th>จำนวนผู้มีสิทธิ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($polling_units as $item)
                                    <tr >
                                        <td>
                                        {{ $item->name_district }}
                                        </td>
                                    <td>{{ $item->name_sub_district }}</td>  <!-- ตำบล -->
                                        <td>{{ $item->name_electorate }}</td>  <!-- เขตเลือกตั้งที่ -->
                                        <td>{{ $item->polling_unit_numbers }}</td>  <!-- หน่วยเลือกตั้งที่ รวมเป็นกลุ่ม -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let div_data_user = document.createElement('div');

        document.addEventListener("DOMContentLoaded", function() {

        });

    </script>
</div>
<!-- name_polling_unit : เทศบาลเมืองกาญจนบุรี หน่วยที่ 1
province_id : 3
district_id : 69
district_id : 62

name_polling_unit : เทศบาลเมืองกาญจนบุรี หน่วยที่ 2
province_id : 3
district_id : 69
district_id : 62

name_polling_unit : เทศบาลเมืองกาญจนบุรี หน่วยที่ 3
province_id : 3
district_id : 69
district_id : 62

name_polling_unit : เทศบาลเมืองกาญจนบุรี หน่วยที่ 4
province_id : 3
district_id : 69
district_id : 62

name_polling_unit : ตำบลท่ามะขาม หน่วยที่ 1
province_id : 3
district_id : 69
district_id : 62

name_polling_unit : ตำบลท่ามะขาม หน่วยที่ 2
province_id : 3
district_id : 69
district_id : 62

name_polling_unit : ตำบลท่ามะขาม หน่วยที่ 3
province_id : 3
district_id : 69
district_id : 63


อำเภอ	เขตเลือกตั้งที่	ตำบล	หน่วยเลือกตั้งที่
เมืองกาญจนบุรี	1	เทศบาลเมืองกาญจนบุรี	1,2,3,4
เมืองกาญจนบุรี	1	ตำบลท่ามะขาม	1,2,3
@endsection -->