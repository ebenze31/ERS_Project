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
<div class="container mx-auto">

    <div class="w-100 h-[calc(100dvh-96px)] mt-[48px] flex justify-center items-center h-100">
        <div class="block max-w-[800px]  w-full  ">
            <div class="w-full rounded overflow-x-hidden flex snap-x slider-parent">
                <div class="snap-start w-full flex items-center justify-center flex-shrink-0 " id="slide-1">
                    <div class="w-full bg-white shadow-lg border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3 p-5 ">
                        <p class="text-[30px] font-extrabold header-text">ตรวจสอบข้อมูลหน่วย</p>

                        <div class="mt-5">
                            <p class="text-[14.5px] text-[#939393]">อำเภอ</p>
                            <p class="text-[19px] text-[#000] font-bold">{{ $data_polling_units->name_district }}</p>
                        </div>   
                        <hr class="mt-2 mb-3">

                        <div class="mt-5">
                            <p class="text-[14.5px] text-[#939393]">เขตเลือกตั้งที่</p>
                            <p class="text-[19px] text-[#000] font-bold">{{ $data_polling_units->name_electorate }}</p>
                        </div>
                        <hr class="mt-2 mb-3">

                        <div class="mt-5">
                            <p class="text-[14.5px] text-[#939393]">ตำบล</p>
                            <p class="text-[19px] text-[#000] font-bold">{{ explode(" ",$data_polling_units->name_polling_unit)[0] }}</p>
                        </div>
                        <hr class="mt-2 mb-3">

                        <div class="mt-5">
                            <p class="text-[14.5px] text-[#939393]">หน่วยเลือกตั้งที่</p>
                            <p class="text-[19px] text-[#000] font-bold">{{ explode(" ",$data_polling_units->name_polling_unit)[2] }}</p>
                        </div>
                     
                        <hr class="mt-2 mb-3">

                      

                        <div class="carousel-nav flex justify-end gap-2 pt-2">
                            <a href="#slide-2" data-slide-key="2" class="btn-color max-sm:w-full md:px-6 carousel-nav-next rounded-full bg-dark p-1.5 text-white shadow-sm hover:bg-gray-950 text-center mt-5 focus-visible:outline focus-visible:outline-1 focus-visible:outline-offset-2 focus-visible:outline-gray-200 transition-all duration-300">
                                ถัดไป
                            </a>
                        </div>
                    </div>

                </div>
                <div class="snap-start w-full h-full flex items-center justify-center flex-shrink-0 " id="slide-2">
                    <div class="w-full bg-white shadow-lg border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3 p-5 ">
                        <p class="text-[30px] font-extrabold header-text">กรอกข้อมูลของคุณ</p>
                        <form method="POST" action="{{ route('login') }}" class="mt-2">
                            @csrf

                            <div class="form-group row">

                                <label for="name_officer" class="col-md-4 col-form-label text-md-right">
                                    {{ __('ชื่อ-นามสกุล') }} <span class="text-rose-600 text-[12px]">*จำเป็นต้องใส่</span>
                                </label>
                                <input type="text" id="name_officer" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 " name="name_officer" required >
                            </div>
                            <div class="max-sm:block flex">


                                <div class="form-group row mt-4 w-1/2 max-sm:w-full me-2 ">

                                    <label for="phone_1" class="col-md-4 col-form-label text-md-right">
                                        {{ __('เบอร์โทร') }} <span class="text-rose-600 text-[12px]">*จำเป็นต้องใส่</span>
                                    </label>
                                    <input type="phone" id="phone_1" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 " name="phone_1" required >
                                </div>
                                <div class="form-group row mt-4 w-1/2 max-sm:w-full ">
                                    <label for="phone_2" class="col-md-4 col-form-label text-md-right">{{ __('เบอร์โทร 2') }}</label>
                                    <input type="phone" id="phone_2" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 " name="phone_2" autocomplete="phone_2" />
                                </div>
                            </div>
                            <div class="carousel-nav flex justify-end gap-2 pt-5">
                                <a a href="#slide-1" data-slide-key="1" class="max-sm:w-1/3 text-center md:px-6 carousel-nav-next rounded-full  p-1.5 text-dark focus-visible:outline focus-visible:outline-1 focus-visible:outline-offset-2 focus-visible:outline-gray-200 transition-all duration-300">
                                    <i class="fa-solid fa-arrow-left"></i> กลับ
                                </a>

                                <button type="button" class="btn-color max-sm:w-full md:px-6 carousel-nav-next rounded-full bg-gray-200 p-1.5 text-gray-600 shadow-sm hover:bg-gray-300 focus-visible:outline focus-visible:outline-1 focus-visible:outline-offset-2 focus-visible:outline-gray-200 transition-all duration-300" onclick="CF_data();">
                                    ยืนยัน
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function CF_data(){
        let name_officer = document.querySelector('#name_officer').value;
        let phone_1 = document.querySelector('#phone_1').value;
        let phone_2 = document.querySelector('#phone_2').value;
            // console.log(name_officer);
            // console.log(phone_1);
            // console.log(phone_2);

        let data_arr = [] ;
        data_arr = {
            "user_id" : "{{ Auth::user()->id }}",
            "name_officer" : name_officer,
            "phone_1" : phone_1,
            "phone_2" : phone_2,
        };

        fetch("{{ url('/') }}/api/save_user_polling_units", {
            method: 'post',
            body: JSON.stringify(data_arr),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function (response){
            return response.text();
        }).then(function(data){
            console.log(data);
            if (data == "SUCCESS") {
                window.location.href = "{{ url('/') }}" + "/add_score";
            }else{
                // console.log("บันทึกข้อมูลเรียบร้อย");
            }
        }).catch(function(error){
            // console.error(error);
        });
    }
</script>

@endsection