<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Board extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    public static $rules = array(
        'person_id' => 'required',
        'title' => 'required',
        'message' => 'required',
    );

    public function person()
    {
        //DB::enableQueryLog();
        $response = $this->belongsTo('App\Models\Person');
        //$log = DB::getQueryLog();
        //Log::debug('relation');
        //Log::debug($log);
        //DB::disableQueryLog();
        return $response; //$this->belongsTo('App\Models\Person');
    }

    public function toString()
    {
        return $this->id . ':' . $this->title .'(' . $this->person->name . ')';
    }

}
