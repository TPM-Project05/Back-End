<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id(); // Kolom id (primary key, auto increment)
            $table->string('name', 100); // Kolom name (string, max 100 karakter)
            $table->string('email', 100); // Kolom email (string, max 100 karakter)
            $table->string('subject', 255); // Kolom subject (string, max 255 karakter)
            $table->text('message'); // Kolom message (text, untuk teks panjang)
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
        Schema::dropIfExists('contact_us'); // Hapus tabel jika migration di-rollback
    }
}