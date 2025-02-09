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
        Schema::create('leaders', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone')->unique();
            $table->string('line_id')->unique();
            $table->string('github_id');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('cv');
            $table->string('flazz_card')->nullable();
            $table->string('id_card')->nullable();
            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('cascade'); // Relasi dengan tabel teams
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaders');
    }
};
