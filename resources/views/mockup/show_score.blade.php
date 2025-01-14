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
                        <p class="text-[33px] font-extrabold header-text">คะแนนผู้สมัคร</p>
                        <!-- <button>aasd</button> -->
                        <div class="bg-white flex flex-col justify-center">
                            <div class="flex items-center justify-center">
                                <div class=" relative inline-block text-left dropdown">
                                    <span class="rounded-md shadow-sm"><button class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800"
                                            type="button" aria-haspopup="true" aria-expanded="true" aria-controls="headlessui-menu-items-117">
                                            <span>ทั้งหมด</span>
                                            <svg class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button></span>
                                    <div class="opacity-0 invisible dropdown-menu transition-all duration-300 transform origin-top-right -translate-y-2 scale-95">
                                        <div class="absolute right-0 w-56 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none" aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
                                            <div class="py-1">
                                                <a href="javascript:void(0)" tabindex="3" class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">เมือง</a>
                                            </div>
                                            <div class="py-1">
                                                <a href="javascript:void(0)" tabindex="3" class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ท่ามะกา</a>
                                            </div>
                                            <div class="py-1">
                                                <a href="javascript:void(0)" tabindex="3" class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ท่าม่วง</a>
                                            </div>
                                            <div class="py-1">
                                                <a href="javascript:void(0)" tabindex="3" class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">พนมทวน</a>
                                            </div>
                                            <div class="py-1">
                                                <a href="javascript:void(0)" tabindex="3" class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ด่านมะข่ามเตี้ย</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
                            .dropdown:focus-within .dropdown-menu {
                                opacity: 1;
                                transform: translate(0) scale(1);
                                visibility: visible;
                            }
                        </style>
                    </div>

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