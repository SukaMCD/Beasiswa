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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id_order');
            $table->unsignedBigInteger('id_user');
            $table->string('external_id')->unique(); // Xendit Invoice ID / Order Ref
            $table->decimal('total_amount', 15, 2);
            $table->string('payment_status')->default('PENDING'); // PENDING, PAID, EXPIRED
            $table->string('payment_url')->nullable();
            $table->timestamps();

            // Removing FK constraint to avoid mismatch issues with custom users table
            // $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_order');
            $table->unsignedBigInteger('id_produk');
            $table->string('nama_produk'); // Snapshot name
            $table->decimal('harga_satuan', 15, 2); // Snapshot price
            $table->integer('jumlah');
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->foreign('id_order')->references('id_order')->on('orders')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
