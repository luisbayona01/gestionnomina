<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellidos')->after('name');
            $table->string('identificacion')->unique()->after('apellidos');
            $table->string('direccion')->nullable()->after('identificacion');
            $table->string('telefono')->nullable()->after('direccion');
            $table->unsignedBigInteger('ciudad_id')->nullable()->after('telefono');
            $table->unsignedBigInteger('role_id'); 
            $table->foreign('role_id')->references('id')->on('roles'); 
            $table->foreign('ciudad_id')->references('id')->on('ciudades');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['ciudad_id']);
            $table->dropColumn(['apellidos', 'identificacion', 'direccion', 'telefono', 'ciudad_id']);
        });
    }
}

