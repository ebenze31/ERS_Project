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

<img src="{{ url('storage')}}/{{ $data_provinces->banner }}"   alt="Logo" class="mb-1 shadow-xl banner">
<img src="{{ url('storage')}}/{{ $data_provinces->banner_mobile }}"  alt="Logo" class="mb-1 shadow-xl banner-mobile">
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
                            <div id="div_item_carousel" class="swiper-wrapper mb-0">
                                <!-- ITEM -->
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

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            get_data_scores();
        });

        function get_data_scores(){

            fetch("{{ url('/') }}/api/get_data_districts/"+ "{{ $data_provinces->id }}")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network ตอบสนองไม่ OK " + response.statusText);
                }
                return response.json();
            })
            .then(result => {
                // console.log(result);

                if(result){

                    let div_item_carousel = document.querySelector('#div_item_carousel');
                        div_item_carousel.innerHTML = "";
                    
                    let check_name_district = "" ;
                    for (let i = 0; i < result.length; i++) {

                        if(check_name_district != result[i].name_district){
                            check_name_district = result[i].name_district
                            let html_head = `
                                <div class="swiper-slide">
                                    <p class="text-[30px] font-extrabold header-text mb-3 ms-3 text-center">
                                        `+result[i].name_district+`
                                    </p>
                                    <div name_district="`+result[i].name_district+`" class="max-sm:block max-md:block max-lg:grid-cols-2  grid grid-cols-3">
                                    </div>
                                </div>
                            `;
                            div_item_carousel.insertAdjacentHTML('beforeend', html_head); // แทรกล่างสุด
                        }

                        fetch("{{ url('/') }}/api/get_data_scores/"+ result[i].district_id)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("Network ตอบสนองไม่ OK " + response.statusText);
                            }
                            return response.json();
                        })
                        .then(data_scores => {
                            // จัดเรียงข้อมูลโดย name_electorate ก่อน และตามด้วย sum_score
                            data_scores.sort((a, b) => {
                                // เรียงตาม name_electorate (จากน้อยไปมาก)
                                const electorateComparison = a.name_electorate.localeCompare(b.name_electorate, 'th', { numeric: true });
                                if (electorateComparison !== 0) {
                                    return electorateComparison;
                                }

                                // หาก name_electorate เท่ากัน เรียงตาม sum_score (จากมากไปน้อย)
                                const scoreA = a.sum_score === null ? 0 : a.sum_score;
                                const scoreB = b.sum_score === null ? 0 : b.sum_score;

                                return scoreB - scoreA;
                            });

                            // console.log(data_scores);

                            let check_name_district = "" ;
                            let check_name_electorate = "" ;
                            let old_electorate = "" ;

                            if(data_scores){
                                for (let xi = 0; xi < data_scores.length; xi++) {
                                    // console.log(data_scores[xi].name_district);
                                    // console.log(data_scores[xi].name_electorate);

                                    let div_name_district = document.querySelector('div[name_district="' + data_scores[xi].name_district + '"]');

                                    let text_check_div = data_scores[xi].name_district + '_' + data_scores[xi].name_electorate ;
                                    let check_div = document.querySelector('div[div_district="'+text_check_div+'"]');

                                    if(check_div){
                                        // ไม่ทำอะไร
                                    }
                                    else{

                                        check_name_district = data_scores[xi].name_district;
                                        check_name_electorate = data_scores[xi].name_electorate;

                                        let html_district = `
                                            <div class="mb-[60px] max-sm:w-full  mx-3 max-sm:mx-0 ">
                                                <div class="card-header flex justify-between items-center bg-[#D9D9D9] p-2 rounded-tl-[10px] rounded-tr-[10px] ">
                                                    <span class="font-bold text-[16px]">
                                                        อำเภอ`+data_scores[xi].name_district+` เขต `+data_scores[xi].name_electorate+`
                                                    </span>
                                                </div>
                                                <div div_district="`+data_scores[xi].name_district+`_`+data_scores[xi].name_electorate+`" class="card-content bg-[#F4F4F4] py-2 px-4 rounded-bl-[10px] rounded-br-[10px] font-bold h-full">

                                                </div>
                                            </div>
                                        `;
                                        div_name_district.insertAdjacentHTML('beforeend', html_district); // แทรกล่างสุด
                                    }

                                    let div_district = document.querySelector('div[div_district="'+text_check_div+'"]');
                                    let formattedScore
                                    let photo = "";
                                    if(data_scores[xi].img_candidate){
                                        photo = "{{ url('storage')}}/" + data_scores[xi].img_candidate;
                                    }else{
                                        photo = data_scores[xi].img_url_candidate;
                                    }

                                    let name_candidate = "";
                                    if(data_scores[xi].show_parties == "Yes"){
                                        name_candidate = `
                                            <div class="flex">
                                                <img src="https://www.viicheck.com/img/logo/profileLine3D.png"  class="h-[20px] my-1 me-2">
                                                <p>`+data_scores[xi].name_candidate+`</p>
                                            </div>
                                        `;
                                    }else{
                                         name_candidate = `
                                            <p>`+data_scores[xi].name_candidate+`</p>
                                        `;
                                    }

                                    if(!data_scores[xi].sum_score){
                                        formattedScore = 0 ;
                                    }else{
                                        formattedScore = Number(data_scores[xi].sum_score).toLocaleString();
                                    }

                                    if( data_scores[xi].sum_score && old_electorate != data_scores[xi].name_electorate){
                                        old_electorate = data_scores[xi].name_electorate;
                                        let html_candidate_leader = `
                                            <div class="flex justify-between items-center my-2">
                                                <div>
                                                    <div class="flex items-center">
                                                        <div class="w-[80px]">
                                                            <p class="text-[35px] text-[#27B004]">No.${data_scores[xi].number_candidate}</p>
                                                        </div>
                                                        <img src="`+photo+`" class="h-[60px] max-w-[60px] my-1 me-2 shadow-xl object-contain">
                                                        <div>
                                                        <div class="ms-3 items-center">
                                                            `+name_candidate+`
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-[#27B004] text-[24px]">
                                                    `+formattedScore+`
                                                </div>
                                            </div>
                                            <hr class="my-3">
                                        `;

                                        div_district.insertAdjacentHTML('beforeend', html_candidate_leader); // แทรกล่างสุด
                                    }
                                    else{
                                        let html_candidate = `
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <div class="w-[50px]">
                                                        <p class="text-[22px] ">No.${data_scores[xi].number_candidate}</p>
                                                    </div>
                                                    <div class="ms-3">
                                                        `+name_candidate+`
                                                    </div>
                                                    
                                                </div>
                                                <div class="text-[#4B4B4B] text-[16px]">
                                                    `+formattedScore+`
                                                </div>
                                            </div>
                                            <hr class="my-3">
                                        `;

                                        div_district.insertAdjacentHTML('beforeend', html_candidate); // แทรกล่างสุด
                                        
                                    }

                                }
                            }

                        }).catch(error => {
                            console.error('Error:', error);
                        });
                    }

                }

            }).catch(error => {
                console.error('Error:', error);
            });
        }
    </script>

    @endsection