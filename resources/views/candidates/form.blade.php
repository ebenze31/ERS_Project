<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'ชื่อ-สกุล' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($candidate->name) ? $candidate->name : ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('img') ? 'has-error' : ''}}">
    <label for="img" class="control-label">{{ 'รูปผู้สมัคร' }}</label>
    <input class="form-control" name="img" type="file" id="img" value="{{ isset($candidate->img) ? $candidate->img : ''}}" >
    {!! $errors->first('img', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('number') ? 'has-error' : ''}}">
    <label for="number" class="control-label">{{ 'เบอร์ผู้สมัคร' }}</label>
    <input class="form-control" name="number" type="number" id="number" min="1" value="{{ isset($candidate->number) ? $candidate->number : ''}}" >
    {!! $errors->first('number', '<p class="help-block">:message</p>') !!}
</div>
<div  class="form-group {{ $errors->has('political_partie_id') ? 'has-error' : ''}}">
    <label for="political_partie_id" class="control-label">{{ 'พรรคการเมือง' }}</label>
    <select class="form-control" name="political_partie_id" id="political_partie_id">

    </select>
    {!! $errors->first('political_partie_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('province_id') ? 'has-error' : ''}}">
    <label for="province_id" class="control-label">{{ 'Province Id' }}</label>
    <select class="form-control" name="province_id" id="province_id">
        <option value="">เลือกจังหวัด</option>
    </select>
    {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('district_id') ? 'has-error' : '' }}">
    <label for="district_id" class="control-label">{{ 'District Id' }}</label>
    <select class="form-control" name="district_id" id="district_id">
        <option value="">เลือกอำเภอ</option>
    </select>
    {!! $errors->first('district_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('sub_district_id') ? 'has-error' : '' }}">
    <label for="sub_district_id" class="control-label">{{ 'Sub District Id' }}</label>
    <select class="form-control" name="sub_district_id" id="sub_district_id">
        <option value="">เลือกตำบล</option>
    </select>
    {!! $errors->first('sub_district_id', '<p class="help-block">:message</p>') !!}
</div>

<div  class="form-group {{ $errors->has('electorate_id') ? 'has-error' : ''}}">
    <label for="electorate_id" class="control-label">{{ 'Electorate Id' }}</label>
    <input disabled class="form-control" name="electorate_id" type="text" id="electorate_id" value="{{ isset($candidate->electorate_id) ? $candidate->electorate_id : ''}}" >
    {!! $errors->first('electorate_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('year_id') ? 'has-error' : ''}}">
    <label for="year_id" class="control-label">{{ 'Year Id' }}</label>
    <select class="form-control" name="year_id" id="year_id">

    </select>
    {!! $errors->first('year_id', '<p class="help-block">:message</p>') !!}
</div>

<!-- ประเภทผู้สมัคร -->
<div class="form-group">
    <label for="type" class="control-label">{{ 'ประเภทผู้สมัคร' }}</label>
    <div class="row">
        <div class="col-10">
            <div id="select-wrapper">
                <!-- Select Dropdown -->
                <select class="form-control" id="type-select">
                    <option value="">เลือกประเภทผู้สมัคร</option>
                    @foreach($type_candidates as $item_2)
                        <option value="{{ $item_2->name }}">{{ $item_2->name }}</option>
                    @endforeach
                </select>
            </div>
            <div id="input-wrapper" class="d-none">
                <!-- Input Field -->
                <input type="text" class="form-control" id="type-input" placeholder="กรอกประเภทผู้สมัคร">
            </div>
        </div>
        <div class="col-2">
            <!-- Toggle Button -->
            <button type="button" class="btn btn-secondary btn-block w-100" id="toggle-input">
                เพิ่มข้อมูลใหม่
            </button>
        </div>
    </div>

    <!-- Hidden Input -->
    <input type="hidden" name="type" id="type-hidden">
</div>


<div class="form-group mt-4 " >
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
       getData();
    });

    function getData () {
        fetch("{{ url('/') }}/api/getData_Candidate")
        .then(response => {
            if (!response.ok) {
                throw new Error("Network ตอบสนองไม่ OK " + response.statusText);
            }
            return response.json();
        })
        .then(result => {
            console.log(result);
            updatelist(result)
            selectElectionArea(result)
        }).catch(error => {
            console.error('Error:', error);
        });
    }

    function selectElectionArea(result) {
        console.log(result.provinces);
        console.log(result.districts);
        console.log(result.sub_districts);

        // ดึงข้อมูลจาก API
        const provinces = result.provinces;
        const districts = result.districts;
        const subDistricts = result.sub_districts;

        // อ้างอิง select element
        const provinceSelect = document.getElementById('province_id');
        const districtSelect = document.getElementById('district_id');
        const subDistrictSelect = document.getElementById('sub_district_id');

        // ฟังก์ชันสร้าง options
        function createOptions(data, selectElement, valueField, textField, placeholder) {
            selectElement.innerHTML = `<option value="">${placeholder}</option>`;
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item[valueField];
                option.textContent = item[textField];
                selectElement.appendChild(option);
            });
        }

        // กรอกข้อมูลจังหวัดใน dropdown
        createOptions(provinces, provinceSelect, 'id', 'name_province', 'เลือกจังหวัด');

        // Event listener สำหรับจังหวัด
        provinceSelect.addEventListener('change', () => {
            const selectedProvinceId = provinceSelect.value;


            // กรองอำเภอที่ตรงกับจังหวัดที่เลือก
            const filteredDistricts = districts.filter(district => district.province_id === selectedProvinceId);

            // อัปเดตอำเภอใน dropdown
            createOptions(filteredDistricts, districtSelect, 'id', 'name_district', 'เลือกอำเภอ');

            // ล้างข้อมูลตำบล
            subDistrictSelect.innerHTML = '<option value="">เลือกตำบล</option>';
            // subDistrictSelect.disabled = true;

            // เปิดใช้งาน dropdown อำเภอ
            // districtSelect.disabled = filteredDistricts.length === 0;
        });

        // Event listener สำหรับอำเภอ
        districtSelect.addEventListener('change', () => {
            const selectedDistrictId = districtSelect.value;
            // console.log("districtSelect : "+districtSelect.value);
            // กรองตำบลที่ตรงกับอำเภอที่เลือก
            const filteredSubDistricts = subDistricts.filter(subDistrict => subDistrict.district_id === selectedDistrictId);
            console.log(filteredSubDistricts);
            // อัปเดตตำบลใน dropdown
            createOptions(filteredSubDistricts, subDistrictSelect, 'id', 'name_sub_districts', 'เลือกตำบล');
            console.log("createOptions");
            console.log(filteredSubDistricts);
            console.log(subDistrictSelect);

            // เปิดใช้งาน dropdown ตำบล
            // subDistrictSelect.disabled = filteredSubDistricts.length === 0;
        });

        // เริ่มต้นสถานะ
        // districtSelect.disabled = true;
        // subDistrictSelect.disabled = true;
    }

    function updatelist(result) {
        //================== datalist ประเภทผู้สมัคร ========================


        //================== select พรรคการเมือง ========================

        const selectedPartyId = '{{ isset($candidate->political_partie_id) ? $candidate->political_partie_id : ''}}';

        const politicalPartieSelect = document.querySelector("#political_partie_id");
        politicalPartieSelect.innerHTML = "";

        const defaultOption_politicalParties = document.createElement("option");
        defaultOption_politicalParties.value = "";
        defaultOption_politicalParties.textContent = "เลือกพรรคการเมือง";
        politicalPartieSelect.appendChild(defaultOption_politicalParties);

        for (let party of result['politicalParties']) {
            const option = document.createElement("option");
            option.value = party.id;
            option.textContent = party.name;

            if (selectedPartyId && selectedPartyId == party.id) {
                option.selected = true;
            }

            politicalPartieSelect.appendChild(option);
        }

        //================== select ปีและรอบการเลือกตั้ง  ========================

        const selectedYearId = '{{ isset($candidate->year_id) ? $candidate->year_id : ''}}';
        console.log("selectedYearId :"+selectedYearId);

        const yearSelect = document.querySelector("#year_id");
        yearSelect.innerHTML = ""; // ล้างตัวเลือกเดิม

        const defaultOption_Year = document.createElement("option");
        defaultOption_Year.value = "";
        defaultOption_Year.textContent = "เลือกปี";
        yearSelect.appendChild(defaultOption_Year);

        for (let year of result['years']) {
            const option = document.createElement("option");
            option.value = year.id;
            option.textContent = `ปี ${parseInt(year.year) + 543} : รอบ ${year.round}`;

            // เช็คว่าปีนี้เป็นค่า selected หรือไม่
            if (selectedYearId && selectedYearId == year.id) {
                option.selected = true;
            }

            yearSelect.appendChild(option);
        }

    }

    // ============================================================================================
    const selectWrapper = document.getElementById('select-wrapper');
    const inputWrapper = document.getElementById('input-wrapper');
    const selectElement = document.getElementById('type-select');
    const inputElement = document.getElementById('type-input');
    const hiddenInput = document.getElementById('type-hidden');
    const toggleButton = document.getElementById('toggle-input');

    // กำหนดค่าจาก Select ไปยัง Hidden Input
    selectElement.addEventListener('change', function () {
        hiddenInput.value = this.value; // เมื่อเลือกจาก Select จะเก็บค่าใน Hidden Input
    });

    // กำหนดค่าจาก Input ไปยัง Hidden Input
    inputElement.addEventListener('input', function () {
        hiddenInput.value = this.value; // เมื่อพิมพ์ใน Input จะเก็บค่าใน Hidden Input
    });

    // ฟังก์ชันสลับระหว่าง Select และ Input
    toggleButton.addEventListener('click', function () {
        if (selectWrapper.classList.contains('d-none')) {
            // แสดง Select และซ่อน Input
            selectWrapper.classList.remove('d-none');
            inputWrapper.classList.add('d-none');
            toggleButton.textContent = 'เพิ่มข้อมูลใหม่';

            // อัปเดต Hidden Input จาก Select
            hiddenInput.value = selectElement.value;
        } else {
            // แสดง Input และซ่อน Select
            selectWrapper.classList.add('d-none');
            inputWrapper.classList.remove('d-none');
            toggleButton.textContent = 'ตัวเลือก';

            // อัปเดต Hidden Input จาก Input
            hiddenInput.value = inputElement.value;
        }
    });

    // ตั้งค่าเริ่มต้นให้ Hidden Input
    hiddenInput.value = selectElement.value; // ค่าเริ่มต้นมาจาก Select

    // ============================================================================================

    document.querySelector('form').addEventListener('submit', function (event) {
        let isValid = true;

        // ลบข้อความ error เก่าก่อน
        document.querySelectorAll('.help-block.text-danger').forEach(el => el.remove());

        // ตรวจสอบฟิลด์ต่างๆ
        const fields = [
            { id: 'name', message: 'กรุณากรอกชื่อ-สกุล' },
            { id: 'img', message: 'กรุณาอัปโหลดรูปผู้สมัคร', type: 'file' },
            { id: 'number', message: 'กรุณากรอกเบอร์ผู้สมัครให้ถูกต้อง', type: 'number', min: 1 },
            { id: 'political_partie_id', message: 'กรุณาเลือกพรรคการเมือง' },
            { id: 'province_id', message: 'กรุณาเลือกจังหวัด' },
            { id: 'district_id', message: 'กรุณาเลือกอำเภอ' },
            { id: 'sub_district_id', message: 'กรุณาเลือกตำบล' },
            { id: 'year_id', message: 'กรุณาเลือกปีการเลือกตั้ง' },
        ];

        fields.forEach(field => {
            const input = document.getElementById(field.id);

            if (field.type === 'file') {
                // ตรวจสอบไฟล์
                if (!input.files.length) {
                    showError(input, field.message);
                    isValid = false;
                }
            } else if (field.type === 'number') {
                // ตรวจสอบตัวเลข
                if (!input.value.trim() || input.value < field.min) {
                    showError(input, field.message);
                    isValid = false;
                }
            } else {
                // ตรวจสอบข้อความหรือ select
                if (!input.value.trim()) {
                    showError(input, field.message);
                    isValid = false;
                }
            }
        });

        // ตรวจสอบประเภทผู้สมัคร (hidden input)
        const typeHiddenInput = document.getElementById('type-hidden');
        if (!typeHiddenInput.value.trim()) {
            const typeWrapper = document.getElementById('select-wrapper');
            showError(typeWrapper, 'กรุณาเลือกหรือกรอกประเภทผู้สมัคร');
            isValid = false;
        }

        // ถ้าข้อมูลไม่ถูกต้อง ให้หยุดการส่งฟอร์ม
        if (!isValid) {
            event.preventDefault();
        }
    });

    // ฟังก์ชันแสดงข้อความ error
    function showError(input, message) {
        const errorElement = document.createElement('p');
        errorElement.className = 'help-block text-danger';
        errorElement.textContent = message;

        const formGroup = input.closest('.form-group');
        if (formGroup) {
            formGroup.appendChild(errorElement);
        }
    }


</script>


