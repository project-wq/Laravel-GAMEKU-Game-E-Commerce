<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropColumn('catatan');
            $table->dropColumn('metode_bayar');
            $table->dropColumn('nomor_pemesanan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->string('catatan')->nullable();
            $table->string('metode_bayar')->nullable();
            $table->string('nomor_pemesanan')->nullable();
        });
    }
};
