@extends('layouts.theme_guest')

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


    .swiper-wrapper {
        width: 100%;
        height: max-content !important;
        /* margin-bottom: 64px !important; */
        -webkit-transition-timing-function: linear !important;
        transition-timing-function: linear !important;
        position: relative;
    }

    .swiper-pagination-progressbar .swiper-pagination-progressbar-fill {
        background: #4F46E5 !important;
    }

    main {
        min-height: calc(100dvh - 47.5px);
    }
    @media screen and (max-width: 439px) {
    .banner {
        display: none;
    }
    .banner-mobile {
        display: block;
    }
}
@media screen and (min-width: 439px) {
    .banner {
        display: block;
    }
    .banner-mobile {
        display: none;
    }
}

</style>

<link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<img src="https://www.viicheck.com/img/vote_kan/banner.png"   alt="Logo" class="mb-1 shadow-xl banner">
<img src="https://www.viicheck.com/img/vote_kan/banner_mobile.png"  alt="Logo" class="mb-1 shadow-xl banner-mobile">
<!-- <img src="{{url('/images/2.png')}}" alt="Logo" class="w-full my-1 mt-[48px] shadow-xl"> -->

<div class="max-sm:mx-2 mx-10 max-h-fit">
    <div class="w-100  mt-[10px] flex justify-center  h-100 overflow-auto  ">

        <div class="block  w-full  mt-5">
            <div class="w-full flex items-center justify-center flex-shrink-0 ">

                <div class="w-full bg-white shadow-lg border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3 p-5 mt-0 mb-10">
                    <div class="w-full flex items-center justify-between mb-5">
                        <!-- <p class="text-[30px] font-extrabold header-text">อำเภอเมืองกาญ</p> -->

                        <!--HTML CODE-->
                        <!-- <button>aasd</button> -->
                        <div class="bg-white flex flex-col justify-center">
                            <div class="flex items-center justify-center">
                                <!-- <div class=" relative inline-block text-left dropdown">
                                    <span class="rounded-md shadow-sm">
                                        <button class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800" type="button" aria-haspopup="true" aria-expanded="true" aria-controls="headlessui-menu-items-117">
                                            <span id="selectedText">ทั้งหมด</span>
                                            <svg class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </span>
                                    <div class="opacity-0 invisible dropdown-menu transition-all duration-300 transform origin-top-right -translate-y-2 scale-95">

                                        <div class="z-[99999999] absolute right-0 w-56 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none" aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
                                            <div class="p-3">
                                                <input type="text" id="filterInput" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 " name="sort" placeholder="ค้นหา..." />
                                            </div>

                                            <div id="menuOptions" class=" overflow-auto max-h-[400px]">

                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">เมือง</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ท่ามะกา</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ท่าม่วง</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">พนมทวน</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ด่านมะข่ามเตี้ย</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">เมือง</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ท่ามะกา</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ท่าม่วง</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">พนมทวน</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ด่านมะข่ามเตี้ย</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">เมือง</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ท่ามะกา</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ท่าม่วง</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">พนมทวน</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ด่านมะข่ามเตี้ย</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">เมือง</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ท่ามะกา</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ท่าม่วง</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">พนมทวน</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ด่านมะข่ามเตี้ย</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">เมือง</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ท่ามะกา</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ท่าม่วง</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">พนมทวน</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ด่านมะข่ามเตี้ย</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">เมือง</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ท่ามะกา</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ท่าม่วง</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">พนมทวน</a>
                                                </div>
                                                <div class="py-1">
                                                    <a href="javascript:void(0)" tabindex="3" class="text-gray-700 hover:bg-gray-300 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">ด่านมะข่ามเตี้ย</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>

                        <!-- <script>
                            // กรองรายการใน dropdown
                            document.getElementById('filterInput').addEventListener('input', function() {
                                let filter = this.value.toLowerCase();
                                let menuOptions = document.querySelectorAll('#menuOptions a');

                                menuOptions.forEach(function(option) {
                                    let text = option.textContent.toLowerCase();
                                    option.parentElement.style.display = text.includes(filter) ? '' : 'none';
                                });
                            });

                            // เมื่อเลือกตัวเลือกใน dropdown
                            document.querySelectorAll('#menuOptions a').forEach(function(option) {
                                option.addEventListener('click', function() {
                                    document.getElementById('selectedText').textContent = this.textContent; // เปลี่ยนข้อความที่เลือก
                                });
                            });
                        </script>


                        <style>
                            .dropdown:focus-within .dropdown-menu {
                                opacity: 1;
                                transform: translate(0) scale(1);
                                visibility: visible;
                            }
                        </style> -->
                    </div>
                    <div class="w-full relative">
                        <div class="swiper multiple-slide-carousel swiper-container relative">
                            <div class="swiper-wrapper mb-0">
                                <div class="swiper-slide">
                                    <p class="text-[30px] font-extrabold header-text mb-3 ms-3 text-center">อำเภอเมืองกาญ</p>

                                    <div class="max-sm:block max-md:block max-lg:grid-cols-2  grid grid-cols-3">




                                        <div class="mb-[60px] max-sm:w-full  mx-3 max-sm:mx-0 ">
                                            <div class="card-header flex justify-between items-center bg-[#D9D9D9] p-2 rounded-tl-[10px] rounded-tr-[10px] ">
                                                <span class="font-bold text-[16px]">อำเภอเมือง เขต 1</span>
                                                <a href="#" class="text-[14px] font-bold">เพิ่มเติม</a>
                                            </div>
                                            <div class="card-content bg-[#F4F4F4] py-2 px-4 rounded-bl-[10px] rounded-br-[10px] font-bold h-full">
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
                                            </div>
                                        </div>

                                        <div class="mb-[60px] max-sm:w-full  mx-3 max-sm:mx-0 ">
                                            <div class="card-header flex justify-between items-center bg-[#D9D9D9] p-2 rounded-tl-[10px] rounded-tr-[10px] ">
                                                <span class="font-bold text-[16px]">อำเภอเมือง เขต 1</span>
                                                <a href="#" class="text-[14px] font-bold">เพิ่มเติม</a>
                                            </div>
                                            <div class="card-content bg-[#F4F4F4] py-2 px-4 rounded-bl-[10px] rounded-br-[10px] font-bold h-full">
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
                                            </div>
                                        </div>

                                        <div class="mb-[60px] max-sm:w-full  mx-3 max-sm:mx-0 ">
                                            <div class="card-header flex justify-between items-center bg-[#D9D9D9] p-2 rounded-tl-[10px] rounded-tr-[10px] ">
                                                <span class="font-bold text-[16px]">อำเภอเมือง เขต 1</span>
                                                <a href="#" class="text-[14px] font-bold">เพิ่มเติม</a>
                                            </div>
                                            <div class="card-content bg-[#F4F4F4] py-2 px-4 rounded-bl-[10px] rounded-br-[10px] font-bold h-full">
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
                                            </div>
                                        </div>

                                        <div class="mb-[60px] max-sm:w-full  mx-3 max-sm:mx-0 ">
                                            <div class="card-header flex justify-between items-center bg-[#D9D9D9] p-2 rounded-tl-[10px] rounded-tr-[10px] ">
                                                <span class="font-bold text-[16px]">อำเภอเมือง เขต 1</span>
                                                <a href="#" class="text-[14px] font-bold">เพิ่มเติม</a>
                                            </div>
                                            <div class="card-content bg-[#F4F4F4] py-2 px-4 rounded-bl-[10px] rounded-br-[10px] font-bold h-full">
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
                                            </div>
                                        </div>

                                        <div class="mb-[60px] max-sm:w-full  mx-3 max-sm:mx-0 ">
                                            <div class="card-header flex justify-between items-center bg-[#D9D9D9] p-2 rounded-tl-[10px] rounded-tr-[10px] ">
                                                <span class="font-bold text-[16px]">อำเภอเมือง เขต 1</span>
                                                <a href="#" class="text-[14px] font-bold">เพิ่มเติม</a>
                                            </div>
                                            <div class="card-content bg-[#F4F4F4] py-2 px-4 rounded-bl-[10px] rounded-br-[10px] font-bold h-full">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <style>
                                .swiper-button-prev:after,
                                .swiper-button-next:after {
                                    content: "" !important;
                                }

                                .swiper-button-prev,
                                .swiper-button-next {
                                    width: fit-content !important;
                                    border-radius: 50px;
                                    min-width: 50px;
                                    border-color: #000;
                                }

                                .swiper-button-prev:hover i,
                                .swiper-button-next:hover i {
                                    color: #fff !important;
                                }
                            </style>
                            <div class="absolute flex justify-between items-center m-auto left-0 right-0 w-full top-7">
                                <button id="slider-button-left" style="position: absolute;  top: 50%;  margin-top: -25px;  left: 80px;  transform: translate(-50%, -50%);" class="swiper-button-prev group !p-2 flex justify-center items-center border border-solid border-indigo-600 !w-12 !h-12 transition-all duration-500 hover:bg-black  hover:text-white !-translate-x-16" data-carousel-prev>
                                    <i class="fa-solid fa-chevron-left text-black"></i>
                                </button>
                                <button id="slider-button-right" style="position: absolute;top: 50%;margin-top: -25px;right: 80px;transform: translate(-50%, -50%);" class="swiper-button-next group !p-2 flex justify-center items-center border border-solid border-indigo-600 !w-12 !h-12 transition-all duration-500 hover:bg-black  hover:text-white !translate-x-16" data-carousel-next>
                                    <i class="fa-solid fa-chevron-right text-black"></i>

                                </button>
                            </div>
                        </div>


                        <script>
                            var swiper = new Swiper(".multiple-slide-carousel", {
                                loop: true,
                                spaceBetween: 20,
                                slidesPerView: 1,
                                navigation: {
                                    nextEl: ".multiple-slide-carousel .swiper-button-next",
                                    prevEl: ".multiple-slide-carousel .swiper-button-prev",
                                },
                            });
                        </script>

                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection