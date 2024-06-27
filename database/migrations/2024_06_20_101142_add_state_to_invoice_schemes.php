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
        Schema::table('invoice_schemes', function (Blueprint $table) {
            $table->string('resolution', 50)->nullable()->after('prefix');
            $table->date('start_date')->nullable()->after('resolution');
            $table->date('end_date')->nullable()->after('start_date');
            $table->string('end_number')->nullable()->after('end_date');
            $table->enum('is_fe',['si','no'])->default('no')->after('end_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_schemes', function (Blueprint $table) {
            //
        });
    }
};
