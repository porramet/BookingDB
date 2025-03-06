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
                <th>อาคาร</th>
                <th>ห้อง</th>
                <th>สถานะ</th>
                <th>สถานะการชำระเงิน</th>
                <th>การกระทำ</th>
              </tr>
             </thead>
             <tbody>
             @foreach($bookings as $booking)
              <tr>
               <td>{{ (($bookings->currentPage() - 1) * $bookings->perPage()) + $loop->iteration }}</td>
               <td>{{ $booking->id }}</td>
                <td>{{ $booking->user ? $booking->user->name : 'N/A' }}</td>
                <td>{{ $booking->external_name }}</td>
                <td>{{ $booking->external_email }}</td>
                <td>{{ $booking->external_phone }}</td>
                <td>{{ $booking->building_name ? $booking->building_name : 'N/A' }}</td>
                <td>{{ $booking->room_name ? $booking->room_name : 'N/A' }}</td>
                <td>{{ $booking->status_name ? $booking->status_name : 'N/A' }}</td>
                <td>{{ $booking->payment_status }}</td>
               <td>
                <form action="{{ route('booking_db.update', $booking->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <select name="status" class="form-select" onchange="this.form.submit()">
                     <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>ยืนยันแล้ว</option>
                     <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>รอดำเนินการ</option>
                    </select>
                </form>
               </td>
               <td>
                <form action="{{ route('booking_db.destroy', $booking->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ที่ต้องการลบการจองนี้?')">ลบ</button>
                </form>
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


 