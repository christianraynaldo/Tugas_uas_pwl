<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konsumen_id')->constrained('konsumens');
            $table->string('kode_order')->unique();
            $table->date('tanggal_order');
            $table->integer('total');
            $table->integer('ongkir');
            $table->string('ekspedisi');
            $table->string('bukti_bayar')->nullable();
            $table->string('invoice_pdf')->nullable();
            $table->enum('status', ['belum bayar', 'sudah bayar', 'dikirim', 'diterima'])->default('belum bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
