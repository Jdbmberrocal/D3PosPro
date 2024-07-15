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
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('merchant_registration')->nullable()->after('name');
            $table->unsignedBigInteger('department_id')->nullable()->after('merchant_registration');
            $table->foreign('department_id')->references('id')->on('departments');

            $table->unsignedBigInteger('municipality_id')->nullable()->after('department_id');
            $table->foreign('municipality_id')->references('id')->on('municipalities');

            $table->unsignedBigInteger('country_id')->nullable()->after('municipality_id');
            $table->foreign('country_id')->references('id')->on('countries');

            $table->unsignedBigInteger('type_document_identification_id')->nullable()->after('country_id');
            $table->foreign('type_document_identification_id')->references('id')->on('type_document_identifications');

            $table->unsignedBigInteger('type_regime_id')->nullable()->after('type_document_identification_id');
            $table->foreign('type_regime_id')->references('id')->on('type_regimes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            //
        });
    }
};
