<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use App\Scopes\PersonScope;

class Person extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    public static $rules = array(
        'name' => 'required',
        'mail' => 'email',
        'age' => 'numeric|min:0|max:150',
    );

    protected static function boot()
    {
        parent::boot();

        // モデル利用時いつでも掛ける絞り込み条件GlobalScope
        // 無名関数版
        //static::addGlobalScope('age', function(Builder $builder) {
        //    $builder->where('age', '>', 30);
        //});
        // 別クラス版
        //static::addGlobalScope(new PersonScope);
    }

    public function toString()
    {
        return $this->id . ':' . $this->name . ' (' . $this->age . ')';
    }

    /*public*/ function scopeNameEqual($query, $nameStr)
    {
        return $query->where('name', $nameStr);
    }

    /*public*/ function scopeAgeGreaterThan($query, $age)
    {
        return $query->where('age', '>=', $age);
    }
    /*public*/ function scopeAgeLessThan($query, $age)
    {
        return $query->where('age', '<=', $age);
    }
}
