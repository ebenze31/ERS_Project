<div class="form-group mt-2 {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'ชื่อพรรค' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($political_party->name) ? $political_party->name : ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group mt-2 {{ $errors->has('logo') ? 'has-error' : ''}}">
    <label for="logo" class="control-label">{{ 'โลโก้พรรค' }}</label>
    <input class="form-control" name="logo" type="file" id="logo" value="{{ isset($political_party->logo) ? $political_party->logo : ''}}" >
    {!! $errors->first('logo', '<p class="help-block">:message</p>') !!}
</div>
<div class="row mt-2 {{ $errors->has('color') ? 'has-error' : ''}}">
    <div class="col-12 col-md-8 mb-2">
        <div class="form-group">
            <label for="color" class="control-label">{{ 'สีของธีม' }}</label>
            <input readonly class="form-control" name="color" type="text" id="color" value="{{ isset($political_party->color) ? $political_party->color : ''}}" >
            {!! $errors->first('color', '<p class="help-block">:message</p>') !!}
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
</script>
