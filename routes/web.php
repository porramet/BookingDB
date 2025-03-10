<?php

use Illuminate\Support\Facades\Route;

Route::get('/booking/approve/{id}', [Booking_dbController::class, 'approve'])->name('booking.approve');
Route::get('/booking/reject/{id}', [Booking_dbController::class, 'reject'])->name('booking.reject');

use App\Http\Controllers\{
    Booking_dbController,
    Auth\RegisterController,
    Auth\LoginController,
    UserController,
    DashboardController,
    ManageBuildingsController,
    ManageRoomsController,
    ManageUsersController,
    BuildingController,
    CalendarController,
    BookingHistoryController,
    BookingController
};



// Public routes
Route::get('/', function () {
    return view('index');
});
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/{room_id}', [BookingController::class, 'showBookingForm'])->name('booking.form');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
});

//Route::get('/booking/{room_id}', [BookingController::class, 'store'])->name('booking');
Route::get('/bookings/{id}', [BookingController::class, 'showBookingForm'])->name('bookings.show');


Route::get('/buildings/{id}/rooms', [BuildingController::class, 'fetchRooms']);
Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index'); // Added route for buildings
Route::get('/buildings/{id}', [BuildingController::class, 'show'])->name('buildings.show'); // Route for showing a specific building
Route::get('/buildings/{id}/rooms', [BuildingController::class, 'fetchRooms'])->name('buildings.fetchRooms'); // Route to fetch rooms for a specific building


Route::get('/how-to-use', function () { return view('how_to_use'); });
Route::get('/usage', function () { return view('usage'); });
Route::get('/contact', function () { return view('contact'); });

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration routes
Route::get('/register', function () { return view('register'); })->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Admin routes
Route::middleware(['auth', 'can:admin-only'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
    Route::get('/available-rooms', [BookingController::class, 'getAvailableRooms'])->name('available.rooms');
Route::post('/create-booking', [BookingController::class, 'store'])->name('create.booking');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Booking management
    Route::get('/booking_db', [Booking_dbController::class, 'index'])->name('booking_db'); 
    //Route::delete('/booking_db/{id}', [Booking_dbController::class, 'destroy'])->name('booking_db.destroy');
    //Route::put('/booking_db/{id}', [Booking_dbController::class, 'update'])->name('booking_db.update');
    //Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::patch('/booking/{id}/update-status', [Booking_dbController::class, 'updateStatus'])->name('booking.update-status');

    // สำหรับดูประวัติการจอง
    Route::get('/booking_history', [BookingHistoryController::class, 'index'])->name('booking.history');
    
    // Room management
    Route::get('/manage-rooms', [ManageRoomsController::class, 'index'])->name('manage_rooms.index');
    Route::get('/manage-rooms/{buildingId}/rooms', [ManageRoomsController::class, 'showRooms'])->name('manage_rooms.show');
    Route::post('/rooms', [ManageRoomsController::class, 'store'])->name('manage_rooms.store');
    Route::get('/rooms/{id}', [ManageRoomsController::class, 'showRoomDetails'])->name('manage_rooms.details');
    Route::get('/rooms/{room}/edit', [ManageRoomsController::class, 'edit'])->name('manage_rooms.edit');
    Route::put('/rooms/{room}', [ManageRoomsController::class, 'update'])->name('manage_rooms.update');
    Route::delete('/manage_rooms/{room}', [ManageRoomsController::class, 'deleteRoom'])->name('manage_rooms.destroy');

    // User management routes
    Route::get('/manage-users', [ManageUsersController::class, 'index'])->name('manage_users.index');
    Route::put('/manage-users/{id}', [ManageUsersController::class, 'update'])->name('manage_users.update');
    Route::delete('/manage-users/{id}', [ManageUsersController::class, 'destroy'])->name('manage_users.destroy');
    Route::get('/booking_db', [Booking_dbController::class, 'index'])->name('booking_db'); 
    Route::get('/booking-history', [BookingHistoryController::class, 'index'])->name('booking_history');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    
    // Building management
    Route::get('/manage-buildings', [ManageBuildingsController::class, 'index'])->name('manage.buildings');
    Route::post('/manage-buildings', [ManageBuildingsController::class, 'store'])->name('manage.buildings.store');
    Route::resource('manage/buildings', ManageBuildingsController::class);
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () { return view('profile'); });
    Route::post('/profile/update', [RegisterController::class, 'update'])->name('profile.update');
    Route::post('/user/change-password', [UserController::class, 'changePassword'])->name('user.changePassword');
});

// Booking routes
Route::post('/book-room/{id}', [BookingController::class, 'bookRoom'])->name('book.room'); // Route for booking a room
