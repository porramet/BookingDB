<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>ระบบจองห้องออนไลน์มหาวิทยาลัยราชภัฏสกลนคร</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <!-- The CDN for Tailwind CSS should not be used in production. 
    To use Tailwind CSS in production, install it as a PostCSS plugin or use the Tailwind CLI: https://tailwindcss.com/docs/installation -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-image: url('{{ asset('images/bg-1.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        .floating-icons {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        }

        .floating-icon {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        background-color: #E94751;
        color: white;
        border-radius: 50%;
        width: 60px; /* ไอคอนขนาดใหญ่ขึ้น */
        height: 60px;
        transition: background-color 0.3s ease, color 0.3s ease;
        }

        .floating-icon:hover {
        background-color: white;
        color: #E94751;
        }

        .floating-icon .ico {
        font-size: 2em; /* ขนาดไอคอน */
        }

        .floating-icon::after {
        content: attr(data-text); /* ดึงข้อความจาก data-text */
        position: absolute;
        left: -150%; /* แสดงข้อความด้านซ้ายของไอคอน */
        top: 50%;
        transform: translateY(-50%);
        background-color: black;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        white-space: nowrap;
        font-size: 0.9em;
        visibility: hidden; /* ซ่อนข้อความเริ่มต้น */
        opacity: 0;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .floating-icon:hover::after {
        visibility: visible; /* แสดงข้อความเมื่อโฮเวอร์ */
        opacity: 1;
        }

    </style>
</head>
<body class="bg-gray-100">
    @include('header') <!-- รวม header -->
    @yield('content') <!-- แสดงเนื้อหาของแต่ละหน้า -->
    @include('footer') <!-- รวม footer -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Full version of jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/booking.js') }}"></script>


    <!-- Floating Icons -->
<div class="floating-icons">
    @if (Auth::check())
        <a href="{{ url('/profile') }}" class="floating-icon" data-toggle="modal" data-target="#profileModal" data-text="{{ Auth::user()->name }}">
            <i class="fas fa-user-circle ico"></i> <!-- Profile Icon -->
        </a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="floating-icon" data-text="ออกจากระบบ">
                <i class="fas fa-sign-out-alt ico"></i> <!-- Logout Icon -->
            </button>
        </form>
    @endif
</div>
 <!-- Include Profile Modal -->
 @include('profile')

</body>
</html>
