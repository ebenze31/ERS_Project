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
                                
                            </div>
                        </div>
                    </div>
                    <div class="w-full relative">
                        <div class="swiper multiple-slide-carousel swiper-container relative">
                            <div class="swiper-wrapper mb-0">

                                <!-- ITEM -->
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

                                <div class="swiper-slide">
                                    <p class="text-[30px] font-extrabold header-text mb-3 ms-3 text-center">อำเภอท่ามะกา</p>

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
                                autoplay: {
                                    delay: 10000,
                                    disableOnInteraction: false,
                                },
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