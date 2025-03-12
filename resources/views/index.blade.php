@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">สวัสดี, สมชาย</h2>
                <div class="d-flex align-items-center gap-3">
                    <div class="position-relative">
                        <input type="text" placeholder="ค้นหาห้อง..." class="form-control ps-4">
                        <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-2 text-gray-400"></i>
                    </div>
                    <button class="btn btn-light position-relative">
                        <i class="fas fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                    </button>
                    <button class="btn btn-light">
                        <i class="fas fa-cog"></i>
                    </button>
                    <img src="/api/placeholder/40/40" class="rounded-circle" alt="Profile">
                </div>
            </div>

            <div class="card bg-warning text-white mb-4">
                <div class="card-body text-center">
                    <h3 class="card-title">ส่วนลดพิเศษ</h3>
                    <h2 class="fw-bold">รับส่วนลด 20% สำหรับการจองครั้งแรก</h2>
                    <p>ใช้โค้ด <strong>NEWUSER20</strong> เมื่อทำการจอง</p>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold">ประเภทห้อง</h3>
                <a href="#" class="text-warning fw-bold">ดูทั้งหมด</a>
            </div>
            <div class="row g-3">
                @php
                    $rooms = [
                        ['icon' => 'users', 'name' => 'ห้องประชุม'],
                        ['icon' => 'book', 'name' => 'ห้องสัมมนา'],
                        ['icon' => 'laptop', 'name' => 'ห้องคอม'],
                        ['icon' => 'flask', 'name' => 'ห้องแล็บ'],
                        ['icon' => 'chalkboard-teacher', 'name' => 'ห้องเรียน'],
                        ['icon' => 'couch', 'name' => 'ห้องพัก']
                    ];
                @endphp
                @foreach($rooms as $room)
                <div class="col-md-2">
                    <div class="card text-center py-3 shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-{{ $room['icon'] }} text-warning display-6 mb-2"></i>
                            <p class="mb-0 fw-semibold">{{ $room['name'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                <h3 class="fw-bold">ห้องยอดนิยม</h3>
                <a href="#" class="text-warning fw-bold">ดูทั้งหมด</a>
            </div>
            <div class="row g-4">
                @php
                    $popularRooms = [
                        ['img' => '/api/placeholder/400/200', 'title' => 'ห้องประชุมขนาดใหญ่', 'location' => 'อาคาร 1 ชั้น 3', 'capacity' => '30 คน', 'price' => '฿1,200 /ชั่วโมง'],
                        ['img' => '/api/placeholder/400/200', 'title' => 'ห้องเรียนสัมมนา', 'location' => 'อาคาร 2 ชั้น 5', 'capacity' => '50 คน', 'price' => '฿1,500 /ชั่วโมง'],
                        ['img' => '/api/placeholder/400/200', 'title' => 'ห้องคอมพิวเตอร์', 'location' => 'อาคาร 3 ชั้น 2', 'capacity' => '25 คน', 'price' => '฿2,000 /ชั่วโมง']
                    ];
                @endphp
                @foreach($popularRooms as $room)
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <img src="{{ $room['img'] }}" class="card-img-top" alt="Room Image">
                        <div class="card-body">
                            <h5 class="fw-bold">{{ $room['title'] }}</h5>
                            <p class="text-muted mb-1">{{ $room['location'] }}</p>
                            <p class="text-muted mb-1">รองรับได้ {{ $room['capacity'] }}</p>
                            <p class="fw-bold text-warning">{{ $room['price'] }}</p>
                            <button class="btn btn-warning w-100">จองเลย</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
