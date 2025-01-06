<div class="form-group {{ $errors->has('candidate_id') ? 'has-error' : ''}}">
    <label for="candidate_id" class="control-label">{{ 'Candidate Id' }}</label>
    <input class="form-control" name="candidate_id" type="text" id="candidate_id" value="{{ isset($score->candidate_id) ? $score->candidate_id : ''}}" >
    {!! $errors->first('candidate_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('yesr_id') ? 'has-error' : ''}}">
    <label for="yesr_id" class="control-label">{{ 'Yesr Id' }}</label>
    <input class="form-control" name="yesr_id" type="text" id="yesr_id" value="{{ isset($score->yesr_id) ? $score->yesr_id : ''}}" >
    {!! $errors->first('yesr_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('polling_unit_id') ? 'has-error' : ''}}">
    <label for="polling_unit_id" class="control-label">{{ 'Polling Unit Id' }}</label>
    <input class="form-control" name="polling_unit_id" type="text" id="polling_unit_id" value="{{ isset($score->polling_unit_id) ? $score->polling_unit_id : ''}}" >
    {!! $errors->first('polling_unit_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('sub_district_id') ? 'has-error' : ''}}">
    <label for="sub_district_id" class="control-label">{{ 'Sub District Id' }}</label>
    <input class="form-control" name="sub_district_id" type="text" id="sub_district_id" value="{{ isset($score->sub_district_id) ? $score->sub_district_id : ''}}" >
    {!! $errors->first('sub_district_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('electorate_id') ? 'has-error' : ''}}">
    <label for="electorate_id" class="control-label">{{ 'Electorate Id' }}</label>
    <input class="form-control" name="electorate_id" type="text" id="electorate_id" value="{{ isset($score->electorate_id) ? $score->electorate_id : ''}}" >
    {!! $errors->first('electorate_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('district_id') ? 'has-error' : ''}}">
    <label for="district_id" class="control-label">{{ 'District Id' }}</label>
    <input class="form-control" name="district_id" type="text" id="district_id" value="{{ isset($score->district_id) ? $score->district_id : ''}}" >
    {!! $errors->first('district_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('province_id') ? 'has-error' : ''}}">
    <label for="province_id" class="control-label">{{ 'Province Id' }}</label>
    <input class="form-control" name="province_id" type="text" id="province_id" value="{{ isset($score->province_id) ? $score->province_id : ''}}" >
    {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('score') ? 'has-error' : ''}}">
    <label for="score" class="control-label">{{ 'Score' }}</label>
    <input class="form-control" name="score" type="number" id="score" value="{{ isset($score->score) ? $score->score : ''}}" >
    {!! $errors->first('score', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('round') ? 'has-error' : ''}}">
    <label for="round" class="control-label">{{ 'Round' }}</label>
    <input class="form-control" name="round" type="text" id="round" value="{{ isset($score->round) ? $score->round : ''}}" >
    {!! $errors->first('round', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
