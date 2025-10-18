<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Change ENUM values to include 'rejected'
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('pending', 'approved', 'active', 'overdue', 'completed', 'rejected') DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Revert to the original ENUM values
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('pending', 'approved', 'active', 'overdue', 'completed') DEFAULT 'pending'");
    }
};
