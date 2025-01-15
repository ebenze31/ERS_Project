@extends('layouts.theme_admin')
<style>
    .color_input {
        width: 60%;
    }

    /* สำหรับหน้าจอมือถือ */
    @media (max-width: 768px) {
        .color_input {
            width: 40%;
        }
    }
</style>
@section('content')
    <!-- สำหรับแจ้งเตือนจากหลังบ้าน เวลาบันทึกข้อมูลเรียบร้อย-->
    @if(session('flash_message'))
        <div id="flash-message" class="alert alert-success" role="alert">
            {{ session('flash_message') }}
        </div>
        <script type="text/javascript">
            // ตั้งเวลาหลังจาก 5 วินาที (5000 มิลลิวินาที) ให้ซ่อนข้อความ
            setTimeout(function() {
                document.getElementById('flash-message').style.display = 'none';
            }, 5000);
        </script>
    @endif


    <div class="p-4 bg-light shadow card">
        <h1 class="h4 fw-bold mb-3">ตั้งค่าระบบจังหวัด {{ $province ? $province : '-' }}</h1>

        <form method="POST" action="{{ url('/set_system_data') }}" accept-charset="UTF-8" class="form-horizontal"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            <input id="province" name="province" type="text" value="{{ $province ? $province : '' }}" class="form-control d-none" />
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4 form-group">
                    <label class="form-label" style="font-weight: bold; font-size: 1.2rem;">โลโก้<span class="text-danger" style="font-size: 1rem;">(1000 * 1000 px)</span></label>
                    <input id="logo" name="logo" type="file" class="form-control" />
                </div>

                <div class="col-11 col-md-4 form-group">
                    <label class="form-label" style="font-weight: bold; font-size: 1.2rem;">แบนเนอร์<span class="text-danger" style="font-size: 1rem;">(4000 * 300 px)</span></label>
                    <input id="banner" name="banner" type="file" class="form-control" />
                </div>

                <div class="col-11 col-md-4 form-group">
                    <label class="form-label" style="font-weight: bold; font-size: 1.2rem;">แบนเนอร์มือถือ<span class="text-danger" style="font-size: 1rem;">(4000 * 750 px)</span></label>
                    <input id="banner_mobile" name="banner_mobile" type="file" class="form-control" />
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4 form-group">
                    <label class="form-label" style="font-weight: bold; font-size: 1.2rem;">สีพื้นหลัก</label>

                    <div class="d-flex align-items-center justify-content-start">
                        <input id="main_color" name="color_1" type="text" class="form-control color_input "
                            style="margin-right: 1rem;" />
                        <div class="d-flex justify-content-evenly align-items-center"
                            style="border-right: #6c757d solid 2px; margin-right: 1rem;">
                            <div class="header-colors-indigators"></div>
                            <label for=""
                                style="font-weight: bold; font-size: 16px; padding-right: 15px;">เลือกสี</label>
                        </div>
                        <input class="ms-0" type="color" name="" id="selector_main_color"
                            style="width: 60px;height: 27px;border: none;border-radius: 10px;" value="">
                    </div>
                </div>

                <div class="col-12 col-md-4 form-group">
                    <label class="form-label" style="font-weight: bold; font-size: 1.2rem;">สีตัวหนังสือหัวข้อ</label>
                    <div class="d-flex align-items-center justify-content-start">
                        <input id="head_text_color" name="color_2" type="text" class="form-control color_input"
                            style="margin-right: 1rem;" />
                        <div class="d-flex justify-content-evenly align-items-center"
                            style="border-right: #6c757d solid 2px; margin-right: 1rem;">
                            <div class="header-colors-indigators"></div>
                            <label for=""
                                style="font-weight: bold; font-size: 16px; padding-right: 15px;">เลือกสี</label>
                        </div>
                        <input class="ms-0" type="color" name="" id="selector_head_text_color"
                            style="width: 60px;height: 27px;border: none;border-radius: 10px;" value="">
                    </div>
                </div>

                <div class="col-12 col-md-4 form-group">
                    <label class="form-label" style="font-weight: bold; font-size: 1.2rem;">สีตัวหนังสือในปุ่ม</label>
                    <div class="d-flex align-items-center justify-content-start">
                        <input id="button_text_color" name="color_3" type="text" class="form-control color_input"
                            style="margin-right: 1rem;" />
                        <div class="d-flex justify-content-evenly align-items-center"
                            style="border-right: #6c757d solid 2px; margin-right: 1rem;">
                            <div class="header-colors-indigators"></div>
                            <label for=""
                                style="font-weight: bold; font-size: 16px; padding-right: 15px;">เลือกสี</label>
                        </div>
                        <input class="ms-0" type="color" name="" id="selector_button_text_color"
                            style="width: 60px;height: 27px;border: none;border-radius: 10px;" value="">
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
                <button style="float:right" class="btn btn-success w-25" type="submit"
                    onclick="submitform()">ยืนยัน</button>
            </div>
        </form>
    </div>

    <script>
        function submitform() {
            let isValid = true;

            // ลบข้อความ error เก่า
            document.querySelectorAll('.help-block').forEach(el => el.remove());

            // ตรวจสอบไฟล์โลโก้
            const logoInput = document.getElementById('logo');
            if (!logoInput.value.trim()) {
                showError(logoInput, 'กรุณาอัปโหลดโลโก้');
                isValid = false;
            }

            // ตรวจสอบไฟล์แบนเนอร์
            const bannerInput = document.getElementById('banner');
            if (!bannerInput.value.trim()) {
                showError(bannerInput, 'กรุณาอัปโหลดแบนเนอร์');
                isValid = false;
            }

            // ตรวจสอบไฟล์แบนเนอร์
            const banner_mobileInput = document.getElementById('banner_mobile');
            if (!banner_mobileInput.value.trim()) {
                showError(banner_mobileInput, 'กรุณาอัปโหลดแบนเนอร์(มือถือ)');
                isValid = false;
            }

            // ตรวจสอบสีพื้นหลัก
            const mainColorInput = document.getElementById('main_color');
            if (!mainColorInput.value.trim() || !isValidColor(mainColorInput.value.trim())) {
                showError(mainColorInput, 'กรุณากรอกโค้ดสีที่ถูกต้อง เช่น #ff0000');
                isValid = false;
            }

            // ตรวจสอบสีตัวหนังสือหัวข้อ
            const headTextColorInput = document.getElementById('head_text_color');
            if (!headTextColorInput.value.trim() || !isValidColor(headTextColorInput.value.trim())) {
                showError(headTextColorInput, 'กรุณากรอกโค้ดสีที่ถูกต้อง เช่น #ff0000');
                isValid = false;
            }

            // ตรวจสอบสีตัวหนังสือในปุ่ม
            const buttonTextColorInput = document.getElementById('button_text_color');
            if (!buttonTextColorInput.value.trim() || !isValidColor(buttonTextColorInput.value.trim())) {
                showError(buttonTextColorInput, 'กรุณากรอกโค้ดสีที่ถูกต้อง เช่น #ff0000');
                isValid = false;
            }

            // หยุดการส่งฟอร์มถ้ามีข้อผิดพลาด
            if (!isValid) {
                event.preventDefault();
            }

            // create_data();
        };

        function showError(input, message) {
            const errorElement = document.createElement('p');
            errorElement.className = 'text-danger help-block';
            errorElement.textContent = message;
            input.closest('.form-group').appendChild(errorElement);
        }

        function isValidColor(color) {
            const s = new Option().style;
            s.color = color;
            return s.color !== '';
        }



        // เชื่อมโยง input[type=text] และ input[type=color]
        function syncColorInputs(textInputId, colorInputId) {
            const textInput = document.getElementById(textInputId);
            const colorInput = document.getElementById(colorInputId);

            // เมื่อเลือกสีที่ input[type=color]
            colorInput.addEventListener('input', () => {
                textInput.value = colorInput.value;
            });

            // เมื่อใส่โค้ดสีที่ input[type=text]
            textInput.addEventListener('input', () => {
                if (isValidColor(textInput.value.trim())) {
                    colorInput.value = textInput.value.trim();
                }
            });
        }

        // เรียกใช้งานฟังก์ชันกับแต่ละชุด input
        syncColorInputs('main_color', 'selector_main_color');
        syncColorInputs('head_text_color', 'selector_head_text_color');
        syncColorInputs('button_text_color', 'selector_button_text_color');
    </script>

    <script>
        document.getElementById("logo").addEventListener("change", function (event) {
            validateImage(event.target, 1000, 1000, "โลโก้");
        });

        document.getElementById("banner").addEventListener("change", function (event) {
            validateImage(event.target, 4000, 300, "แบนเนอร์");
        });

        document.getElementById("banner_mobile").addEventListener("change", function (event) {
            validateImage(event.target, 4000, 750, "แบนเนอร์(มือถือ)");
        });

        function validateImage(input, requiredWidth, requiredHeight, label) {
            const file = input.files[0];
            if (!file) return;

            const img = new Image();
            img.onload = function () {
                // เช็คขนาดภาพ
                if (img.width !== requiredWidth || img.height !== requiredHeight) {
                    alert(
                        `${label} ต้องมีขนาด ${requiredWidth}x${requiredHeight} พิกเซลเท่านั้น, ขนาดที่อัปโหลดคือ ${img.width}x${img.height} พิกเซล`
                    );
                    input.value = ""; // ล้างค่าไฟล์
                }
            };

            // สร้าง URL ของไฟล์เพื่อใช้ในการโหลด
            img.src = URL.createObjectURL(file);

            // ตรวจสอบเบราว์เซอร์ที่ไม่รองรับ Image.onload
            if (img.complete) {
                img.onload();
            }
        }
    </script>

@endsection
