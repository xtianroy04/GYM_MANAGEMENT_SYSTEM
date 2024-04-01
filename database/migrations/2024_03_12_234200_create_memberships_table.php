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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->datetime('date_started')->nullable();
            $table->datetime('date_end')->nullable();
            $table->date('annual_date_started')->nullable();
            $table->date('annual_date_end')->nullable();
            $table->enum('status', ['Active', 'Expired', 'Cancelled'])->nullable();  
            $table->enum('subscription_status', ['Active', 'Expired', 'Inactive'])->nullable();   
            // $table->enum('subscription_status', ['Active', 'Cancelled'])->default('Active')default('Inactive');  
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
