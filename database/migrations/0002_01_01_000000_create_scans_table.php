<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('scans', function (Blueprint $table) {
            $table->id('scan_id');
            $table->unsignedBigInteger('user_id');

            $table->string('scan_title');
            $table->string('scan_type')->default('url');
            $table->string('scan_result');
            $table->text('full_report');
            $table->timestamps();

            // Explicitly reference 'user_id' on the users table
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scans');
    }
};
