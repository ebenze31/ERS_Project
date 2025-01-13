<div class="form-group mt-2 {{ $errors->has('year') ? 'has-error' : '' }}">
    <label for="year" class="control-label">{{ 'ปีการเลือกตั้ง (พ.ศ.)' }}</label>
    @php
        $currentYearAD = date('Y'); // ปี ค.ศ.
    @endphp
    <select class="form-control" name="year" id="year">
        @for ($i = $currentYearAD; $i <= $currentYearAD + 2; $i++)
            <!-- ปี ค.ศ. -->
            <option value="{{ $i }}" {{ isset($year->year) && $year->year == $i ? 'selected' : '' }}>
                {{ $i + 543 }} <!-- แสดงปี พ.ศ. -->
            </option>
        @endfor
    </select>
    {{-- {!! $errors->first('year', '<p class="help-block text-danger">:message</p>') !!} --}}
</div>
<div class="form-group mt-2 {{ $errors->has('round') ? 'has-error' : '' }}">
    <label for="round" class="control-label">{{ 'รอบการเลือกตั้ง' }}</label>
    <input class="form-control" name="round" type="number" id="round" min="1"value="{{ isset($year->round) ? $year->round : '' }}">
    {{-- {!! $errors->first('round', '<p class="help-block text-danger">:message</p>') !!} --}}
</div>

<div class="form-group mt-2 {{ $errors->has('candidate_types') ? 'has-error' : '' }}">
    <label for="candidate_types" class="control-label">เลือกประเภทผู้สมัคร</label>
    <!-- Checkbox -->
    <div id="checkbox-group">
        @foreach ($candidateTypes as $type)
            <div class="form-check">
                <input
                    type="checkbox"
                    name="candidate_types[]"
                    id="candidate-type-{{ $type->id }}"
                    value="{{ $type->name }}"
                    class="form-check-input"
                    onclick="updateActiveInput()"
                    {{ in_array($type->id, old('candidate_types', [])) ? 'checked' : '' }}>
                <label for="candidate-type-{{ $type->id }}" class="form-check-label">
                    {{ $type->name }}
                </label>
            </div>
        @endforeach
    </div>
    <!-- Error Message -->
    {{-- {!! $errors->first('active', '<p class="help-block text-danger">:message</p>') !!} --}}
</div>

<div class="d-non form-group mt-2 {{ $errors->has('active') ? 'has-error' : '' }}">
    <label for="active" class="control-label">{{ 'Active' }}</label>
    <input readonly class="form-control" name="active" type="text" id="active"
        value="{{ isset($year->active) ? $year->active : '' }}">
</div>


<div class="form-group mt-4" style="float:right">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'บันทึก' : 'บันทึก' }}">
</div>



<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // getData();
    });

    document.querySelector('form').addEventListener('submit', function(event) {
        let isValid = true;

        // ลบข้อความ error เก่าก่อน
        document.querySelectorAll('.help-block.text-danger').forEach(el => el.remove());

        // ตรวจสอบปีการเลือกตั้ง
        const yearInput = document.getElementById('year');
        if (!yearInput.value.trim()) {
            showError(yearInput, 'กรุณาเลือกปีการเลือกตั้ง');
            isValid = false;
        }

        // ตรวจสอบรอบการเลือกตั้ง
        const roundInput = document.getElementById('round');
        if (!roundInput.value.trim() || roundInput.value <= 0) {
            showError(roundInput, 'กรุณากรอกข้อมูลรอบการเลือกตั้งที่ถูกต้อง');
            isValid = false;
        }

        // ตรวจสอบประเภทผู้สมัคร
        const checkedBoxes = document.querySelectorAll('#checkbox-group input[type="checkbox"]:checked');
        if (checkedBoxes.length === 0) {
            const checkboxGroup = document.getElementById('checkbox-group');
            showError(checkboxGroup, 'กรุณาเลือกประเภทผู้สมัครอย่างน้อย 1 รายการ');
            isValid = false;
        }

        // ถ้าข้อมูลไม่ถูกต้อง ให้หยุดการส่งฟอร์ม
        if (!isValid) {
            event.preventDefault();
        }
    });

    // ฟังก์ชันแสดงข้อความ error
    function showError(input, message) {
        const errorElement = document.createElement('p');
        errorElement.className = 'help-block text-danger';
        errorElement.textContent = message;

        // ตรวจสอบว่า input อยู่ในกลุ่ม form-group หรือไม่
        const formGroup = input.closest('.form-group') || input.closest('#checkbox-group');
        if (formGroup) {
            formGroup.appendChild(errorElement);
        }
    }

    function updateActiveInput() {
        // ดึงค่า checkbox ที่ถูกติ๊กในกลุ่ม
        const checkedValues = Array.from(
            document.querySelectorAll('#checkbox-group input[type="checkbox"]:checked')
        ).map(checkbox => checkbox.value);

        // อัปเดตค่าใน input "active"
        const activeInput = document.getElementById('active');
        activeInput.value = checkedValues.join(',');
    }


</script>


{{-- <script>
    function getData() {
        fetch("{{ url('/') }}/api/getData_Type_Candidate")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network ตอบสนองไม่ OK " + response.statusText);
                }
                return response.json();
            })
            .then(result => {
                const checkboxGroup = document.getElementById('checkbox-group');
                const activeInput = document.getElementById('active');
                // เคลียร์เนื้อหาเดิม
                checkboxGroup.innerHTML = '';

                // สร้าง checkbox ตามข้อมูลใน result
                result['type_candidates'].forEach(item => {
                    // สร้าง div แต่ละ checkbox
                    const checkboxDiv = document.createElement('div');
                    checkboxDiv.className = 'form-check';

                    // สร้าง input checkbox
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'candidate_type[]'; // เก็บค่าหลายตัวใน array
                    checkbox.value = item.name;
                    checkbox.className = 'form-check-input';
                    checkbox.id = `checkbox-${item.id}`;

                    // สร้าง label สำหรับ checkbox
                    const label = document.createElement('label');
                    label.className = 'form-check-label';
                    label.htmlFor = `checkbox-${item.id}`;
                    label.innerText = item.name;

                    // ใส่ checkbox และ label ลงใน div
                    checkboxDiv.appendChild(checkbox);
                    checkboxDiv.appendChild(label);

                    // เพิ่ม checkboxDiv เข้าในกลุ่ม
                    checkboxGroup.appendChild(checkboxDiv);

                    // ฟังการเปลี่ยนแปลงเมื่อ checkbox ถูกติ๊ก
                    checkbox.addEventListener('change', () => {
                        updateActiveInput();
                    });
                });

                // ฟังก์ชันอัปเดตค่าใน input "active"
                function updateActiveInput() {
                    const checkedValues = Array.from(
                        checkboxGroup.querySelectorAll('input[type="checkbox"]:checked')
                    ).map(checkbox => checkbox.value);

                    activeInput.value = checkedValues.join(',');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script> --}}
