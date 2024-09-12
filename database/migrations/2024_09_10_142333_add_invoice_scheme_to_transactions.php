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
            // $table->unsignedBigInteger('invoice_scheme_id')->nullable()->after('selling_price_group_id');
            // $table->foreign('invoice_scheme_id')->references('id')->on('invoice_schemes');

            $table->unsignedBigInteger('invoice_scheme_id')->after('selling_price_group_id');
 
            
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
            $table->dropForeign(['invoice_scheme_id']);
            $table->dropColumn('invoice_scheme_id');
        });
    }
};
