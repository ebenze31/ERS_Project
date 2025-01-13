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
        background-color: #000;
        font-weight: 600;
        color: #fff;
    }
</style>
<div class="container mx-auto">

    <div class="w-100 h-[calc(100dvh-96px)] mt-[48px] flex justify-center  h-100 overflow-auto  ">
        <div class="block max-w-[800px]  w-full  mt-5">
            <div class="w-full flex items-center justify-center flex-shrink-0 ">
                <div class="w-full bg-white shadow-lg border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3 p-5 ">
                    <p class="text-[33px] font-extrabold header-text">ตรวจสอบข้อมูลหน่วย</p>

                    <div class="mt-5">
                        <p class="text-[14.5px] text-[#939393]">หน่วยเลือกตั้ง</p>
                        <p class="text-[19px] text-[#000] font-bold">เทศบาลเมืองปากแพรก (ยกเว้นหมู่ที่ 1) หน่วยที่ 1</p>
                    </div>
                    <hr class="mt-2 mb-3">

                    <div class="mt-5">
                        <p class="text-[14.5px] text-[#939393]">เขต</p>
                        <p class="text-[19px] text-[#000] font-bold">เมืองกาญจนบุรี เขตเลือกตั้งที่ 1 </p>
                    </div>
                    <hr class="mt-2 mb-3">

                    <div class="mt-5">
                        <p class="text-[14.5px] text-[#939393]">อำเภอ</p>
                        <p class="text-[19px] text-[#000] font-bold">เมืองกาญจนบุรี</p>
                    </div>

                    <hr>

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

                            <label for="email" class="col-md-4 col-form-label text-md-right text-[#939393] text-[14.5px]">{{ __('เบอร์โทร') }} <span class="text-rose-600">*</span></label>
                            <input type="email" id="email" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="email" required autocomplete="email" />
                        </div>
                        <div class="form-group row mt-4 w-1/2 max-sm:w-full ">
                            <label for="email" class="col-md-4 col-form-label text-md-right text-[#939393] text-[14.5px]">{{ __('เบอร์โทร 2 (หากมี)') }}</label>
                            <input type="email" id="email" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="email" autocomplete="email" />
                        </div>
                    </div>
                    <div class="carousel-nav flex justify-end gap-2 pt-2">
                        <a href="#slide-2" data-slide-key="2" class="btn-color max-sm:w-full md:px-6 carousel-nav-next rounded-full bg-dark p-1.5 text-white shadow-sm hover:bg-gray-950 text-center mt-5 focus-visible:outline focus-visible:outline-1 focus-visible:outline-offset-2 focus-visible:outline-gray-200 transition-all duration-300">
                            ยืนยัน
                        </a>
                    </div>
                </div>
                <!-- <a data-slide-key="2" class="h-2 indicator flex-auto text-center text-gray-700 bg-gray-400" href="#slide-2"></a> -->

            </div>

            <div class="w-full flex items-center justify-center flex-shrink-0 ">

                <div class="w-full bg-white shadow-lg border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3 p-5 mt-8 mb-10">
                    <p class="text-[33px] font-extrabold header-text mb-5">คะแนนที่ลงไว้ล่าสุด</p>

                    <div>
                        <p class="text-center text-[19px] text-[#000] font-bold">ครั้งที่ 2</p>
                        <div class="flex justify-between items-center mb-3">
                            <p class="text-[16px] text-[#000] font-bold">เบอร์ 1</p>
                            <p class="text-[16px] text-[#939393]">50</p>
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <p class="text-[16px] text-[#000] font-bold">เบอร์ 2</p>
                            <p class="text-[16px] text-[#939393]">120</p>
                        </div>

                        <div class="flex justify-between items-center mb-3">
                            <p class="text-[16px] text-[#000] font-bold">โดย ธีรศักดิ์</p>
                            <p class="text-[16px] text-[#939393]">12.30 น.</p>
                        </div>
                        <hr class="mt-2 mb-3">
                    </div>

                    <div>
                        <p class="text-center text-[19px] text-[#000] font-bold">ครั้งที่ 1</p>
                        <div class="flex justify-between items-center mb-3">
                            <p class="text-[16px] text-[#000] font-bold">เบอร์ 1</p>
                            <p class="text-[16px] text-[#939393]">50</p>
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <p class="text-[16px] text-[#000] font-bold">เบอร์ 2</p>
                            <p class="text-[16px] text-[#939393]">120</p>
                        </div>

                        <div class="flex justify-between items-center mb-3">
                            <p class="text-[16px] text-[#000] font-bold">โดย ธีรศักดิ์</p>
                            <p class="text-[16px] text-[#939393]">12.30 น.</p>
                        </div>
                        <hr class="mt-2 mb-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection