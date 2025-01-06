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
    <input class="form-control" name="number" type="text" id="number" value="{{ isset($candidate->number) ? $candidate->number : ''}}" >
    {!! $errors->first('number', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('province_id') ? 'has-error' : ''}}">
    <label for="province_id" class="control-label">{{ 'Province Id' }}</label>
    <input class="form-control" name="province_id" type="text" id="province_id" value="{{ isset($candidate->province_id) ? $candidate->province_id : ''}}" >
    {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('district_id') ? 'has-error' : ''}}">
    <label for="district_id" class="control-label">{{ 'District Id' }}</label>
    <input class="form-control" name="district_id" type="text" id="district_id" value="{{ isset($candidate->district_id) ? $candidate->district_id : ''}}" >
    {!! $errors->first('district_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('electorate_id') ? 'has-error' : ''}}">
    <label for="electorate_id" class="control-label">{{ 'Electorate Id' }}</label>
    <input class="form-control" name="electorate_id" type="text" id="electorate_id" value="{{ isset($candidate->electorate_id) ? $candidate->electorate_id : ''}}" >
    {!! $errors->first('electorate_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('sub_district_id') ? 'has-error' : ''}}">
    <label for="sub_district_id" class="control-label">{{ 'Sub District Id' }}</label>
    <input class="form-control" name="sub_district_id" type="text" id="sub_district_id" value="{{ isset($candidate->sub_district_id) ? $candidate->sub_district_id : ''}}" >
    {!! $errors->first('sub_district_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('political_partie_id') ? 'has-error' : ''}}">
    <label for="political_partie_id" class="control-label">{{ 'Political Partie Id' }}</label>
    <input class="form-control" name="political_partie_id" type="text" id="political_partie_id" value="{{ isset($candidate->political_partie_id) ? $candidate->political_partie_id : ''}}" >
    {!! $errors->first('political_partie_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('year_id') ? 'has-error' : ''}}">
    <label for="year_id" class="control-label">{{ 'Year Id' }}</label>
    <input class="form-control" name="year_id" type="text" id="year_id" value="{{ isset($candidate->year_id) ? $candidate->year_id : ''}}" >
    {!! $errors->first('year_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
    <label for="type" class="control-label">{{ 'Type' }}</label>
    <input class="form-control" name="type" type="text" id="type" value="{{ isset($candidate->type) ? $candidate->type : ''}}" >
    {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group mt-4 " >
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
