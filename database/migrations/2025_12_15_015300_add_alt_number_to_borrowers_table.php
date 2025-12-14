<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('borrowers', function (Blueprint $table) {
            $table->string('alt_number')->nullable()->after('contact_number');
        });
    }

    public function down()
    {
        Schema::table('borrowers', function (Blueprint $table) {
            $table->dropColumn('alt_number');
        });
    }

};
