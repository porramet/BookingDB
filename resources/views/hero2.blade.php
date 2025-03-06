<!-- Hero Section -->
<!-- resources/views/hero.blade.php -->
<section class="hero-section bg-cover bg-center text-white text-center py-20" style="background-image: url('{{ asset('images/hero-image1.jpg') }}');">
    <div class="container mx-auto px-4">
        <!-- Logo Centered -->
        <a class="logo-container" href="{{ url('/') }}">
            <img alt="โลโก้มหาวิทยาลัย" class="logo" src="{{ asset('images/snru.png') }}" />
        </a>
        <!-- Hero Text -->
        <h1 class="text-4xl font-bold">ยินดีต้อนรับสู่ระบบจองห้องออนไลน์มหาวิทยาลัยราชภัฏสกลนคร</h1>
        <p class="mt-4 text-lg">สะดวก รวดเร็ว จองห้องประชุมหรือพื้นที่ได้ทุกที่ ทุกเวลา</p>
        <div class="mt-8">
            <a class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-300 mr-4" href="{{ url('/login') }}">เข้าสู่ระบบ</a>
            @if (request()->is('/') || request()->is('booking'))
                <a class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition duration-300" href="{{ url('/booking') }}">ดูสถานะห้องว่าง</a>
            @endif
        </div>
    </div>
    <!-- Search Box -->
    <div class="mt-12 bg-white p-4 rounded-lg shadow-md text-gray-800 max-w-4xl mx-auto">
        <h2 class="text-xl font-bold mb-4">ค้นหาห้องประชุม</h2>
        <form class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
            <div class="flex flex-col">
                <label class="block text-sm font-medium mb-1" for="building">อาคาร</label>
                <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="building" name="building" type="text"/>
            </div>
            <div class="flex flex-col">
                <label class="block text-sm font-medium mb-1" for="room">ห้อง</label>
                <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="room" name="room" type="text"/>
            </div>
            <div class="flex flex-col">
                <label class="block text-sm font-medium mb-1" for="booking-date">วันที่จอง</label>
                <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="booking-date" name="booking-date" type="date"/>
            </div>
            <div class="flex flex-col">
                <label class="block text-sm font-medium mb-1" for="booking-end-date">วันที่สิ้นสุดการจอง</label>
                <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="booking-end-date" name="booking-end-date" type="date"/>
            </div>
        </form>
        <div class="flex justify-center mt-4">
            <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300" type="submit">ค้นหา</button>
        </div>
    </div>
</section>

<style>
    /* Logo Container */
.logo-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 50px; /* ปรับระยะห่างจากข้างบน */
}

/* Logo */
.logo {
    height: 270px; /* ปรับขนาดโลโก้ */
    width: auto; /* คงสัดส่วนของโลโก้ */
    margin-right: 50px; /* ระยะห่างระหว่างโลโก้และข้อความ */
}

/* ปรับระยะห่างด้านบนของข้อความ */
.hero-section h1 {
    margin-top: 50px; /* เพิ่มระยะห่างด้านบน */
}



</style>