<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = Status::all()->isEmpty() ? [
            ['status_id' => 1, 'status_name' => 'ไม่ว่าง'], // Not Available
            ['status_id' => 2, 'status_name' => 'ว่าง'],     // Available
            ['status_id' => 3, 'status_name' => 'ไม่พร้อมใช้งาน'] // Not Ready for Use
        ] : []; // Ensure statuses are only created if the table is empty

        foreach ($statuses as $status) {
            if (!Status::where('status_id', $status['status_id'])->exists()) { // Check if status already exists
                Status::create($status);
            }
        }
    }
}