@extends('layouts.theme_admin')
<style>
    .color_input {
        width: 60% !important;
    }

    /* สำหรับหน้าจอมือถือ */
    @media (max-width: 768px) {
        .color_input {
            width: 40% !important;
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
                    <!-- แสดงโลโก้เก่าถ้ามี -->
                    <div id="logo-preview" style="margin-top: 10px;">
                        <img id="logo-img" src="" alt="Current Logo" style="max-width: 33%; height: auto; display: none;">
                    </div>
                </div>

                <div class="col-12 col-md-4 form-group">
                    <label class="form-label" style="font-weight: bold; font-size: 1.2rem;">แบนเนอร์<span class="text-danger" style="font-size: 1rem;">(4000 * 300 px)</span></label>
                    <input id="banner" name="banner" type="file" class="form-control" />
                    <!-- แสดงแบนเนอร์เก่าถ้ามี -->
                    <div id="banner-preview" style="margin-top: 10px;">
                        <img id="banner-img" src="" alt="Current Banner" style="max-width: 100%; height: auto; display: none;">
                    </div>
                </div>

                <div class="col-12 col-md-4 form-group">
                    <label class="form-label" style="font-weight: bold; font-size: 1.2rem;">แบนเนอร์มือถือ<span class="text-danger" style="font-size: 1rem;">(4000 * 750 px)</span></label>
                    <input id="banner_mobile" name="banner_mobile" type="file" class="form-control" />
                    <!-- แสดงแบนเนอร์มือถือเก่าถ้ามี -->
                    <div id="banner_mobile-preview" style="margin-top: 10px;">
                        <img id="banner_mobile-img" src="" alt="Current Mobile Banner" style="max-width: 100%; height: auto; display: none;">
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4 form-group">
                    <label class="form-label" style="font-weight: bold; font-size: 1.2rem;">สีปุ่มหลัก</label>

                    <div class="d-flex align-items-center justify-content-start mb-1">
                        <input id="main_color" name="color_1" type="text" class="form-control color_input" value="{{ isset($data_province->color_1) ? $data_province->color_1 : ''}}"
                            style="margin-right: 1rem;" />
                        <div class="d-flex justify-content-evenly align-items-center"
                            style="border-right: #6c757d solid 2px; margin-right: 1rem;">
                            <div class="header-colors-indigators"></div>
                            <label for=""
                                style="font-weight: bold; font-size: 16px; padding-right: 15px;">เลือกสี</label>
                        </div>
                        <input class="ms-0" type="color" name="" id="selector_main_color"
                            style="width: 60px;height: 27px;border: none;border-radius: 10px;" value="{{ isset($data_province->color_1) ? $data_province->color_1 : ''}}">
                    </div>
                    <small id="color_old_1" class="p-1">สีเดิม : {{ isset($data_province->color_1) ? $data_province->color_1 : 'ไม่มี'}}</small>
                </div>

                <div class="col-12 col-md-4 form-group">
                    <label class="form-label" style="font-weight: bold; font-size: 1.2rem;">สีตัวหนังสือหัวข้อ</label>
                    <div class="d-flex align-items-center justify-content-start mb-1">
                        <input id="head_text_color" name="color_2" type="text" class="form-control color_input" value="{{ isset($data_province->color_2) ? $data_province->color_2 : ''}}"
                            style="margin-right: 1rem;" />
                        <div class="d-flex justify-content-evenly align-items-center"
                            style="border-right: #6c757d solid 2px; margin-right: 1rem;">
                            <div class="header-colors-indigators"></div>
                            <label for=""
                                style="font-weight: bold; font-size: 16px; padding-right: 15px;">เลือกสี</label>
                        </div>
                        <input class="ms-0" type="color" name="" id="selector_head_text_color"
                            style="width: 60px;height: 27px;border: none;border-radius: 10px;" value="{{ isset($data_province->color_2) ? $data_province->color_2 : ''}}">
                    </div>
                    <small id="color_old_2" class="p-1">สีเดิม : {{ isset($data_province->color_2) ? $data_province->color_2 : 'ไม่มี'}}</small>
                </div>

                <div class="col-12 col-md-4 form-group">
                    <label class="form-label" style="font-weight: bold; font-size: 1.2rem;">สีตัวหนังสือในปุ่ม</label>
                    <div class="d-flex align-items-center justify-content-start mb-1">
                        <input id="button_text_color" name="color_3" type="text" class="form-control color_input" value="{{ isset($data_province->color_3) ? $data_province->color_3 : ''}}"
                            style="margin-right: 1rem;" />

                        <div class="d-flex justify-content-evenly align-items-center"
                            style="border-right: #6c757d solid 2px; margin-right: 1rem;">
                            <div class="header-colors-indigators"></div>
                            <label for=""
                                style="font-weight: bold; font-size: 16px; padding-right: 15px;">เลือกสี</label>
                        </div>
                        <input class="ms-0" type="color" name="" id="selector_button_text_color"
                            style="width: 60px;height: 27px;border: none;border-radius: 10px;" value="{{ isset($data_province->color_3) ? $data_province->color_3 : ''}}">
                    </div>
                    <small id="color_old_3" class="p-1">สีเดิม : {{ isset($data_province->color_3) ? $data_province->color_3 : 'ไม่มี'}}</small>
                </div>
            </div>

            <div class="form-group mt-4">
                <button style="float:right" class="btn btn-success w-25" type="submit"
                    onclick="">ยืนยัน</button>
            </div>
        </form>
    </div>

    <script>
        // function submitform() {
        //     let isValid = true;

        //     // ลบข้อความ error เก่า
        //     document.querySelectorAll('.help-block').forEach(el => el.remove());

        //     // ตรวจสอบไฟล์โลโก้
        //     const logoInput = document.getElementById('logo');
        //     if (!logoInput.value.trim()) {
        //         showError(logoInput, 'กรุณาอัปโหลดโลโก้');
        //         isValid = false;
        //     }

        //     // ตรวจสอบไฟล์แบนเนอร์
        //     const bannerInput = document.getElementById('banner');
        //     if (!bannerInput.value.trim()) {
        //         showError(bannerInput, 'กรุณาอัปโหลดแบนเนอร์');
        //         isValid = false;
        //     }

        //     // ตรวจสอบไฟล์แบนเนอร์
        //     const banner_mobileInput = document.getElementById('banner_mobile');
        //     if (!banner_mobileInput.value.trim()) {
        //         showError(banner_mobileInput, 'กรุณาอัปโหลดแบนเนอร์(มือถือ)');
        //         isValid = false;
        //     }

        //     // ตรวจสอบสีพื้นหลัก
        //     const mainColorInput = document.getElementById('main_color');
        //     if (!mainColorInput.value.trim() || !isValidColor(mainColorInput.value.trim())) {
        //         showError(mainColorInput, 'กรุณากรอกโค้ดสีที่ถูกต้อง เช่น #ff0000');
        //         isValid = false;
        //     }

        //     // ตรวจสอบสีตัวหนังสือหัวข้อ
        //     const headTextColorInput = document.getElementById('head_text_color');
        //     if (!headTextColorInput.value.trim() || !isValidColor(headTextColorInput.value.trim())) {
        //         showError(headTextColorInput, 'กรุณากรอกโค้ดสีที่ถูกต้อง เช่น #ff0000');
        //         isValid = false;
        //     }

        //     // ตรวจสอบสีตัวหนังสือในปุ่ม
        //     const buttonTextColorInput = document.getElementById('button_text_color');
        //     if (!buttonTextColorInput.value.trim() || !isValidColor(buttonTextColorInput.value.trim())) {
        //         showError(buttonTextColorInput, 'กรุณากรอกโค้ดสีที่ถูกต้อง เช่น #ff0000');
        //         isValid = false;
        //     }

        //     // หยุดการส่งฟอร์มถ้ามีข้อผิดพลาด
        //     if (!isValid) {
        //         event.preventDefault();
        //     }

        //     // create_data();
        // };

        // function showError(input, message) {
        //     const errorElement = document.createElement('p');
        //     errorElement.className = 'text-danger help-block';
        //     errorElement.textContent = message;
        //     input.closest('.form-group').appendChild(errorElement);
        // }


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
            textInput.addEventListener('blur', () => {
                const colorValue = textInput.value.trim();
                if (!isValidColor(colorValue)) {
                    if(colorValue){
                        alert('กรุณากรอกโค้ดสีที่ถูกต้อง เช่น #ff0000');
                    }
                    colorInput.value = '#000000';
                } else {
                    colorInput.value = colorValue;
                }
            });

            // เมื่อทำการเคลียร์ค่าใน input[type=text]
            textInput.addEventListener('blur', () => {
                if (!textInput.value.trim()) {
                    // ถ้าไม่มีค่าใน textInput, เปลี่ยน selector เป็นสีดำ
                    colorInput.value = '#000000';
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

    <script>
        // ตัวอย่างการแสดงภาพเก่าจากฐานข้อมูล
        const logoImage = '{{ url('storage')}}/{{ $data_province->logo }}'; // ใส่เส้นทางรูปภาพโลโก้ที่เก็บในฐานข้อมูล
        const bannerImage = '{{ url('storage')}}/{{ $data_province->banner }}'; // ใส่เส้นทางแบนเนอร์เก่าจากฐานข้อมูล
        const bannerMobileImage = '{{ url('storage')}}/{{ $data_province->banner_mobile }}'; // ใส่เส้นทางแบนเนอร์มือถือเก่าจากฐานข้อมูล

        // ฟังก์ชันสำหรับแสดงภาพเก่า
        function showImagePreview(inputId, previewId, imgId, imagePath) {
            const inputElement = document.getElementById(inputId);
            const previewElement = document.getElementById(previewId);
            const imgElement = document.getElementById(imgId);

            if (imagePath) {
                imgElement.src = imagePath;
                imgElement.style.display = 'block'; // แสดงรูปภาพเก่า
            }

            // เมื่อเลือกไฟล์ใหม่จาก input[type="file"]
            inputElement.addEventListener('change', () => {
                const file = inputElement.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imgElement.src = e.target.result;
                        imgElement.style.display = 'block'; // แสดงรูปใหม่ที่เลือก
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // เรียกใช้ฟังก์ชันสำหรับแสดงภาพเก่า
        showImagePreview('logo', 'logo-preview', 'logo-img', logoImage);
        showImagePreview('banner', 'banner-preview', 'banner-img', bannerImage);
        showImagePreview('banner_mobile', 'banner_mobile-preview', 'banner_mobile-img', bannerMobileImage);
    </script>

@endsection
