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
        <div class="block max-w-[1200px]  w-full  mt-5">
            <div class="w-full flex items-center justify-center flex-shrink-0 ">

                <div class="w-full bg-white shadow-lg border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3 p-5 mt-8 mb-10">
                    <div class="w-full flex items-center justify-between mb-5">
                        <p class="text-[30px] font-extrabold header-text">คะแนนผู้สมัคร</p>
                        <!-- <button>aasd</button> -->
                        <div class="bg-white flex flex-col justify-center">
                            <div class="flex items-center justify-center">
                                <div class=" relative inline-block text-left dropdown">
                                    <span class="rounded-md shadow-sm">
                                        <button class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800" type="button" aria-haspopup="true" aria-expanded="true" aria-controls="headlessui-menu-items-117">
                                            <span id="selectedText">ทั้งหมด</span>
                                                <svg class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                        </button>
                                    </span>
                                    <div class="opacity-0 invisible dropdown-menu transition-all duration-300 transform origin-top-right -translate-y-2 scale-95">
                                        <div class="absolute right-0 w-56 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none" aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
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
                                </div>
                            </div>
                        </div>

                        <script>
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
                        </style>
                    </div>
                    <div class="max-sm:block grid grid-cols-2">
                        <div class="mb-4 max-sm:w-full  mx-3 max-sm:mx-0 ">
                            <div class="card-header flex justify-between items-center bg-[#D9D9D9] p-2 rounded-tl-[10px] rounded-tr-[10px] ">
                                <span class="font-bold text-[16px]">อำเภอเมือง เขต 1</span>
                                <a href="#" class="text-[14px] font-bold">เพิ่มเติม</a>
                            </div>
                            <div class="card-content bg-[#F4F4F4] py-2 px-4 rounded-bl-[10px] rounded-br-[10px] font-bold ">
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

                        <div class="mb-4 max-sm:w-full  mx-3 max-sm:mx-0">
                            <div class="card-header flex justify-between items-center bg-[#D9D9D9] p-2 rounded-tl-[10px] rounded-tr-[10px] ">
                                <span class="font-bold text-[16px]">อำเภอเมือง เขต 1</span>
                                <a href="#" class="text-[14px] font-bold">เพิ่มเติม</a>
                            </div>
                            <div class="card-content bg-[#F4F4F4] py-2 px-4 rounded-bl-[10px] rounded-br-[10px] font-bold ">
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

                        <div class="mb-4 max-sm:w-full  mx-3 max-sm:mx-0">
                            <div class="card-header flex justify-between items-center bg-[#D9D9D9] p-2 rounded-tl-[10px] rounded-tr-[10px] ">
                                <span class="font-bold text-[16px]">อำเภอเมือง เขต 1</span>
                                <a href="#" class="text-[14px] font-bold">เพิ่มเติม</a>
                            </div>
                            <div class="card-content bg-[#F4F4F4] py-2 px-4 rounded-bl-[10px] rounded-br-[10px] font-bold ">
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

                        <div class="mb-4 max-sm:w-full  mx-3 max-sm:mx-0">
                            <div class="card-header flex justify-between items-center bg-[#D9D9D9] p-2 rounded-tl-[10px] rounded-tr-[10px] ">
                                <span class="font-bold text-[16px]">อำเภอเมือง เขต 1</span>
                                <a href="#" class="text-[14px] font-bold">เพิ่มเติม</a>
                            </div>
                            <div class="card-content bg-[#F4F4F4] py-2 px-4 rounded-bl-[10px] rounded-br-[10px] font-bold ">
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

                        <div class="mb-4 max-sm:w-full  mx-3 max-sm:mx-0">
                            <div class="card-header flex justify-between items-center bg-[#D9D9D9] p-2 rounded-tl-[10px] rounded-tr-[10px] ">
                                <span class="font-bold text-[16px]">อำเภอเมือง เขต 1</span>
                                <a href="#" class="text-[14px] font-bold">เพิ่มเติม</a>
                            </div>
                            <div class="card-content bg-[#F4F4F4] py-2 px-4 rounded-bl-[10px] rounded-br-[10px] font-bold ">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection