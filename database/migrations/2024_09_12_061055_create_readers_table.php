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
        Schema::create('readers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['Laki-laki','Perempuan']);
            $table->string('phone')->nullable();
            $table->text('address');
            $table->date('date_of_birth');
            $table->string('agency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readers');
    }
};
