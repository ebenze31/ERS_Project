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

                <div class="w-full bg-white shadow-lg border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3 p-5 mt-8 mb-10">
                    <div class="w-full flex items-center justify-between mb-5">
                        <p class="text-[20px] font-extrabold header-text">คะแนนผู้สมัครอำเภอเมือง เขต 1</p>
                    </div>
                    <div class="mb-4">
                        <div class="card-content bg-[#F4F4F4] py-2 px-4 rounded-[10px] font-bold ">
                            <div class="flex justify-between items-center my-2">
                                <div>

                                    <div class="flex items-center">
                                        <img src="https://www.viicheck.com/img/stickerline/PNG/1.png" alt="Logo" class="h-[42px] w-[42px] my-1 me-2 rounded-full shadow-xl object-cover">
                                        <div>
                                            <span>นายสมชาย</span>

                                            <div class="flex items-center">
                                                <img src="https://www.viicheck.com/img/logo/profileLine3D.png" alt="Logo" class="h-[20px] my-1 me-2">

                                                <p class="text-[14px]">พรรควีเช็ค</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-[#27B004] text-[24px]">
                                    904
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p>นายสมชาย</p>
                                    <div class="flex items-center">
                                        <img src="https://www.viicheck.com/img/logo/profileLine3D.png" alt="Logo" class="h-[20px] my-1 me-2">

                                        <p class="text-[14px]">พรรควีเช็ค</p>
                                    </div>
                                </div>
                                <div class="text-[#4B4B4B] text-[16px]">
                                    685
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p>นายสมชาย</p>
                                    <div class="flex items-center">
                                        <img src="https://www.viicheck.com/img/logo/profileLine3D.png" alt="Logo" class="h-[20px] my-1 me-2">

                                        <p class="text-[14px]">พรรควีเช็ค</p>
                                    </div>
                                </div>
                                <div class="text-[#4B4B4B] text-[16px]">
                                    685
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p>นายสมชาย</p>
                                    <div class="flex items-center">
                                        <img src="https://www.viicheck.com/img/logo/profileLine3D.png" alt="Logo" class="h-[20px] my-1 me-2">

                                        <p class="text-[14px]">พรรควีเช็ค</p>
                                    </div>
                                </div>
                                <div class="text-[#4B4B4B] text-[16px]">
                                    685
                                </div>
                            </div>
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </div>
</div>

@endsection