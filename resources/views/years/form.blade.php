<div class="form-group mt-2 {{ $errors->has('year') ? 'has-error' : ''}}">
    <label for="year" class="control-label">{{ 'ปีการเลือกตั้ง (พ.ศ.)' }}</label>
    @php
        $currentYearAD = date('Y'); // ปี ค.ศ.
    @endphp
    <select class="form-control" name="year" id="year">
        @for ($i = $currentYearAD; $i <= $currentYearAD + 2; $i++) <!-- ปี ค.ศ. -->
            <option value="{{ $i }}" {{ (isset($year->year) && $year->year == $i) ? 'selected' : '' }}>
                {{ $i + 543 }} <!-- แสดงปี พ.ศ. -->
            </option>
        @endfor
    </select>
    {!! $errors->first('year', '<p class="help-block text-danger">:message</p>') !!}
</div>
<div class="form-group mt-2 {{ $errors->has('round') ? 'has-error' : ''}}">
    <label for="round" class="control-label">{{ 'รอบการเลือกตั้ง' }}</label>
    <input class="form-control" name="round" type="number" id="round" min="1" value="{{ isset($year->round) ? $year->round : ''}}" >
    {!! $errors->first('round', '<p class="help-block text-danger">:message</p>') !!}
</div>


<div class="form-group mt-4" style="float:right">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
