<header class="bg-transparent absolute top-0 left-0 w-full z-10">
    <div class="container mx-auto px-4 py-4 flex justify-center items-center">
        <nav class="menu-bar">
            <ul class="flex space-x-6">
                <li class="menu-item">
                    <a class="flex items-center" href="{{ url('/') }}">
                        <i class="fas fa-home mr-2"></i>หน้าหลัก
                    </a>
                </li>
                <li class="menu-item">
                    <a class="flex items-center" href="{{ url('/booking') }}">
                        <i class="fas fa-door-open mr-2"></i>จองห้อง
                    </a>
                </li>
                <li class="menu-item">
                    <a class="flex items-center" href="{{ url('/usage') }}">
                        <i class="fas fa-question-circle mr-2"></i>วิธีการใช้งาน
                    </a>
                </li>
                <li class="menu-item">
                    <a class="flex items-center" href="{{ url('/contact') }}">
                        <i class="fas fa-phone-alt mr-2"></i>ติดต่อเรา
                    </a>
                </li>
                <!-- ตรวจสอบว่าเป็น Admin หรือไม่ -->
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="menu-item">
                        <a class="flex items-center" href="{{ url('/dashboard') }}">
                            <i class="fa-regular fa-table-columns"></i>แดชบอร์ด
                        </a>
                    </li>
                @endif

                @if(Auth::check())
                    <!-- หากผู้ใช้เข้าสู่ระบบแล้ว ไม่แสดงลิงก์เข้าสู่ระบบและสมัครสมาชิก -->
                @else
                    <li class="menu-item">
                        <a class="flex items-center" href="{{ url('/login') }}">
                            <i class="fas fa-sign-in-alt mr-2"></i>เข้าสู่ระบบ
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="flex items-center" href="{{ url('/register') }}">
                            <i class="fas fa-user-plus mr-2"></i>สมัครสมาชิก
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</header>

<style>
  .menu-bar {
    border-radius: 25px;
    height: fit-content;
    display: inline-flex;
    background-color: rgb(59, 130, 246);
    -webkit-backdrop-filter: blur(10px);
    backdrop-filter: blur(10px);
    align-items: center;
    padding: 0 10px;
    margin: 10px 0 0 0; /* ปรับ margin ขึ้นให้สูงขึ้น */
  }

  .menu-item {
    list-style: none;
    color: white;
    font-family: sans-serif;
    font-weight: bold;
    padding: 12px 16px;
    margin: 0 8px;
    position: relative;
    cursor: pointer;
    white-space: nowrap;
    transition: .2s;
  }

  .menu-item a {
    text-decoration: none;
    color: inherit;
  }

  .menu-item::before {
    content: " ";
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    z-index: -1;
    transition: .2s;
    border-radius: 25px;
  }

  .menu-item:hover::before {
    background-color:rgb(51, 39, 119); /* ใช้สีฟ้า #007bff */
    box-shadow: 0px 3px 20px 0px black;
    transform: scale(1);
    }


  .menu-item:hover {
    color: white; /* ตัวหนังสือยังคงเป็นสีขาว */
  }

  .menu-bar {
    position: sticky; /* ทำให้เมนูอยู่ติดกับขอบบน */
    top: 0; /* ตำแหน่งอยู่ที่ด้านบนสุด */
    z-index: 10; /* ให้เมนูอยู่บนสุด */
    border-radius: 25px;
    height: fit-content;
    display: inline-flex;
    background-color: rgb(59, 130, 246);
    -webkit-backdrop-filter: blur(10px);
    backdrop-filter: blur(10px);
    align-items: center;
    padding: 0 10px;
    margin: 10px 0 0 0; /* ปรับ margin ขึ้นให้สูงขึ้น */
}

</style>
