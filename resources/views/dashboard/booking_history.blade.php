@extends('layouts.main')

@section('content')
<div>
    <div class="col-md-10 content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>ประวัติการจองห้อง</h2>
            <div class="d-flex align-items-center">
                <input class="search-bar" placeholder="ค้นหาบางอย่าง" type="text"/>
                <button class="icon-btn">
                    <i class="fas fa-cog"></i>
                </button>
                <button class="icon-btn">
                    <i class="fas fa-bell"></i>
                </button>
                <img alt="Profile image" class="profile-img" src="https://placehold.co/40x40"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>รายการประวัติการจองห้อง</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ห้อง</th>
                                    <th>ผู้จอง</th>
                                    <th>วันที่จอง</th>
                                    <th>เวลา</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookingHistory as $history)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $history->room }}</td>
                                    <td>{{ $history->user }}</td>
                                    <td>{{ $history->date }}</td>
                                    <td>{{ $history->time }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ ucfirst($history->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item"><a class="page-link" href="#" tabindex="-1">ก่อนหน้า</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">ถัดไป</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
