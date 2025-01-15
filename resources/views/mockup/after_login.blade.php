@extends('layouts.theme')

@section('content')
<style>
    .snap-x {
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }

    .snap-start {
        scroll-snap-align: start;
    }.bg-dark{
        background-color: #000;
    }
</style>
<!-- <div class="flex flex-col items-center m-6 text-white font-bold uppercase">
    <div class="w-full rounded overflow-x-hidden flex snap-x slider-parent" style="height: auto !important">
        <div class="snap-start w-full flex items-center justify-center flex-shrink-0 " id="slide-1" style="height: 150px !important;">
            <div class="w-full">
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

                <div class="carousel-nav flex justify-end gap-2 pt-2">
                    <a href="#slide-2" data-slide-key="2" class="max-sm:w-full md:px-6 carousel-nav-next rounded-full bg-gray-200 p-1.5 text-gray-600 shadow-sm hover:bg-gray-300 focus-visible:outline focus-visible:outline-1 focus-visible:outline-offset-2 focus-visible:outline-gray-200 transition-all duration-300">
                        ถัดไป
                    </a>
                </div>
            </div>
            <a data-slide-key="2" class="h-2 indicator flex-auto text-center text-gray-700 bg-gray-400" href="#slide-2"></a>

        </div>
        <div class="snap-start w-full h-full flex items-center justify-center flex-shrink-0 bg-green-600" id="slide-2" style="height: 450px !important;">
            Slide 2
        </div>
    </div>
</div> -->
<div class="container mx-auto">

    <div class="w-100 h-[calc(100dvh-96px)] mt-[48px] flex justify-center items-center h-100">
        <div class="block max-w-[800px]  w-full  ">
            <div class="w-full rounded overflow-x-hidden flex snap-x slider-parent">
                <div class="snap-start w-full flex items-center justify-center flex-shrink-0 " id="slide-1">
                    <div class="w-full bg-white shadow-lg border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3 p-5 ">
                        <p class="text-[33px] font-extrabold header-text">ตรวจสอบข้อมูลหน่วย</p>

                        <div class="mt-5">
                            <p class="text-[14.5px] text-[#939393]">อำเภอ</p>
                            <p class="text-[19px] text-[#000] font-bold">เมืองกาญจนบุรี</p>
                        </div>   
                        <hr class="mt-2 mb-3">

                        <div class="mt-5">
                            <p class="text-[14.5px] text-[#939393]">เขต</p>
                            <p class="text-[19px] text-[#000] font-bold">เมืองกาญจนบุรี เขตเลือกตั้งที่ 1 </p>
                        </div>
                        <hr class="mt-2 mb-3">

                        <div class="mt-5">
                            <p class="text-[14.5px] text-[#939393]">ตำบล</p>
                            <p class="text-[19px] text-[#000] font-bold">แก่งเสี้ยน</p>
                        </div>
                        <hr class="mt-2 mb-3">

                        <div class="mt-5">
                            <p class="text-[14.5px] text-[#939393]">หน่วยเลือกตั้ง</p>
                            <p class="text-[19px] text-[#000] font-bold">1</p>
                        </div>
                     
                        <hr class="mt-2 mb-3">

                      

                        <div class="carousel-nav flex justify-end gap-2 pt-2">
                            <a href="#slide-2" data-slide-key="2" class="btn-color max-sm:w-full md:px-6 carousel-nav-next rounded-full bg-dark p-1.5 text-white shadow-sm hover:bg-gray-950 text-center mt-5 focus-visible:outline focus-visible:outline-1 focus-visible:outline-offset-2 focus-visible:outline-gray-200 transition-all duration-300">
                                ถัดไป
                            </a>
                        </div>
                    </div>
                    <!-- <a data-slide-key="2" class="h-2 indicator flex-auto text-center text-gray-700 bg-gray-400" href="#slide-2"></a> -->

                </div>
                <div class="snap-start w-full h-full flex items-center justify-center flex-shrink-0 " id="slide-2">
                    <div class="w-full bg-white shadow-lg border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3 p-5 ">
                        <p class="text-[47px] font-extrabold header-text">กรอกข้อมูลของคุณ</p>
                        <form method="POST" action="{{ route('login') }}" class="mt-2">
                            @csrf

                            <div class="form-group row">

                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อ-นามสกุล') }} <span class="text-rose-600">*</span></label>
                                <input type="email" id="email" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="email" required autocomplete="email" />
                            </div>
                            <div class="max-sm:block flex">


                                <div class="form-group row mt-4 w-1/2 max-sm:w-full me-2 ">

                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('เบอร์โทร') }} <span class="text-rose-600">*</span></label>
                                    <input type="email" id="email" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="email" required autocomplete="email" />
                                </div>
                                <div class="form-group row mt-4 w-1/2 max-sm:w-full ">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('เบอร์โทร 2 (หากมี)') }}</label>
                                    <input type="email" id="email" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="email" autocomplete="email" />
                                </div>
                            </div>
                            <div class="carousel-nav flex justify-end gap-2 pt-5">
                                <a a href="#slide-1" data-slide-key="1" class="max-sm:w-1/3 text-center md:px-6 carousel-nav-next rounded-full  p-1.5 text-dark focus-visible:outline focus-visible:outline-1 focus-visible:outline-offset-2 focus-visible:outline-gray-200 transition-all duration-300">
                                    <i class="fa-solid fa-arrow-left"></i> กลับ
                                </a>

                                <button type="button" class="btn-color max-sm:w-full md:px-6 carousel-nav-next rounded-full bg-gray-200 p-1.5 text-gray-600 shadow-sm hover:bg-gray-300 focus-visible:outline focus-visible:outline-1 focus-visible:outline-offset-2 focus-visible:outline-gray-200 transition-all duration-300">
                                    ยืนยัน
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="flex justify-center items-center h-full p-4 pt-0 hidden">
                <div class="carousel relative w-full ">
                    <div class="overflow-hidden rounded-xl">
                        <div class="carousel-slides relative w-full flex gap-6 snap-x snap-mandatory scroll-smooth overflow-x-auto -mb-10 pt-2 pb-7 px-2">
                            <div class="snap-always snap-center shrink-0 relative overflow-hidden  w-full rounded-lg flex items-center ">
                                <div class="w-full">
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

                                    <div class="carousel-nav flex justify-end gap-2 pt-2">
                                        <button type="button" class="max-sm:w-full md:px-6 carousel-nav-next rounded-full bg-gray-200 p-1.5 text-gray-600 shadow-sm hover:bg-gray-300 focus-visible:outline focus-visible:outline-1 focus-visible:outline-offset-2 focus-visible:outline-gray-200 transition-all duration-300">
                                            ถัดไป
                                        </button>
                                    </div>
                                </div>

                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>
            <!-- <p class="text-[47px] font-extrabold header-text">Login</p>
            <form method="POST" action="{{ route('login') }}" class="mt-2">
                @csrf

                <div class="form-group row">
                    
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>
                    <input type="email" id="email" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="email" required autocomplete="email" autofocus/>
                </div>
                <div class="form-group row mt-4">
                    
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                    <input type="email" id="email" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="email" required autocomplete="email" autofocus/>
                </div>

         
                <div class="flex w-100 my-2 mt-5">
                    <button type="submit" class="btn rounded-full bg-slate-950 w-full text-white p-2 ">Login</button>
                </div>
            </form> -->

        </div>
    </div>
</div>

@endsection