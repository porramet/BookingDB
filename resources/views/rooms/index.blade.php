@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">ห้องทั้งหมด</h2>
                <a href="{{ url('/') }}" class="btn btn-outline-warning">
                    <i class="fas fa-arrow-left"></i> กลับหน้าหลัก
                </a>
            </div>

            <div class="row g-4">
                @foreach($rooms as $room)
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <img src="{{ $room->image ? asset('storage/'.$room->image) : '/api/placeholder/400/200' }}" class="card-img-top" alt="Room Image">
                        <div class="card-body">
                            <h5 class="fw-bold">{{ $room->room_name }}</h5>
                            <p class="text-muted mb-1">อาคาร {{ $room->building->building_name }} ชั้น {{ $room->class }}</p>
                            <p class="text-muted mb-1">รองรับได้ {{ $room->capacity }} คน</p>
                            <p class="fw-bold text-warning">฿{{ number_format($room->service_rates, 2) }} /ชั่วโมง</p>
                            <a href="{{ url('booking/'.$room->room_id) }}" class="btn btn-warning w-100">จองเลย</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection