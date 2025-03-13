<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Building;

class BookingController extends Controller
{
    // ข้อมูลวันหยุดประจำปี 2025
    private $holidays = [
        '2025-01-01' => 'วันขึ้นปีใหม่',
        '2025-02-10' => 'วันมาฆบูชา',
        '2025-04-06' => 'วันจักรี',
        '2025-04-13' => 'วันสงกรานต์',
        '2025-04-14' => 'วันสงกรานต์',
        '2025-04-15' => 'วันสงกรานต์',
        '2025-05-01' => 'วันแรงงานแห่งชาติ',
        '2025-05-05' => 'วันฉัตรมงคล',
        '2025-05-13' => 'วันพืชมงคล',
        '2025-06-03' => 'วันเฉลิมพระชนมพรรษาสมเด็จพระราชินี',
        '2025-07-11' => 'วันอาสาฬหบูชา',
        '2025-07-12' => 'วันเข้าพรรษา',
        '2025-07-28' => 'วันเฉลิมพระชนมพรรษา ร.10',
        '2025-08-12' => 'วันแม่แห่งชาติ',
        '2025-10-13' => 'วันคล้ายวันสวรรคต ร.9',
        '2025-10-23' => 'วันปิยมหาราช',
        '2025-12-05' => 'วันพ่อแห่งชาติ/วันชาติ',
        '2025-12-10' => 'วันรัฐธรรมนูญ',
        '2025-12-31' => 'วันสิ้นปี'
    ];

    public function index()
    {
        $buildings = Building::with('rooms')->get();
        $rooms = Room::with('status')->get();
        return view('index', compact('buildings', 'rooms'));
    }

    public function showBookingForm($id)
    {
        $room = Room::findOrFail($id);

        $bookedDates = Booking::where('room_id', $id)
            ->whereIn('status_id', [1, 2, 3]) 
            ->get(['booking_start', 'booking_end', 'external_name']);

        // สร้าง array ของวันที่จองแล้วพร้อมข้อมูลผู้จอง
        $bookedDetails = [];
        foreach ($bookedDates as $booking) {
            $period = new \DatePeriod(
                new \DateTime($booking->booking_start),
                new \DateInterval('P1D'),
                (new \DateTime($booking->booking_end))->modify('-1 day')
            );
            
            $bookingInfo = "จองโดย: " . mb_substr($booking->external_name, 0, 1) . "xxx";
            
            foreach ($period as $date) {
                $formattedDate = $date->format('Y-m-d');
                $bookedDetails[$formattedDate] = $bookingInfo;
            }
        }

        // ส่งข้อมูลวันหยุดพร้อมชื่อวันหยุด
        $holidaysWithNames = $this->holidays;
        
        // ส่งรายการวันที่ไม่สามารถจองได้ทั้งหมด
        $disabledDays = array_merge(array_keys($bookedDetails), array_keys($holidaysWithNames));

        return view('partials.booking-form', compact('room', 'disabledDays', 'holidaysWithNames', 'bookedDetails'));
    }

    public function store(Request $request)
    {
        try {
            \Log::debug('Incoming booking request:', $request->all());
            
            \Log::debug('Validating request data:', $request->all());
            $validated = $request->validate([
                'room_id' => 'required|exists:rooms,room_id',
                'building_id' => 'required|exists:buildings,id',
                'room_name' => 'required|string|max:255',  // ✅ เพิ่ม
                'building_name' => 'required|string|max:255', // ✅ เพิ่ม
                'external_name' => 'required|string|max:255',
                'external_email' => 'required|email|max:255',
                'external_phone' => 'required|string|max:20',
                'booking_start' => 'required|date|after:now',
                'booking_end' => 'required|date|after:booking_start',
                'reason' => 'nullable|string',
                //'payment_slip' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Validate payment slip
            ]);

            // ตรวจสอบว่าวันที่จองอยู่ในวันหยุดหรือไม่
            $startDate = new \DateTime($validated['booking_start']);
            $endDate = new \DateTime($validated['booking_end']);
            $holidays = array_keys($this->holidays);
            
            // ตรวจสอบช่วงวันที่จองว่ามีวันหยุดหรือไม่
            $holidayInRange = false;
            $holidayName = '';
            
            $period = new \DatePeriod(
                $startDate,
                new \DateInterval('P1D'),
                $endDate->modify('+1 day')
            );
            
            foreach ($period as $date) {
                $formattedDate = $date->format('Y-m-d');
                if (in_array($formattedDate, $holidays)) {
                    $holidayInRange = true;
                    $holidayName = $this->holidays[$formattedDate];
                    break;
                }
            }
            
            if ($holidayInRange) {
                return back()->with('error', "ไม่สามารถจองห้องในวันหยุดนักขัตฤกษ์ได้ ({$holidayName})");
            }

            // ตรวจสอบการซ้อนทับกับการจองอื่น
            $conflictingBooking = Booking::where('room_id', $validated['room_id'])
                ->whereIn('status_id', [1, 2, 3])
                ->where(function($query) use ($validated) {
                    $query->where(function($q) use ($validated) {
                        // กรณีวันเริ่มต้นหรือวันสิ้นสุดของการจองใหม่อยู่ในช่วงการจองที่มีอยู่
                        $q->whereBetween('booking_start', [$validated['booking_start'], $validated['booking_end']])
                          ->orWhereBetween('booking_end', [$validated['booking_start'], $validated['booking_end']]);
                    })
                    ->orWhere(function($q) use ($validated) {
                        // กรณีการจองที่มีอยู่ครอบคลุมการจองใหม่ทั้งหมด
                        $q->where('booking_start', '<=', $validated['booking_start'])
                          ->where('booking_end', '>=', $validated['booking_end']);
                    });
                })
                ->exists();

            if ($conflictingBooking) {
                return back()->with('error', 'ห้องไม่ว่างในช่วงเวลาที่เลือก กรุณาเลือกเวลาอื่น');
            }

            $room = Room::find($validated['room_id']);
            $start = new \DateTime($validated['booking_start']);
            $end = new \DateTime($validated['booking_end']);
            $days = $end->diff($start)->days;
            $totalPrice = $room->service_rates * $days;

            $booking = new Booking();
            $booking->fill($validated);
            $booking->status_id = 3;
            $booking->is_external = true;
            $booking->total_price = $totalPrice;
            if (auth()->check()) {
                $booking->user_id = auth()->id();
            }
            // Debugging: Log the files in the request
            \Log::debug('Uploaded files:', $request->files->all());
            
            // Handle file upload
            if ($request->hasFile('payment_slip')) {
                \Log::debug('Payment slip file detected:', $file->getClientOriginalName());
                $file = $request->file('payment_slip');
                $filePath = $file->store('uploads', 'public'); // Store file in public/uploads
                $booking->payment_slip = $filePath; // Save file path in the database
            }
            $booking->save();

            return redirect('http://127.0.0.1:8000/booking')->with('success', 'การจองห้องสำเร็จ! กรุณาตรวจสอบอีเมลของคุณ');
        } catch (\Exception $e) {
            \Log::error('Booking failed: ' . $e->getMessage(), ['request' => $request->all()]);
            return back()->with('error', 'เกิดข้อผิดพลาดในการจอง: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return view('dashboard.booking_show', compact('booking'));
    }
}
