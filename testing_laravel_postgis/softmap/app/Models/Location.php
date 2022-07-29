<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use MStaack\LaravelPostgis\Eloquent\PostgisTrait;
use MStaack\LaravelPostgis\Geometries\Point;

class Location extends Model
{
    use HasFactory;

    use PostgisTrait;

    protected $fillable = [
        'name',
        'address'
    ];

    protected $postgisFields = [
        'location',
        'location2',
        'location3',
        'polygon',
        'polygon2'
    ];

    protected $postgisTypes = [
        'location' => [
            'geomtype' => 'geography',
            'srid' => 4326
        ],
        'location2' => [
            'geomtype' => 'geography',
            'srid' => 4326
        ],
        'location3' => [
            'geomtype' => 'geometry',
            'srid' => 27700
        ],
        'polygon' => [
            'geomtype' => 'geography',
            'srid' => 4326
        ],
        'polygon2' => [
            'geomtype' => 'geometry',
            'srid' => 27700
        ]
        ];
}


