<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_histories', function (Blueprint $table) {
            $table->id(); // รหัสประวัติการจอง
            $table->unsignedBigInteger('booking_id'); // รหัสการจอง
            $table->unsignedBigInteger('status_id'); // รหัสสถานะที่เปลี่ยนไป
            $table->text('note')->nullable(); // หมายเหตุเกี่ยวกับการเปลี่ยนแปลงสถานะ
            $table->timestamp('changed_at')->useCurrent(); // เวลาที่เปลี่ยนสถานะ
            $table->unsignedBigInteger('changed_by')->nullable(); // ผู้ที่เปลี่ยนสถานะ (อาจเป็น admin)
            
            // ข้อมูลผู้จอง (ทั้งบุคคลภายในและบุคคลภายนอก)
            $table->unsignedBigInteger('user_id')->nullable(); // รหัสผู้ใช้ภายใน
            $table->string('external_name')->nullable(); // ชื่อผู้จอง (ถ้าเป็นบุคคลภายนอก)
            $table->string('external_email')->nullable(); // อีเมลของบุคคลภายนอก
            $table->string('external_phone')->nullable(); // เบอร์โทรของบุคคลภายนอก
            $table->boolean('is_external')->default(false); // ระบุว่าผู้จองเป็นบุคคลภายนอกหรือไม่

            // Foreign keys
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('status_id')->references('status_id')->on('status')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_histories');
    }
};
