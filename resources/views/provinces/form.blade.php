<div class="form-group {{ $errors->has('name_province') ? 'has-error' : ''}}">
    <label for="name_province" class="control-label">{{ 'Name Province' }}</label>
    <input class="form-control" name="name_province" type="text" id="name_province" value="{{ isset($province->name_province) ? $province->name_province : ''}}" >
    {!! $errors->first('name_province', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('logo') ? 'has-error' : ''}}">
    <label for="logo" class="control-label">{{ 'Logo' }}</label>
    <input class="form-control" name="logo" type="file" id="logo" value="{{ isset($province->logo) ? $province->logo : ''}}" >
    {!! $errors->first('logo', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('banner') ? 'has-error' : ''}}">
    <label for="banner" class="control-label">{{ 'Banner' }}</label>
    <input class="form-control" name="banner" type="file" id="banner" value="{{ isset($province->banner) ? $province->banner : ''}}" >
    {!! $errors->first('banner', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <input class="form-control" name="status" type="text" id="status" value="{{ isset($province->status) ? $province->status : ''}}" >
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
