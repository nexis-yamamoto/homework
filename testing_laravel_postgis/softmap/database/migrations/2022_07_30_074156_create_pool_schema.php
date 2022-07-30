<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::connection($this->getConnection())->unprepared("
        SET search_path to public;
        CREATE SCHEMA pool;");
//        SET search_path to administracion;");
    }

    public function down()
    {
        DB::connection($this->getConnection())->unprepared("
        DROP SCHEMA IF EXISTS pool;");
    }
};
