<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use MStaack\LaravelPostgis\Schema\Blueprint;



class UpperController extends Controller
{
    public function create()
    {
        Schema::dropIfExists('tests');

        Schema::connection('pool')->create('tests', function (Blueprint $table) {
            $table->id();
            //$table->string('address')->unique();
            //$table->point('location'); // GEOGRAPHY POINT column with SRID of 4326 (these are the default values).
            $table->point('location', 'GEOMETRY', 27700); // GEOMETRY column with SRID of 27700.
            $table->timestamps();
        });

    }
}
