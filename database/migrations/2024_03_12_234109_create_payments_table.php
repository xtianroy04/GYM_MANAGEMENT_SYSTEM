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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id'); // kani
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['Cash', 'GCash'])->default('Cash');  
            $table->string('transaction_code')->nullable();
            $table->enum('payment_for', ['Session','Monthly', 'Bi-Monthly', '6 Months', '1 Year', 'Annual-Fee'])->default('Monthly');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
