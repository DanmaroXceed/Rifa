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
        Schema::create('ganadors', function (Blueprint $table) {
            $table->id();
            $table->string('numero_emp');
            $table->string('nombre');
            $table->string('area');
            $table->string('n_premio');
            $table->string('premio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ganadors');
    }
};
