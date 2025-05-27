<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->unsignedBigInteger('scan_id'); // Foreign key to scans
            $table->unsignedBigInteger('user_id'); // Foreign key to users
            $table->string('comment');
            $table->timestamp('created_at')->useCurrent(); // Created timestamp

            // Foreign key constraints
            $table->foreign('scan_id')->references('scan_id')->on('scans')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}