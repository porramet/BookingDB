@extends('layouts.app')

@section('content')
<!-- Main Container -->
<div class="mt-40 mb-40 container mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- ฟอร์มจองห้องพัก -->
    <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-semibold mb-4">
            ผู้เข้าพักคนหลัก <span class="text-red-600">*</span>
        </h2>
        
        <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->room_id }}">
            <input type="hidden" name="building_id" value="{{ $room->building_id }}">
            <input type="hidden" name="room_name" value="{{ $room->room_name }}"> <!-- ✅ เพิ่ม -->
            <input type="hidden" name="building_name" value="{{ $room->building->building_name ?? 'ไม่ระบุ' }}"> <!-- ✅ เพิ่ม --> 
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <!-- ชื่ออาคาร -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">อาคาร</label>
                <input class="mt-1 block w-full border rounded-md p-2 bg-gray-100" 
                    type="text" value="{{ $room->building->building_name ?? 'ไม่ระบุ' }}" readonly>
            </div>
            <!-- ห้องที่จอง -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">ห้องที่จอง</label>
                <input class="mt-1 block w-full border rounded-md p-2 bg-gray-100" 
                    type="text" value="{{ $room->room_name }}" readonly>
            </div>
            <!-- ชื่อผู้จอง -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">ชื่อผู้จอง</label>
                <input class="mt-1 block w-full border rounded-md p-2" 
                    name="external_name" type="text" required>
            </div>

            <!-- อีเมล -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">อีเมล</label>
                <input class="mt-1 block w-full border rounded-md p-2" 
                    name="external_email" type="email" required>
            </div>

            <!-- เบอร์โทร -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">เบอร์โทร</label>
                <input class="mt-1 block w-full border rounded-md p-2" 
                    name="external_phone" type="text" required>
            </div>

            <!-- เหตุผลในการจอง -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">เหตุผลในการจอง</label>
                <textarea name="reason" class="mt-1 block w-full border rounded-md p-2" rows="3"></textarea>
            </div>

            <!-- วันที่จอง -->
            <div class="bg-white p-4 rounded-lg shadow-md text-center">
                <div class="flex justify-center space-x-4 mb-4" id="selectedDates">
                    <div>
                        <div class="text-lg font-semibold" id="checkInDate">กรุณาเลือกวันเช็คอิน</div>
                        <div class="text-sm text-gray-500">เช็คอิน</div>
                    </div>
                    <div class="text-2xl font-semibold">→</div>
                    <div>
                        <div class="text-lg font-semibold" id="checkOutDate">กรุณาเลือกวันเช็คเอาท์</div>
                        <div class="text-sm text-gray-500">เช็คเอาท์</div>
                    </div>
                </div>

                <button id="toggleCalendar" type="button" class="bg-blue-500 text-white px-4 py-2 rounded-lg">เลือกวันจอง</button>
                <input type="hidden" name="booking_start" id="booking_start">
                <input type="hidden" name="booking_end" id="booking_end">
                <!-- แสดงข้อมูลวันหยุด -->
                <div class="mt-4 text-left">
                    <div class="text-sm font-medium text-gray-700 mb-2">หมายเหตุ:</div>
                    <div class="flex items-center mb-1">
                        <div class="w-4 h-4 bg-yellow-200 rounded-full mr-2"></div>
                        <span class="text-sm">วันหยุดนักขัตฤกษ์ (ไม่สามารถจองได้)</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-200 rounded-full mr-2"></div>
                        <span class="text-sm">วันที่มีการจองแล้ว (ไม่สามารถจองได้)</span>
                    </div>
                </div>
            </div>
            
            <!-- ปุ่มยืนยันการจอง -->
            <div class="flex justify-between mt-4">
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg">ยกเลิก</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">ยืนยันการจอง</button>
            </div>
        </form>
    </div>

    <!-- ส่วนแสดงข้อมูลห้องและสรุปราคาการจอง -->
    <div class="lg:col-span-1">
        <!-- ข้อมูลห้อง -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-lg font-semibold mb-4">ข้อมูลห้องพัก</h2>
            
            <!-- รูปภาพห้อง -->
            <div class="mb-4">
                @if(isset($room->image))
                    <img src="{{ asset($room->image) }}" alt="{{ $room->room_name }}" class="w-full h-48 object-cover rounded-lg">
                @else
                    <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500">ไม่มีรูปภาพ</span>
                    </div>
                @endif
            </div>
            
            <!-- รายละเอียดห้อง -->
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-700">อาคาร:</span>
                    <span>{{ $room->building->building_name ?? 'ไม่ระบุ' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">ชื่อห้อง:</span>
                    <span class="font-semibold">{{ $room->room_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">ชั้น:</span>
                    <span>{{ $room->class }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">ความจุ:</span>
                    <span>{{ $room->capacity ?? '-' }} คน</span>
                </div>
                <div class="mt-4">
                    <span class="text-gray-700">รายละเอียด:</span>
                    <p class="mt-2 text-sm">{{ $room->room_details }}</p>
                </div>
            </div>
        </div>

        <!-- สรุปราคาการจอง -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold mb-4">สรุปการจอง</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-700">อัตราค่าบริการ:</span>
                    <span class="font-semibold">{{ number_format($room->service_rates ?? 0, 2) }} บาท/วัน</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-700">จำนวนวัน:</span>
                    <span id="totalDays">0 วัน</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-700">ค่าบริการทั้งหมด:</span>
                    <span id="serviceFee">0 บาท</span>
                </div>
                
                <hr class="my-2 border-gray-200">
                
                <div class="flex justify-between text-lg font-bold">
                    <span>ราคารวมทั้งสิ้น:</span>
                    <span id="totalPrice">0 บาท</span>
                </div>
                
                <div class="mt-4 p-3 bg-blue-50 rounded-lg text-sm">
                    <p class="text-blue-800">
                        <span class="font-semibold">หมายเหตุ:</span> ราคาอาจมีการเปลี่ยนแปลงตามนโยบายและระยะเวลาที่จอง
                    </p>
                </div>
            </div>
        </div>
    </div>   
</div>

<!-- Litepicker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css">
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>

<style>
    /* ปรับ tooltip ให้แสดงบนปฏิทิน */
    .litepicker .day-item[data-tooltip] {
        position: relative;
    }
    
    .litepicker .day-item[data-tooltip]:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 10;
    }

    /* สีสำหรับวันหยุด */
    .litepicker .day-item.is-holiday {
        background-color: #fef08a !important; /* yellow-200 */
        color: #854d0e !important; /* yellow-800 */
        font-weight: bold;
        cursor: not-allowed !important;
    }

    /* สีสำหรับวันจองแล้ว */
    .litepicker .day-item.is-booked {
        background-color: #bfdbfe !important; /* blue-200 */
        color: #1e40af !important; /* blue-800 */
        cursor: not-allowed !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookingStart = document.getElementById('booking_start');
        const bookingEnd = document.getElementById('booking_end');
        const checkInDate = document.getElementById('checkInDate');
        const checkOutDate = document.getElementById('checkOutDate');
        const toggleButton = document.getElementById('toggleCalendar');
        const totalDays = document.getElementById('totalDays');
        const serviceFee = document.getElementById('serviceFee');
        const totalPrice = document.getElementById('totalPrice');
    
        // ข้อมูลราคา
        const serviceRate = {{ $room->service_rates ?? 0 }};
    
        // ข้อมูลวันหยุดและวันที่ถูกจอง
        const holidaysWithNames = @json($holidaysWithNames);
        const holidays = Object.keys(holidaysWithNames);
        const bookedDetails = @json($bookedDetails);
        const bookedDays = Object.keys(bookedDetails);
    
        const picker = new Litepicker({
            element: toggleButton,
            singleMode: false,
            numberOfMonths: 2,
            numberOfColumns: 2,
            format: 'D MMM YYYY',
            lang: "th-TH",
            autoApply: true,
            minDate: new Date(),
            allowSingleDayRange: true, // อนุญาตให้เลือกวันเดียวได้
            tooltipText: {
                one: 'วัน',
                other: 'วัน'
            },
            lockDaysFilter: (date) => {
                const formattedDate = date.format('YYYY-MM-DD');
                return bookedDays.includes(formattedDate) || holidays.includes(formattedDate);
            },
            setup: (picker) => {
                picker.on('render', () => {
                    // วันที่ถูกเลือกในปัจจุบัน
                    const selectedStart = bookingStart.value ? new Date(bookingStart.value) : null;
                    const selectedEnd = bookingEnd.value ? new Date(bookingEnd.value) : null;
    
                    document.querySelectorAll('.container__days .day-item').forEach(day => {
                        const date = day.getAttribute('data-time');
                        if (date) {
                            const dateObj = new Date(parseInt(date));
                            const formattedDate = dateObj.toISOString().split('T')[0];
    
                            // รีเซ็ตคลาสก่อน
                            day.classList.remove('is-selected');
    
                            // ไฮไลต์ช่วงวันที่เลือก
                            if (selectedStart && selectedEnd && dateObj >= selectedStart && dateObj <= selectedEnd) {
                                day.classList.add('is-selected');
                            }
    
                            // แสดง tooltip และล็อกวันที่ที่ไม่สามารถเลือกได้
                            if (holidays.includes(formattedDate)) {
                                day.classList.add('is-holiday', 'is-locked');
                                day.setAttribute('data-tooltip', holidaysWithNames[formattedDate]);
                            }
                            if (bookedDays.includes(formattedDate)) {
                                day.classList.add('is-booked', 'is-locked');
                                day.setAttribute('data-tooltip', bookedDetails[formattedDate]);
                            }
                        }
                    });
                });
    
                picker.on('selected', (date1, date2) => {
                    // รีเซ็ตไฮไลต์ก่อน
                    document.querySelectorAll('.day-item').forEach(day => {
                        day.classList.remove('is-selected');
                    });
    
                    // อัปเดตค่าฟอร์ม
                    bookingStart.value = date1.format('YYYY-MM-DD');
                    bookingEnd.value = date2 ? date2.format('YYYY-MM-DD') : date1.format('YYYY-MM-DD');
                    checkInDate.innerText = date1.format('D MMM YYYY');
                    checkOutDate.innerText = date2 ? date2.format('D MMM YYYY') : date1.format('D MMM YYYY');
    
                    // คำนวณจำนวนวัน
                    let days = 1;
                    if (date2) {
                        const oneDay = 24 * 60 * 60 * 1000;
                        const firstDate = new Date(date1.format('YYYY-MM-DD'));
                        const secondDate = new Date(date2.format('YYYY-MM-DD'));
                        days = Math.round(Math.abs((secondDate - firstDate) / oneDay)) + 1;
                    }
    
                    totalDays.innerText = days + ' วัน';
                    const totalServiceFee = days * serviceRate;
                    serviceFee.innerText = numberWithCommas(totalServiceFee.toFixed(2)) + ' บาท';
                    totalPrice.innerText = numberWithCommas(totalServiceFee.toFixed(2)) + ' บาท';
    
                    // บังคับให้ Litepicker อัปเดต
                    picker.render();
                });
            }
        });
    
        // โหลดค่าจาก input ถ้ามี
        if (bookingStart.value && bookingEnd.value) {
    // แปลงวันที่ให้เป็น local time เพื่อแก้ปัญหา timezone
    let startDate = new Date(bookingStart.value + 'T00:00:00');
    let endDate = new Date(bookingEnd.value + 'T23:59:59');

    // ตรวจสอบให้แน่ใจว่า Litepicker ได้รับค่าที่ถูกต้อง
    console.log("Setting date range:", startDate.toISOString(), endDate.toISOString());

    picker.setDateRange(startDate, endDate);
    picker.render();
}

    
        toggleButton.addEventListener('click', function() {
            picker.show();
        });
    
        // ฟังก์ชันแปลงตัวเลขเป็นรูปแบบมีจุลภาค
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    });
    </script>
    
@endsection