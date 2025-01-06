<div class="form-group {{ $errors->has('name_district') ? 'has-error' : ''}}">
    <label for="name_district" class="control-label">{{ 'Name District' }}</label>
    <input class="form-control" name="name_district" type="text" id="name_district" value="{{ isset($district->name_district) ? $district->name_district : ''}}" >
    {!! $errors->first('name_district', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('province_id') ? 'has-error' : ''}}">
    <label for="province_id" class="control-label">{{ 'Province Id' }}</label>
    <input class="form-control" name="province_id" type="text" id="province_id" value="{{ isset($district->province_id) ? $district->province_id : ''}}" >
    {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
