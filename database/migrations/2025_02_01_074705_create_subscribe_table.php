<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('subscribe', function (Blueprint $table) {
        $table->id(); // Kolom id (primary key, auto increment)
        $table->string('email', 100)->unique(); // Kolom email (string, max 100 karakter, unique)
        $table->timestamps(); // Kolom created_at dan updated_at
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribe'); // Hapus tabel jika migration di-rollback
    }
}