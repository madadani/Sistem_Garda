<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixTransactionStatusColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Menggunakan SQL mentah untuk menghindari ketergantungan doctrine/dbal
        \DB::statement("ALTER TABLE transactions MODIFY COLUMN status VARCHAR(20) DEFAULT 'PENDING'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kembalikan ke asal jika perlu, namun VARCHAR(20) sudah cukup aman
        \DB::statement("ALTER TABLE transactions MODIFY COLUMN status VARCHAR(191)");
    }
}
