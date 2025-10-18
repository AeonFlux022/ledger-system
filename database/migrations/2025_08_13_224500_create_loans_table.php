<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrower_id')->constrained()->onDelete('cascade'); // Link to borrower
            $table->decimal('loan_amount', 12, 2);
            $table->decimal('interest_rate', 5, 2); // %
            $table->integer('terms'); // in months or weeks
            $table->decimal('processing_fee', 12, 2)->default(0);
            $table->date('due_date');
            $table->decimal('total_payable', 12, 2)->nullable();
            $table->decimal('outstanding_balance', 15, 2)->default(0);
            $table->decimal('monthly_amortization', 12, 2)->nullable();
            $table->decimal('overdue', 12, 2)->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected', 'active', 'overdue', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
