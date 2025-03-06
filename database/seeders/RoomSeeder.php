<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // ลoop เพื่อสร้างห้องตัวอย่าง
        for ($i = 0; $i < 10; $i++) {
            DB::table('rooms')->insert([
                'building_id' => $faker->numberBetween(1, 3), // สมมุติว่าเรามี 3 อาคาร

                'room_id' => $faker->unique()->numberBetween(1, 100), // รหัสห้องที่ไม่ซ้ำกัน
                'room_name' => $faker->word, // ชื่อห้อง
                'class' => $faker->word, // ชั้น
                'room_details' => $faker->sentence, // รายละเอียดห้อง
                'image' => 'https://via.placeholder.com/150', // ตัวอย่าง URL รูปภาพ
                'capacity' => $faker->numberBetween(1, 50), // ขนาดความจุ
                'service_rates' => $faker->randomFloat(2, 100, 1000), // อัตราค่าบริการ
                'status_id' => 1, // สมมุติว่า 1 คือสถานะ "ว่าง"
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}

