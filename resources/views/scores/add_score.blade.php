@extends('layouts.theme')

@section('content')
<style>
    .bg-dark {
        background-color: #000;
    }

    .radio-inputs .radio input {
        display: none;
    }

    .radio-inputs .radio .name {
        display: flex;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        border-radius: 50rem;
        border: .5px solid #000;
        color: rgba(51, 65, 85, 1);
        transition: all .15s ease-in-out;
        margin: 0 3px;
    }

    .radio-inputs .radio input:checked+.name {
        background-color: var(--btn-color);
        border-color: var(--btn-color);
        font-weight: 600;
        color: #fff;
    }
</style>
<div class="container mx-auto">

    <div class="w-100 h-[calc(100dvh-96px)] mt-[48px] flex justify-center  h-100 overflow-auto  ">
        <div class="block max-w-[800px]  w-full  mt-5">
            <div class="w-full flex items-center justify-center flex-shrink-0 ">
                <div class="w-full bg-white shadow-lg border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3 p-5 ">
                    <p class="text-[33px] font-extrabold header-text">กรอกคะแนน</p>

                    <div class="mt-5 max-sm:block flex items-center justify-between">
                        <p class="max-sm:text-[14.5px] max-sm:text-[#939393] max-sm:font-medium text-[19px] font-bold">อำเภอ</p>
                        <p class="max-sm:text-[19px] max-sm:text-[#000] max-sm:font-bold text-[16px]">{{ $data_polling_units->name_district }}</p>
                    </div>
                    <hr class="mt-2 mb-3 ">

                    <div class="mt-5 max-sm:block flex items-center justify-between">
                        <p class="max-sm:text-[14.5px] max-sm:text-[#939393] max-sm:font-medium text-[19px] font-bold">เขตเลือกตั้งที่</p>
                        <p class="max-sm:text-[19px] max-sm:text-[#000] max-sm:font-bold text-[16px]">{{ $data_polling_units->name_electorate }}</p>
                    </div>
                    <hr class="mt-2 mb-3 ">

                    <div class="mt-5 max-sm:block flex items-center justify-between">
                        <p class="max-sm:text-[14.5px] max-sm:text-[#939393] max-sm:font-medium text-[19px] font-bold">ตำบล</p>
                        <p class="max-sm:text-[19px] max-sm:text-[#000] max-sm:font-bold text-[16px]">{{ explode(" ",$data_polling_units->name_polling_unit)[0] }}</p>
                    </div>
                    <hr class="mt-2 mb-3 ">

                    <div class="mt-5 max-sm:block flex items-center justify-between">
                        <p class="max-sm:text-[14.5px] max-sm:text-[#939393] max-sm:font-medium text-[19px] font-bold">หน่วยเลือกตั้งที่</p>
                        <p class="max-sm:text-[19px] max-sm:text-[#000] max-sm:font-bold text-[16px] ">{{ explode(" ",$data_polling_units->name_polling_unit)[2] }}</p>
                    </div>
                    <hr class="mt-2 mb-3 ">


                    <div class="radio-inputs  w-full grid grid-flow-col max-sm:justify-stretch justify-start mt-10">
                        <label class="radio">
                            <input type="radio" name="radio" checked="" />
                            <span class="name max-sm:px-0 px-6 py-2">นายก อบจ.</span>
                        </label>
                        <label class="radio">
                            <input type="radio" name="radio" />
                            <span class="name max-sm:px-0 px-6 py-2">ส.อบจ.</span>
                        </label>
                        
                        <!-- <label class="radio">
                                <input type="radio" name="radio" />
                                <span class="name max-sm:px-0 px-6 py-2">Third</span>
                            </label> -->
                    </div>

                    <div class="max-sm:block flex">
                        <div class="form-group row mt-4 w-1/2 max-sm:w-full me-2 ">
                            <label class="col-md-4 col-form-label text-md-right text-[#939393] text-[14.5px]">
                                คะแนนเบอร์ 1 ชื่อผู้สมัคร
                            </label>
                            <input type="number" id="" name="" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                        </div>
                        <div class="form-group row mt-4 w-1/2 max-sm:w-full me-2 ">
                            <label class="col-md-4 col-form-label text-md-right text-[#939393] text-[14.5px]">
                                คะแนนเบอร์ 2 ชื่อผู้สมัคร
                            </label>
                            <input type="number" id="" name="" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                        </div>
                        
                    </div>
                    <p class=" max-sm:px-0 max-sm:text-center text-end p-0 mt-5"> เจ้าหน้าที่ผู้กรอกคะแนน</p>
                    <p class=" max-sm:px-0 max-sm:text-center text-end p-0 text-[#db2d2e]"> <u>หทัยทิพย์ คงควร</u></p>

                    <div class="carousel-nav flex justify-end gap-2 pt-2">
                        <a href="#"class="btn-color max-sm:w-full md:px-6 carousel-nav-next rounded-full bg-dark p-1.5 text-white shadow-sm hover:bg-gray-950 text-center mt-0 focus-visible:outline focus-visible:outline-1 focus-visible:outline-offset-2 focus-visible:outline-gray-200 transition-all duration-300">
                            ยืนยัน
                        </a>
                    </div>

                    <div class="flex max-sm:justify-center justify-end items-center">
                        <span class="max-sm:px-0 text-center py-3 me-2">เวลาปัจจุบัน</span>
                        <span class="max-sm:px-0 text-center py-3" id="current-time"></span>
                    </div>
                    <script>
                        function updateTime() {
                            const currentTimeElement = document.getElementById('current-time');
                            let currentDate = new Date();

                            let hours = currentDate.getHours().toString().padStart(2, '0');
                            let minutes = currentDate.getMinutes().toString().padStart(2, '0');
                            let seconds = currentDate.getSeconds().toString().padStart(2, '0');

                            let currentTime = `${hours}:${minutes}:${seconds}`;

                            currentTimeElement.textContent = currentTime;
                        }

                        // เรียกใช้ฟังก์ชัน updateTime ทุก 1 วินาที (1000 มิลลิวินาที)
                        setInterval(updateTime, 1000);

                        // เรียกใช้ครั้งแรกเพื่อแสดงเวลาทันที
                        updateTime();
                    </script>
                </div>

            </div>

            <div class="w-full flex items-center justify-center flex-shrink-0 ">

                <div class="w-full bg-white shadow-lg border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3 p-5 mt-8 mb-10">
                    <p class="text-[30px] font-extrabold header-text mb-5">คะแนนลงไว้ล่าสุด</p>

                    <div>
                        <p class="text-center text-[19px] text-[#000] font-bold">ครั้งที่ 2</p>
                        <div class="flex justify-between items-center mb-3">
                            <p class="text-[16px] text-[#000] font-bold">เบอร์ 1 ชื่อผู้สมัคร</p>
                            <p class="text-[16px] text-[#939393]">50 คะแนน</p>
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <p class="text-[16px] text-[#000] font-bold">เบอร์ 2 ชื่อผู้สมัคร</p>
                            <p class="text-[16px] text-[#939393]">120 คะแนน</p>
                        </div>

                        <div class="flex justify-between items-center mb-3">
                            <p class="text-[16px] text-[#000] font-bold">โดย ธีรศักดิ์</p>
                            <p class="text-[16px] text-[#939393]">เวลา 12.30 น.</p>
                        </div>
                        <hr class="mt-2 mb-3">
                    </div>

                    <div>
                        <p class="text-center text-[19px] text-[#000] font-bold">ครั้งที่ 1</p>
                        <div class="flex justify-between items-center mb-3">
                            <p class="text-[16px] text-[#000] font-bold">เบอร์ 1 ชื่อผู้สมัคร</p>
                            <p class="text-[16px] text-[#939393]">50 คะแนน</p>
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <p class="text-[16px] text-[#000] font-bold">เบอร์ 2 ชื่อผู้สมัคร</p>
                            <p class="text-[16px] text-[#939393]">120 คะแนน</p>
                        </div>

                        <div class="flex justify-between items-center mb-3">
                            <p class="text-[16px] text-[#000] font-bold">โดย ธีรศักดิ์</p>
                            <p class="text-[16px] text-[#939393]">เวลา 12.30 น.</p>
                        </div>
                        <hr class="mt-2 mb-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection