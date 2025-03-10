@extends('layouts.main')

@section('content')
<div>
    <div class="col-md-10 content">
        <div class="d-flex justify-content-between align-items-center mb-4">
         <h2>
          ประวัติการจองห้อง
         </h2>
         <div class="d-flex align-items-center">
            <form action="{{ route('booking.history') }}" method="GET" class="d-flex">
                <div class="me-2">
                    <label for="date_from" class="form-label">จากวันที่</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="me-2">
                    <label for="date_to" class="form-label">ถึงวันที่</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="ms-2">
                    <label for="search" class="form-label">ค้นหา</label>
                    <div class="d-flex">
                        <input class="form-control search-bar" placeholder="ค้นหาประวัติการจอง" type="text" name="search" id="search" value="{{ request('search') }}"/>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
         </div>
        </div>
        
        <div class="row">
         <div class="col-md-12">
          <div class="card mb-4">
           <div class="card-header d-flex justify-content-between align-items-center">
            <h5>
             รายการประวัติการจอง
            </h5>
           </div>
           <div class="card-body">
            <table class="table table-striped">
             <thead>
              <tr>
               <th>#</th>
               <th>รหัสการจอง</th>
                <th>ผู้ใช้</th>
                <th>ผู้จองห้อง</th>
                <th>อีเมลผู้ใช้</th>
                <th>เบอร์โทรศัพท์</th>
                <th>วันที่จอง</th>
                <th>เวลาเริ่ม-สิ้นสุด</th>
                <th>สถานะการชำระเงิน</th>
                <th>สถานะการจอง</th>
              </tr>
             </thead>
             <tbody>
             @foreach($bookingHistory as $history)
              <tr>
               <td>{{ (($bookingHistory->currentPage() - 1) * $bookingHistory->perPage()) + $loop->iteration }}</td>
               <td>{{ $history->booking_id }}</td>
                <td>{{ $history->user_name ?? 'N/A' }}</td>
                <td>{{ $history->external_name }}</td>
                <td>{{ $history->external_email }}</td>
                <td>{{ $history->external_phone }}</td>
                <td>{{ date('d/m/Y', strtotime($history->booking_date)) }}</td>
                <td>{{ date('H:i', strtotime($history->start_time)) }} - {{ date('H:i', strtotime($history->end_time)) }}</td>
                <td>{{ $history->payment_status }}</td>
                <td>
                    <span class="badge 
                        @if($history->status_id == 1) bg-success 
                        @elseif($history->status_id == 4) bg-warning 
                        @elseif($history->status_id == 5) bg-danger 
                        @elseif($history->status_id == 6) bg-secondary 
                        @else bg-info @endif">
                        {{ $history->status_name }}
                    </span>
                </td>
              </tr>
             @endforeach
             </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4">
                {{ $bookingHistory->appends(['search' => request('search'), 'date_from' => request('date_from'), 'date_to' => request('date_to')])->links('pagination::bootstrap-5') }}
            </div>
           </div>
          </div>
        </div>
    </div>
</div>
@endsection