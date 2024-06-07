<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->string('serialNumber')->unique();
            $table->foreignId('car_id')->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
