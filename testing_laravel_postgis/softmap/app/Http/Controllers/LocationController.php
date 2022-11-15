<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Meta;

use MStaack\LaravelPostgis\Geometries\Point;
use MStaack\LaravelPostgis\Geometries\LineString;
use MStaack\LaravelPostgis\Geometries\Polygon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function index()
    {
        $tables = DB::select("SELECT schemaname, tablename from pg_tables where schemaname like 'pool'");
        //$tables = Meta::all();
        $data =  ([
            'tables' => $tables,
        ]);
        return view('tables', $data);
    }
    
    public function create()
    {
        $linestring = new LineString(
            [
                new Point(0, 0),
                new Point(0, 1),
                new Point(1, 1),
                new Point(1, 0),
                new Point(0, 0)
            ]
        );

        $location1 = new Location();
        $location1->name = 'Googleplex';
        $location1->address = '1600 Amphitheatre Pkwy Mountain View, CA 94043';
        $location1->location = new Point(37.422009, -122.084047);
        $location1->location2 = new Point(37.422009, -122.084047);
        $location1->location3 = new Point(37.422009, -122.084047);
        $location1->polygon = new Polygon([$linestring]);
        $location1->polygon2 = new Polygon([$linestring]);
        $location1->save();
        
        //$location2 = Location::first();
        //$location2->location instanceof Point // true
    }

    public function leaflet()
    {
        $data = array();
        return view('leaflet', $data);
    }
    public function openlayers()
    {
        $data = array();
        return view('openlayers', $data);
    }
    public function geojson()
    {
        $d = Location::all();
        /* $d = ([
            'name' => 'Abigail',
            'state' => 'CA'
        ]);*/
        return response()->json($d);
    }

}
