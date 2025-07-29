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
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->string('address');
            $table->string('contact_number');
            $table->string('email')->nullable(); // Add unique() if you require it to be unique
            $table->string('id_card');
            $table->string('id_image')->nullable(); // stores path to uploaded file
            $table->decimal('income', 10, 2)->nullable(); // adjust precision if needed
            $table->string('employment_status'); // employed or unemployed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowers');
    }
};
