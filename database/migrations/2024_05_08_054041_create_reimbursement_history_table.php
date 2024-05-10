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
        Schema::create('reimbursement_history', function (Blueprint $table) {
            $table->id();
            $table->integer('id_reimbursement');
            $table->integer('user_id');
            $table->string('status');
            $table->longText('deskripsi')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimbursement_history');

    }
};
