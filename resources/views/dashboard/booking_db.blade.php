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
                <input class="search-bar me-2" placeholder="ค้นหาการจอง" type="text" name="search" value="{{ request('search') }}"/>
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
              <div class="card mb-4 shadow-sm">
                  <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                      <h5 class="mb-0 fw-bold text-primary">
                          <i class="fas fa-list me-2"></i> รายการการจอง
                      </h5>
                      <div class="d-flex align-items-center">
                          <!-- Calendar Dropdown -->
                          <div class="dropdown me-2">
                              <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="calendarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                  <i class="fas fa-calendar-alt"></i> เลือกวันที่
                              </button>
                              <div class="dropdown-menu p-3 shadow" style="width: 300px;">
                                  <h6 class="mb-2">เลือกวันที่จอง</h6>
                                  <div id="booking-calendar"></div>
                                  <form id="calendar-form" action="{{ route('booking_db') }}" method="GET">
                                      <input type="hidden" name="booking_date" id="selected_date" value="{{ request('booking_date') }}">
                                      <div class="d-grid gap-2 mt-2">
                                          <button type="submit" class="btn btn-sm btn-primary">ค้นหา</button>
                                          <a href="{{ route('booking_db') }}" class="btn btn-sm btn-outline-secondary">ล้างการกรอง</a>
                                      </div>
                                  </form>
                              </div>
                          </div>
                          <!-- History Button -->
                          <a href="{{ route('booking_history') }}" class="btn btn-outline-secondary btn-sm">
                              <i class="fas fa-history"></i> ประวัติการจอง
                          </a>
                      </div>
                  </div>
                  <div class="card-body">
                      @if(session('success'))
                          <div class="alert alert-success alert-dismissible fade show">
                              {{ session('success') }}
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                      @endif
                      
                      @if(request('booking_date'))
                          <div class="alert alert-info alert-dismissible fade show">
                              <i class="fas fa-filter me-2"></i> กำลังแสดงการจองสำหรับวันที่: <strong>{{ \Carbon\Carbon::parse(request('booking_date'))->format('d/m/Y') }}</strong>
                              <a href="{{ route('booking_db') }}" class="float-end text-decoration-none">ล้างการกรอง</a>
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                      @endif
                      
                      <div class="table-responsive">
                          <table class="table table-striped table-hover align-middle">
                              <thead class="table-light">
                                  <tr>
                                      <th width="5%" class="text-center">#</th>
                                      <th width="8%">รหัสการจอง</th>
                                      <th width="12%">ผู้จองห้อง</th>
                                      <th width="10%">เบอร์โทรศัพท์</th>
                                      <th width="10%">วันเวลาที่จอง</th>
                                      <th width="12%">วันเวลาที่สิ้นสุดจอง</th>
                                      <th width="12%">สถานะการชำระเงิน</th>
                                      <th width="10%" class="text-center">สถานะการอนุมัติ</th>
                                      <th width="25%" class="text-center">การดำเนินการ</th>
                                  </tr>
                              </thead>
                              <tbody>
                              @forelse($bookings as $booking)
                                  <tr>
                                      <td class="text-center">{{ (($bookings->currentPage() - 1) * $bookings->perPage()) + $loop->iteration }}</td>
                                      <td><span class="badge bg-light text-dark">{{ $booking->id }}</span></td>
                                      <td>
                                          <div class="fw-bold">{{ $booking->external_name }}</div>
                                          <small class="text-muted">{{ $booking->external_email }}</small>
                                      </td>
                                      <td>{{ $booking->external_phone }}</td>
                                      <td>
                                          <div><i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($booking->booking_start)->format('d/m/Y') }}</div>
                                          <small class="text-muted">
                                              <i class="far fa-clock me-1"></i> 
                                              {{ \Carbon\Carbon::parse($booking->booking_start)->format('H:i') }} - 
                                              {{ \Carbon\Carbon::parse($booking->booking_end)->format('H:i') }}
                                              
                                          </small>
                                      </td>
                                      <td>
                                        <div><i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($booking->booking_end)->format('d/m/Y') }}</div>
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i> 
                                            {{ \Carbon\Carbon::parse($booking->booking_start)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($booking->booking_end)->format('H:i') }}
                                        </small>
                                    </td>
                                      <td>
                                          <span class="badge {{ $booking->payment_status == 'ชำระแล้ว' ? 'bg-success' : 'bg-warning' }}">
                                              {{ $booking->payment_status }}
                                          </span>
                                      </td>
                                      <td class="text-center">
                                          <span class="badge 
                                              @if($booking->status_id == 1) bg-info 
                                              @elseif($booking->status_id == 2) bg-warning 
                                              @elseif($booking->status_id == 3) bg-danger 
                                              @elseif($booking->status_id == 4) bg-success 
                                              @else bg-secondary @endif">
                                              {{ $booking->status_name }}
                                          </span>
                                      </td>
                                      <td class="text-center">
                                          <div class="btn-group">
                                              <a href="#" class="btn btn-outline-info btn-sm view-details" 
                                                 data-bs-toggle="modal" data-bs-target="#detailsModal{{ $booking->id }}">
                                                  <i class="fas fa-eye"></i> รายละเอียด
                                              </a>
                                              <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                  <i class="fas fa-edit"></i> เปลี่ยนสถานะ
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
                                                          <input type="hidden" name="status_id" value="6">
                                                          <button type="submit" class="dropdown-item text-secondary">
                                                              <i class="fas fa-check-double"></i> ดำเนินการเสร็จสิ้น
                                                          </button>
                                                      </form>
                                                  </li>
                                              </ul>
                                          </div>
                                      </td>
                                  </tr>
                                  
                                  <!-- Modal for Booking Details -->
                                  <div class="modal fade" id="detailsModal{{ $booking->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $booking->id }}" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered modal-lg">
                                          <div class="modal-content">
                                              <div class="modal-header bg-light">
                                                  <h5 class="modal-title" id="detailsModalLabel{{ $booking->id }}">
                                                      <i class="fas fa-info-circle me-2"></i> รายละเอียดการจองห้อง
                                                  </h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              <div class="modal-body">
                                                  <div class="row">
                                                      <div class="col-md-6">
                                                          <h6 class="fw-bold text-primary mb-3">ข้อมูลการจอง</h6>
                                                          <div class="mb-2">
                                                              <strong>รหัสการจอง:</strong> {{ $booking->id }}
                                                          </div>
                                                          <div class="mb-2">
                                                              <strong>วันที่จอง:</strong> {{ \Carbon\Carbon::parse($booking->booking_start)->format('d/m/Y') }}
                                                          </div>
                                                          <div class="mb-2">
                                                            <strong>วันที่สิ้นสุดการจอง:</strong> {{ \Carbon\Carbon::parse($booking->booking_end)->format('d/m/Y') }}
                                                        </div>
                                                          <div class="mb-2">
                                                              <strong>เวลา:</strong> 
                                                              {{ \Carbon\Carbon::parse($booking->booking_start)->format('H:i') }} - 
                                                              {{ \Carbon\Carbon::parse($booking->booking_end)->format('H:i') }}
                                                          </div>
                                                          <div class="mb-2">
                                                              <strong>วัตถุประสงค์:</strong> {{ $booking->reason ?? 'ไม่ระบุ' }}
                                                          </div>
                                                          <div class="mb-2">
                                                              <strong>จำนวนผู้เข้าร่วม:</strong> {{ $booking->attendees ?? 'ไม่ระบุ' }} คน
                                                          </div>
                                                          <div class="mb-2">
                                                              <strong>สถานะการชำระเงิน:</strong> 
                                                              <span class="badge {{ $booking->payment_status == 'ชำระแล้ว' ? 'bg-success' : 'bg-warning' }}">
                                                                  {{ $booking->payment_status }}
                                                              </span>
                                                          </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                          <h6 class="fw-bold text-primary mb-3">ข้อมูลผู้จอง</h6>
                                                          <div class="mb-2">
                                                              <strong>ชื่อผู้จอง:</strong> {{ $booking->external_name }}
                                                          </div>
                                                          <div class="mb-2">
                                                              <strong>อีเมล:</strong> {{ $booking->external_email }}
                                                          </div>
                                                          <div class="mb-2">
                                                              <strong>โทรศัพท์:</strong> {{ $booking->external_phone }}
                                                          </div>
                                                          <div class="mb-2">
                                                              <strong>หน่วยงาน/แผนก:</strong> {{ $booking->department ?? 'ไม่ระบุ' }}
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <hr>
                                                  <div class="row">
                                                      <div class="col-md-12">
                                                          <h6 class="fw-bold text-primary mb-3">ข้อมูลห้อง</h6>
                                                          <div class="mb-2">
                                                              <strong>อาคาร:</strong> {{ $booking->building_name }}
                                                          </div>
                                                          <div class="mb-2">
                                                              <strong>ห้อง:</strong> {{ $booking->room_name }}
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              @empty
                                  <tr>
                                      <td colspan="8" class="text-center py-4 text-muted">
                                          <i class="fas fa-calendar-times fa-2x mb-3"></i>
                                          <p>ไม่พบข้อมูลการจอง</p>
                                      </td>
                                  </tr>
                              @endforelse
                              </tbody>
                          </table>
                      </div>
                      <div class="d-flex justify-content-center mt-4">
                          {{ $bookings->appends(['search' => request('search'), 'booking_date' => request('booking_date')])->links('pagination::bootstrap-5') }}
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection

<style>
  /* Main Layout Styles */
body {
   font-family: 'Poppins', sans-serif;
   background-color: #f5f5f7;
   color: #333;
}

.container {
   max-width: 1200px;
   margin: 0 auto;
   padding: 20px;
}

.content {
   margin: 0 auto;
}

/* Header Styles */
h2 {
   font-weight: 700;
   color: #333;
   margin-bottom: 20px;
}

/* Search Bar */
.search-bar {
   border: none;
   background-color: #fff;
   border-radius: 30px;
   padding: 10px 15px;
   width: 200px;
   box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
   margin-right: 10px;
}

.icon-btn {
   background-color: #fff;
   border: none;
   border-radius: 50%;
   width: 40px;
   height: 40px;
   display: flex;
   align-items: center;
   justify-content: center;
   margin-left: 10px;
   box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
   cursor: pointer;
   transition: all 0.3s ease;
}

.icon-btn:hover {
   background-color: #f8f8f8;
}

.profile-img {
   width: 40px;
   height: 40px;
   border-radius: 50%;
   margin-left: 15px;
   object-fit: cover;
}

/* Stat Cards */
.stat-card {
   background-color: #fff;
   border-radius: 15px;
   padding: 20px;
   display: flex;
   align-items: center;
   box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
   transition: transform 0.3s ease;
   height: 100px;
}

.stat-card:hover {
   transform: translateY(-5px);
}

.stat-card .icon {
   font-size: 24px;
   background-color: #FFC107;
   color: #fff;
   padding: 15px;
   border-radius: 12px;
   margin-right: 15px;
}

.stat-card .details h3 {
   font-size: 24px;
   font-weight: 700;
   margin: 0;
   color: #333;
}

.stat-card .details p {
   margin: 5px 0 0;
   color: #777;
   font-size: 14px;
}

/* Card Styles */
.card {
   border: none;
   border-radius: 15px;
   box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
   overflow: hidden;
}

.card-header {
   background-color: #fff;
   border-bottom: 1px solid #eee;
   padding: 15px 20px;
}

.card-header h5 {
   font-weight: 600;
   margin: 0;
   color: #333;
}

.card-body {
   padding: 20px;
}

/* Table Styles */
.table {
   width: 100%;
   margin-bottom: 0;
}

.table th {
   font-weight: 600;
   color: #555;
   border-top: none;
   border-bottom: 2px solid #eee;
   padding: 12px 8px;
   background-color: #f9f9f9;
}

.table td {
   padding: 12px 8px;
   vertical-align: middle;
   border-top: 1px solid #eee;
}

.table-striped tbody tr:nth-of-type(odd) {
   background-color: #f9f9f9;
}

/* Button Styles */
.btn {
   border-radius: 8px;
   padding: 6px 12px;
   font-weight: 500;
   font-size: 13px;
   transition: all 0.3s ease;
}

.btn-success {
   background-color: #FFC107;
   border-color: #FFC107;
   color: #fff;
}

.btn-success:hover {
   background-color: #e0a800;
   border-color: #e0a800;
}

.btn-danger {
   background-color: #F44336;
   border-color: #F44336;
}

.btn-danger:hover {
   background-color: #d32f2f;
   border-color: #d32f2f;
}

/* Custom Style for Status */
td:nth-child(8) {
   font-weight: 600;
}

/* Custom Style for Different Status */
td:nth-child(8):contains('approved') {
   color: #4CAF50;
}

td:nth-child(8):contains('pending') {
   color: #FFC107;
}

td:nth-child(8):contains('rejected') {
   color: #F44336;
}

/* Custom Style for Payment Status */
td:nth-child(9) {
   font-weight: 600;
}

td:nth-child(9):contains('paid') {
   color: #4CAF50;
}

td:nth-child(9):contains('unpaid') {
   color: #F44336;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
   .stat-card {
       margin-bottom: 20px;
   }
   
   .table-responsive {
       overflow-x: auto;
   }
}
</style>
