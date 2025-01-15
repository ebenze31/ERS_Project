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

    .swiper-wrapper {
        width: 100%;
        height: max-content !important;
        padding-bottom: 64px !important;
        -webkit-transition-timing-function: linear !important;
        transition-timing-function: linear !important;
        position: relative;
    }

    .swiper-pagination-progressbar .swiper-pagination-progressbar-fill {
        background: #4F46E5 !important;
    }
</style>

<div class="container mx-auto h-[calc(100dvh-96px)]">
    <img src="https://www.viicheck.com/img/vote_kan/banner.png" alt="Logo" class=" w-full my-1 me-2 mt-[48px] shadow-xl object-cover">

    <div class="w-100  mt-[48px] flex justify-center  h-100 overflow-auto  ">
        <div class="block  w-full  mt-5">
            <div class="w-full flex items-center justify-center flex-shrink-0 ">

                <div class="w-full bg-white shadow-lg border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3 p-5 mt-8 mb-10">
                    <div class="w-full flex items-center justify-between mb-5">
                        <p class="text-[20px] font-extrabold header-text">คะแนนผู้สมัครอำเภอเมือง เขต 1</p>
                    </div>
                    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
                    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

                    <!--HTML CODE-->
                    <div class="w-full relative">
                        <div class="swiper progress-slide-carousel swiper-container relative">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="bg-indigo-50 rounded-2xl h-96 flex justify-center items-center">
                                        <span class="text-3xl font-semibold text-indigo-600">Slide 1 </span>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="bg-indigo-50 rounded-2xl h-96 flex justify-center items-center">
                                        <span class="text-3xl font-semibold text-indigo-600">Slide 2 </span>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="bg-indigo-50 rounded-2xl h-96 flex justify-center items-center">
                                        <span class="text-3xl font-semibold text-indigo-600">Slide 3 </span>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="bg-indigo-50 rounded-2xl h-96 flex justify-center items-center">
                                        <span class="text-3xl font-semibold text-indigo-600">Slide 1 </span>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="bg-indigo-50 rounded-2xl h-96 flex justify-center items-center">
                                        <span class="text-3xl font-semibold text-indigo-600">Slide 2 </span>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="bg-indigo-50 rounded-2xl h-96 flex justify-center items-center">
                                        <span class="text-3xl font-semibold text-indigo-600">Slide 3 </span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-pagination !bottom-2 !top-auto !w-80 right-0 mx-auto bg-gray-100"></div>
                        </div>
                    </div>

                    <script>
                        var swiper = new Swiper(".progress-slide-carousel", {
                            loop: true,
                            fraction: true,
                            slidesPerView: 3,
                            autoplay: {
                                delay: 3000,
                                disableOnInteraction: false,
                            },
                            pagination: {
                                el: ".progress-slide-carousel .swiper-pagination",
                                type: "progressbar",
                            },
                        });
                    </script>
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