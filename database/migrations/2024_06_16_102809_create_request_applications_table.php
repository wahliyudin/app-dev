<?php

use App\Enums\Request\Application\Status;
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
        Schema::create('request_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id');
            $table->string('name');
            $table->string('display_name');
            $table->string('logo')->nullable();
            $table->date('due_date')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default(Status::YET_TO_START->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_applications');
    }
};
