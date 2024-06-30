<?php

use App\Enums\SvgTypeFile\TypeFile;
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
        Schema::create('request_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id');
            $table->string('name');
            $table->string('path');
            $table->string('original_name');
            $table->string('display_name')->nullable();
            $table->string('type_file')->default(TypeFile::BLANK_IMAGE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_attachments');
    }
};
