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
        Schema::table('reimbursement', function (Blueprint $table) {
            $table->integer('from_user');
            $table->integer('to_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reimbursement', function (Blueprint $table) {
            $table->dropColumn(['from_user','to_user']);
        });
    }
};
