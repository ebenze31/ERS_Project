<div class="form-group mt-2 {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'ชื่อพรรค' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($political_party->name) ? $political_party->name : ''}}" >
    {{-- {!! $errors->first('name', '<p class="text-danger help-block">:message</p>') !!} --}}
</div>
<div class="form-group mt-2 {{ $errors->has('logo') ? 'has-error' : ''}}">
    <label for="logo" class="control-label">{{ 'โลโก้พรรค' }}</label>
    <input class="form-control" name="logo" type="file" id="logo" value="{{ isset($political_party->logo) ? $political_party->logo : ''}}" >
    {{-- {!! $errors->first('logo', '<p class="text-danger help-block">:message</p>') !!} --}}
</div>
<div class="row mt-2 {{ $errors->has('color') ? 'has-error' : ''}}">
    <div class="col-12 col-md-8 mb-2">
        <div class="form-group">
            <label for="color" class="control-label">{{ 'สีของธีม' }}</label>
            <input class="form-control" name="color" type="text" id="color" value="{{ isset($political_party->color) ? $political_party->color : ''}}" onchange="changeColorInput();">
            {{-- {!! $errors->first('color', '<p class="text-danger help-block">:message</p>') !!} --}}
        </div>
    </div>
    <div class="col-12 col-md-4 d-flex align-items-center">
        <div class="d-flex align-items-center justify-items-start">
            <div class="d-flex justify-content-evenly align-items-center" style="border-right: #6c757d solid 2px;">
                <div class="header-colors-indigators"></div>
                <label for="" style="font-weight: bold; font-size: 16px; padding-right: 15px;">เลือกสี</label>
            </div>
            <input class="ms-3" type="color" name="" id="input_select_color" style="width: 60px;height: 27px;border: none;border-radius: 10px;" value="{{ isset($political_party->color) ? $political_party->color : '#000000' }}"> <!-- ใช้สำหรับเลือกสีเท่านั้น -->
        </div>
    </div>
</div>

<div class="form-group mt-4" style="float:right">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>


<script>
    // เมื่อมีการเลือกสีจาก input
    document.getElementById('input_select_color').addEventListener('input', function() {
        // ดึงค่าที่เลือกจาก input สี
        var selectedColor = this.value;
        // นำค่านั้นไปใส่ใน input ที่ id="color"
        document.getElementById('color').value = selectedColor;

    });



    function changeColorInput() {
        // ดึงค่า input จากช่องกรอกสี
        const textInput = document.getElementById('color').value;
        const colorPicker = document.getElementById('input_select_color');

        // ตรวจสอบว่าค่าที่กรอกสามารถแสดงเป็นสีได้
        if (isValidColor(textInput)) {
            colorPicker.value = textInput;
        } else {
            alert('กรุณากรอกโค้ดสีที่ถูกต้อง เช่น #ff0000 หรือ red');
        }
    }

    document.querySelector('form').addEventListener('submit', function(event) {
        let isValid = true;

        // ลบข้อความ error เก่าก่อน
        document.querySelectorAll('.help-block').forEach(el => el.remove());

        // ตรวจสอบชื่อพรรค
        const nameInput = document.getElementById('name');
        if (!nameInput.value.trim()) {
            showError(nameInput, 'กรุณากรอกชื่อพรรค');
            isValid = false;
        }

        // ตรวจสอบโลโก้พรรค
        const logoInput = document.getElementById('logo');
        if (!logoInput.value.trim()) {
            showError(logoInput, 'กรุณาอัปโหลดโลโก้พรรค');
            isValid = false;
        }

        // ตรวจสอบสีของธีม
        const colorInput = document.getElementById('color');
        if (!colorInput.value.trim() || !isValidColor(colorInput.value.trim())) {
            showError(colorInput, 'กรุณากรอกโค้ดสีที่ถูกต้อง เช่น #ff0000 หรือ red');
            isValid = false;
        }

        // หยุดการส่งฟอร์มถ้ามีข้อผิดพลาด
        if (!isValid) {
            event.preventDefault();
        }
    });

    // ฟังก์ชันแสดงข้อความ error
    function showError(input, message) {
        const errorElement = document.createElement('p');
        errorElement.className = 'text-danger help-block';
        errorElement.textContent = message;
        input.closest('.form-group').appendChild(errorElement);
    }

    // ฟังก์ชันตรวจสอบว่าโค้ดสีถูกต้องหรือไม่
    function isValidColor(color) {
        const s = new Option().style;
        s.color = color;
        return s.color !== '';
    }
</script>
