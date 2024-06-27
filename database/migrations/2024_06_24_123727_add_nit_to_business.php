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
        Schema::table('business', function (Blueprint $table) {
            $table->string('nit',20)->nullable()->after('token');;
            $table->integer('dv')->nullable()->after('nit');;
            $table->string('merchant_registration')->nullable()->after('dv');;

            $table->unsignedBigInteger('type_document_identification_id')->nullable()->after('merchant_registration');;
            $table->foreign('type_document_identification_id')->references('id')->on('type_document_identifications');

            $table->unsignedBigInteger('type_organization_id')->nullable()->after('type_document_identification_id');;
            $table->foreign('type_organization_id')->references('id')->on('type_organizations');

            $table->unsignedBigInteger('type_regime_id')->nullable()->after('type_organization_id');;
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
        Schema::table('business', function (Blueprint $table) {
            //
        });
    }
};
