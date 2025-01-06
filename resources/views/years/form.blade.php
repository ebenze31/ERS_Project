<div class="form-group {{ $errors->has('year') ? 'has-error' : ''}}">
    <label for="year" class="control-label">{{ 'Year' }}</label>
    <input class="form-control" name="year" type="text" id="year" value="{{ isset($year->year) ? $year->year : ''}}" >
    {!! $errors->first('year', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('round') ? 'has-error' : ''}}">
    <label for="round" class="control-label">{{ 'Round' }}</label>
    <input class="form-control" name="round" type="text" id="round" value="{{ isset($year->round) ? $year->round : ''}}" >
    {!! $errors->first('round', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
