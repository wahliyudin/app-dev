<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('request_workflows', function (Blueprint $table) {
            $table->id();
            $table->integer('sequence');
            $table->foreignId('request_id');
            $table->foreignId('nik');
            $table->string('title');
            $table->string('last_action');
            $table->dateTime('last_action_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_workflows');
    }
};
