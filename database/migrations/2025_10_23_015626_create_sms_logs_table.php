<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('borrower_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('phone_number');
            $table->string('type')->nullable(); // e.g. approval, decline, reminder, payment
            $table->text('message');
            $table->boolean('success')->default(false);
            $table->text('response')->nullable(); // raw response from SMS gateway
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
