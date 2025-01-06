<div class="form-group {{ $errors->has('name_sub_districts') ? 'has-error' : ''}}">
    <label for="name_sub_districts" class="control-label">{{ 'Name Sub Districts' }}</label>
    <input class="form-control" name="name_sub_districts" type="text" id="name_sub_districts" value="{{ isset($sub_district->name_sub_districts) ? $sub_district->name_sub_districts : ''}}" >
    {!! $errors->first('name_sub_districts', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('province_id') ? 'has-error' : ''}}">
    <label for="province_id" class="control-label">{{ 'Province Id' }}</label>
    <input class="form-control" name="province_id" type="text" id="province_id" value="{{ isset($sub_district->province_id) ? $sub_district->province_id : ''}}" >
    {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('district_id') ? 'has-error' : ''}}">
    <label for="district_id" class="control-label">{{ 'District Id' }}</label>
    <input class="form-control" name="district_id" type="text" id="district_id" value="{{ isset($sub_district->district_id) ? $sub_district->district_id : ''}}" >
    {!! $errors->first('district_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('electorate_id') ? 'has-error' : ''}}">
    <label for="electorate_id" class="control-label">{{ 'Electorate Id' }}</label>
    <input class="form-control" name="electorate_id" type="text" id="electorate_id" value="{{ isset($sub_district->electorate_id) ? $sub_district->electorate_id : ''}}" >
    {!! $errors->first('electorate_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
