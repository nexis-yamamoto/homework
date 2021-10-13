<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    // たぶんなくても動作するけど明示したいときはこう
    protected $table = 'bookmarks';
    protected $guarded = array('id');

    public static $rules = array(
        'message' => 'required',
        'url' => 'required'
    );

    public function toString()
    {
        return $this->id . ':' . $this->url . '=' . $this->message;
    }

}
