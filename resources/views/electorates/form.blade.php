<div class="form-group {{ $errors->has('name_electorate') ? 'has-error' : ''}}">
    <label for="name_electorate" class="control-label">{{ 'Name Electorate' }}</label>
    <input class="form-control" name="name_electorate" type="text" id="name_electorate" value="{{ isset($electorate->name_electorate) ? $electorate->name_electorate : ''}}" >
    {!! $errors->first('name_electorate', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('province_id') ? 'has-error' : ''}}">
    <label for="province_id" class="control-label">{{ 'Province Id' }}</label>
    <input class="form-control" name="province_id" type="text" id="province_id" value="{{ isset($electorate->province_id) ? $electorate->province_id : ''}}" >
    {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('district_id') ? 'has-error' : ''}}">
    <label for="district_id" class="control-label">{{ 'District Id' }}</label>
    <input class="form-control" name="district_id" type="text" id="district_id" value="{{ isset($electorate->district_id) ? $electorate->district_id : ''}}" >
    {!! $errors->first('district_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
