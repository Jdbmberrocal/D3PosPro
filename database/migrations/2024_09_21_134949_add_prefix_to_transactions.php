<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('prefix', 10)->nullable()->after('invoice_no');
            $table->integer('number_invoice')->nullable()->after('prefix');
            $table->string('resolution')->nullable()->after('number_invoice');
            $table->integer('counter_resend')->default(0)->after('resolution');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('prefix');
            $table->dropColumn('number_invoice');
            $table->dropColumn('resolution');
            $table->dropColumn('counter_resend');
        });
    }
};
