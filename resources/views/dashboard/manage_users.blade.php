@extends('layouts.main')

@section('content')
<div>
    <div class="col-md-10 content">
        <div class="d-flex justify-content-between align-items-center mb-4">
         <h2>
          จัดการผู้ใช้
         </h2>
         <div class="d-flex align-items-center">
            <form action="{{ route('manage_users.index') }}" method="GET" class="d-flex">
                <input class="search-bar" placeholder="ค้นหาผู้ใช้" type="text" name="search" value="{{ request('search') }}"/>
                <button type="submit" class="icon-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>

          <button class="icon-btn">
           <i class="fas fa-bell">
           </i>
          </button>
          <img alt="Profile image" class="profile-img" src="https://placehold.co/40x40"/>
         </div>
        </div>
        <div class="row mb-4">
         <div class="col-md-4">
          <div class="stat-card">
           <i class="fas fa-users icon">
           </i>
           <div class="details">
            <h3>
             {{ $totalUsers }}
            </h3>
            <p>
             จำนวนผู้ใช้ทั้งหมด
            </p>
           </div>
          </div>
         </div>
         <div class="col-md-4">
          <div class="stat-card">
           <i class="fas fa-user-shield icon">
           </i>
           <div class="details">
            <h3>
             {{ $adminCount }}
            </h3>
            <p>
             จำนวนผู้ดูแลระบบ
            </p>
           </div>
          </div>
         </div>
         <div class="col-md-4">
          <div class="stat-card">
           <i class="fas fa-user icon">
           </i>
           <div class="details">
            <h3>
             {{ $regularUserCount }}
            </h3>
            <p>
             จำนวนผู้ใช้ทั่วไป
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
             รายการผู้ใช้
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
               <th>ชื่อผู้ใช้</th>
               <th>อีเมล</th>
               <th>บทบาท</th>
               <th>การกระทำ</th>
              </tr>
             </thead>
             <tbody>
             @foreach($users as $user)
              <tr>
               <td>{{ (($users->currentPage() - 1) * $users->perPage()) + $loop->iteration }}</td>

               <td>{{ $user->name }}</td>
               <td>{{ $user->email }}</td>
               <td>
                <form action="{{ route('manage_users.update', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <select name="role" class="form-select" onchange="this.form.submit()">
                     <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>ผู้ดูแลระบบ</option>
                     <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>ผู้ใช้ทั่วไป</option>
                    </select>
                </form>
               </td>
               <td>
                <form action="{{ route('manage_users.destroy', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ที่ต้องการลบผู้ใช้นี้?')">ลบ</button>
                </form>
               </td>
              </tr>
             @endforeach
             </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4">
                {{ $users->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
            </div>
           </div>
</div>
@endsection
<style>
    /* Layout */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }
    
    .sidebar {
        background-color: #fff;
        height: 100vh;
        padding: 20px;
        border-right: 1px solid #e0e0e0;
    }
    
    .content {
        padding: 20px;
    }
    
    /* Cards */
    .card {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        background-color: #fff;
        border-bottom: none;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .card-footer {
        background-color: #fff;
        border-top: none;
    }
    
    .card-blue {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: #fff;
    }
    
    /* Navigation */
    .sidebar .nav-link {
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 10px;
    }
    
    .sidebar .nav-link.active {
        color: #007bff;
        background-color: #e9ecef;
        border-radius: 5px;
    }
    
    /* User Interface Elements */
    .profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }
    
    .search-bar {
        background-color: #f1f3f4;
        border: none;
        border-radius: 20px;
        padding: 10px 20px;
        width: 100%;
    }
    
    .search-bar:focus {
        outline: none;
        box-shadow: none;
    }
    
    .icon-btn {
        background-color: #f1f3f4;
        border: none;
        border-radius: 50%;
        padding: 10px;
        margin-left: 10px;
    }
    
    .icon-btn i {
        color: #6c757d;
    }
    
    /* Statistics Cards */
    .stat-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    
    .stat-card .icon {
        font-size: 40px;
        color: #6c757d;
    }
    
    .stat-card .details {
        text-align: right;
    }
    
    .stat-card .details h3 {
        margin: 0;
        font-size: 24px;
    }
    
    .stat-card .details p {
        margin: 0;
        color: #6c757d;
    }
    
    /* Transactions */
    .transaction-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .transaction-item:last-child {
        border-bottom: none;
    }
    
    .transaction-item .icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }
    
    .transaction-item .icon i {
        font-size: 20px;
    }
    
    .transaction-item .details {
        flex-grow: 1;
    }
    
    .transaction-item .amount {
        font-weight: 500;
    }
    
    .transaction-item .amount.negative {
        color: #dc3545;
    }
    
    .transaction-item .amount.positive {
        color: #28a745;
    }
    
    /* Charts */
    .chart-container {
        position: relative;
        height: 200px;
    }
</style>
