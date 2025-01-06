<div class="form-group {{ $errors->has('name_polling_unit') ? 'has-error' : ''}}">
    <label for="name_polling_unit" class="control-label">{{ 'Name Polling Unit' }}</label>
    <input class="form-control" name="name_polling_unit" type="text" id="name_polling_unit" value="{{ isset($polling_unit->name_polling_unit) ? $polling_unit->name_polling_unit : ''}}" >
    {!! $errors->first('name_polling_unit', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('province_id') ? 'has-error' : ''}}">
    <label for="province_id" class="control-label">{{ 'Province Id' }}</label>
    <input class="form-control" name="province_id" type="text" id="province_id" value="{{ isset($polling_unit->province_id) ? $polling_unit->province_id : ''}}" >
    {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('district_id') ? 'has-error' : ''}}">
    <label for="district_id" class="control-label">{{ 'District Id' }}</label>
    <input class="form-control" name="district_id" type="text" id="district_id" value="{{ isset($polling_unit->district_id) ? $polling_unit->district_id : ''}}" >
    {!! $errors->first('district_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('electorate_id') ? 'has-error' : ''}}">
    <label for="electorate_id" class="control-label">{{ 'Electorate Id' }}</label>
    <input class="form-control" name="electorate_id" type="text" id="electorate_id" value="{{ isset($polling_unit->electorate_id) ? $polling_unit->electorate_id : ''}}" >
    {!! $errors->first('electorate_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('sub_district_id') ? 'has-error' : ''}}">
    <label for="sub_district_id" class="control-label">{{ 'Sub District Id' }}</label>
    <input class="form-control" name="sub_district_id" type="text" id="sub_district_id" value="{{ isset($polling_unit->sub_district_id) ? $polling_unit->sub_district_id : ''}}" >
    {!! $errors->first('sub_district_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('eligible_voters') ? 'has-error' : ''}}">
    <label for="eligible_voters" class="control-label">{{ 'Eligible Voters' }}</label>
    <input class="form-control" name="eligible_voters" type="text" id="eligible_voters" value="{{ isset($polling_unit->eligible_voters) ? $polling_unit->eligible_voters : ''}}" >
    {!! $errors->first('eligible_voters', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
