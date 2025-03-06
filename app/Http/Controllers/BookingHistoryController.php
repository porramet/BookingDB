<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Ensure the Booking model is imported

class BookingHistoryController extends Controller
{
    public function index()
    {
        // Fetch all booking history and pass them to the view
        $bookingHistory = Booking::all(); // Adjust this to fetch only relevant history
        return view('dashboard.booking_history', compact('bookingHistory'));
    }

    public function fetchBookingHistory()
    {
        // Logic to fetch booking history data from the database
        return Booking::all(); // Adjust this to fetch only relevant history
    }

    public function displayBookingHistory()
    {
        // Logic to format and display booking history data
    }
}
