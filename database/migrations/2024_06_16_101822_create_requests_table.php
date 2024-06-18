<?php

use App\Enums\Workflows\Status;
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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('nik_requestor');
            $table->string('job_title');
            $table->string('department');
            $table->foreignId('application_id');
            $table->foreignId('nik_pic');
            $table->date('estimated_project');
            $table->string('email');
            $table->date('date');
            $table->string('type_request');
            $table->string('type_budget');
            $table->text('description');
            $table->string('status')->default(Status::OPEN->value);
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
