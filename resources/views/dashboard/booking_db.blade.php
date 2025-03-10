@extends('layouts.main')

@section('content')
<div>
    <div class="col-md-10 content">
        <div class="d-flex justify-content-between align-items-center mb-4">
         <h2>
          จัดการการจองห้อง
         </h2>
         <div class="d-flex align-items-center">
            <form action="{{ route('booking_db') }}" method="GET" class="d-flex">
                <input class="search-bar" placeholder="ค้นหาการจอง" type="text" name="search" value="{{ request('search') }}"/>
                <button type="submit" class="icon-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
         </div>
        </div>
        <div class="row mb-4">
         <div class="col-md-4">
          <div class="stat-card">
           <i class="fas fa-book icon">
           </i>
           <div class="details">
            <h3>
             {{ $totalBookings }}
            </h3>
            <p>
             จำนวนการจองทั้งหมด
            </p>
           </div>
          </div>
         </div>
         <div class="col-md-4">
            <div class="stat-card">
             <i class="fas fa-clock icon">
             </i>
             <div class="details">
              <h3>
               {{ $pendingBookings }}
              </h3>
              <p>
               จำนวนการจองที่รอดำเนินการ
              </p>
             </div>
            </div>
           </div>
         <div class="col-md-4">
          <div class="stat-card">
           <i class="fas fa-check-circle icon">
           </i>
           <div class="details">
            <h3>
             {{ $confirmedBookings }}
            </h3>
            <p>
             จำนวนการจองที่ยืนยันแล้ว
            </p>
           </div>
          </div>
         </div>
         
        </div>
        <div class="row">
         <div class="col-md-12">
          <div class="card mb-4">
           <div class="card-header d-flex justify-content-between align-items-center">
            <h5>
             รายการการจอง
            </h5>
           </div>
           <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>รหัสการจอง</th>
                    <th>ผู้ใช้</th>
                    <th>ผู้จองห้อง</th>
                    <th>อีเมลผู้ใช้</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th>สถานะการชำระเงิน</th>
                    <th>สถานะการอนุมัติ</th>
                    <th>การดำเนินการ</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($bookings as $booking)
                  <tr>
                    <td>{{ (($bookings->currentPage() - 1) * $bookings->perPage()) + $loop->iteration }}</td>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->user_name ?? 'N/A' }}</td>
                    <td>{{ $booking->external_name }}</td>
                    <td>{{ $booking->external_email }}</td>
                    <td>{{ $booking->external_phone }}</td>
                    <td>{{ $booking->payment_status }}</td>
                    <td>
                      <span class="badge 
                          @if($booking->status_id == 1) bg-success 
                          @elseif($booking->status_id == 2) bg-warning 
                          @elseif($booking->status_id == 3) bg-danger 
                          @elseif($booking->status_id == 4) bg-secondary 
                          @else bg-info @endif">
                          {{ $booking->status_name }}
                      </span>
                    </td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                          เปลี่ยนสถานะ
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <form action="{{ route('booking.update-status', $booking->id) }}" method="POST">
                              @csrf
                              @method('PATCH')
                              <input type="hidden" name="status_id" value="4">
                              <button type="submit" class="dropdown-item text-success">
                                <i class="fas fa-check-circle"></i> อนุมัติการจอง
                              </button>
                            </form>
                          </li>
                          <li>
                            <form action="{{ route('booking.update-status', $booking->id) }}" method="POST">
                              @csrf
                              @method('PATCH')
                              <input type="hidden" name="status_id" value="5">
                              <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-times-circle"></i> ยกเลิกการจอง
                              </button>
                            </form>
                          </li>
                          <li><hr class="dropdown-divider"></li>
                          <li>
                            <form action="{{ route('booking.update-status', $booking->id) }}" method="POST">
                              @csrf
                              @method('PATCH')
                              <input type="hidden" name="status_id" value="3">
                              <button type="submit" class="dropdown-item text-warning">
                                <i class="fas fa-clock"></i> รอดำเนินการ
                              </button>
                            </form>
                          </li>
                          <li>
                            <form action="{{ route('booking.update-status', $booking->id) }}" method="POST">
                              @csrf
                              @method('PATCH')
                              <input type="hidden" name="status_id" value="4">
                              <button type="submit" class="dropdown-item text-secondary">
                                <i class="fas fa-check-double"></i> จบแล้ว
                              </button>
                            </form>
                          </li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            <div class="d-flex justify-content-center mt-4">
                {{ $bookings->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
            </div>
           </div>
          </div>
        </div>
    </div>
</div>
@endsection