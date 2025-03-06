<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoomBookingsApp Dashboard</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script> <!-- Include app.js here -->
    
    <style>
        /* Existing styles */

        body {
            background-image: url('{{ asset('images/bg-1.jpg') }}');
            background-size: cover;
            background-position: center;
        }
        .sidebar {
            background-color: #fff;
            height: 100vh;
            padding: 20px;
            border-right: 1px solid #e0e0e0;
        }
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
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <h4 class="mb-4">RoomBookingsApp</h4>
                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-home"></i> แดชบอร์ด</a>
                    <a class="nav-link" href="{{ route('booking_db') }}"><i class="fas fa-calendar-alt"></i> การจองห้อง</a>
                    <a class="nav-link" href="{{ route('manage_rooms.index') }}"><i class="fas fa-building"></i> จัดการห้องและอาคาร</a>

                    <a class="nav-link" href="{{ route('booking_history') }}"><i class="fas fa-history"></i> ประวัติการจองห้อง</a>
                    <a class="nav-link" href="{{ route('calendar') }}"><i class="fas fa-calendar"></i> ปฏิทิน</a>
                    <a class="nav-link" href="{{ route('manage_users.index') }}"><i class="fas fa-users-cog"></i> จัดการผู้ใช้</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</button>
                    </form>                    
                </nav>
            </div>
            <div class="col-md-10 content">
                @yield('content')
                @yield('scripts')
            </div>
        </div>
    </div>
</body>
</html>
