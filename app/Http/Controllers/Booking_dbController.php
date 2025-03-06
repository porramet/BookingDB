<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class Booking_dbController extends Controller
{
    public function index(Request $request)
    {
        // Fetch bookings and pass to view
        $bookings = Booking::with(['user', 'room', 'status'])->get(); // Fetch related user, room, and status data
        $totalBookings = $bookings->count();
        $pendingApprovals = $bookings->where('status_id', 'pending')->count();
        $approvedBookings = $bookings->where('status_id', 'approved')->count();

        return view('dashboard.booking_db', compact('bookings', 'totalBookings', 'pendingApprovals', 'approvedBookings'));
    }

    public function approve($id)
    {
        $booking = Booking::find($id);
        if ($booking) {
            $booking->status_id = 'approved'; // Update status to approved
            $booking->room_name = $booking->room ? $booking->room->name : null;
            $booking->status_name = 'approved'; // Set status name to 'approved'
            $booking->building_name = $booking->building ? $booking->building->name : null;
            $booking->save();
        }
        return redirect()->route('booking_db')->with('success', 'Booking approved successfully.');
    }

    public function reject($id)
    {
        $booking = Booking::find($id);
        if ($booking) {
            $booking->status_id = 'rejected'; // Update status to rejected
            $booking->room_name = $booking->room ? $booking->room->name : null;
            $booking->status_name = 'rejected'; // Set status name to 'rejected'
            $booking->building_name = $booking->building ? $booking->building->name : null;
            $booking->save();
        }
        return redirect()->route('booking_db')->with('success', 'Booking rejected successfully.');
    }
}
