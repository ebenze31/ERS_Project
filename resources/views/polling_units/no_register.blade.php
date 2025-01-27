@extends('layouts.theme_admin')

@section('content')


<!-- DataTables CSS CDN -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS CDN -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>


<style>
    .dataTables_filter ,.fixedHeader-floating{
        display: none;
    }
</style>
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
                        <table id="table_polling_units"  class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>อำเภอ</th>
                                    <th>เขตเลือกตั้งที่</th>
                                    <th>ตำบล</th>
                                    <th>หน่วยเลือกตั้งที่</th>
                                </tr>
                                <tr>
                                    <th><input type="text" style="width:100%;" placeholder="ค้นหา อำเภอ" /></th>
                                    <th><input type="text" style="width:100%;" placeholder="ค้นหา เขตเลือกตั้งที่" /></th>
                                    <th><input type="text" style="width:100%;" placeholder="ค้นหา ตำบล" /></th>
                                    <th><input type="text" style="width:100%;" placeholder="ค้นหา หน่วยเลือกตั้งที่" /></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($polling_units as $item)
                                <tr>
                                    <td>{{ $item->name_district }}</td>
                                    <td>{{ $item->name_electorate }}</td> <!-- เขตเลือกตั้งที่ -->
                                    <td>{{ $item->name_sub_district }}</td> <!-- ตำบล -->
                                    <td>{{ $item->polling_unit_numbers }}</td> <!-- หน่วยเลือกตั้งที่ รวมเป็นกลุ่ม -->
                                </tr>
                                @endforeach
                                <!-- Add more rows as needed -->
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

    
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var otable = $('#table_polling_units').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            paging: false,
        });

        // Apply the search to each column based on input in the header
        $('#table_polling_units thead tr:eq(1) th').each(function(i) {
            $('input', this).on('keyup change', function() {
                if (otable.column(i).search() !== this.value) {
                    otable
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });
    });
</script>
</div>

@endsection