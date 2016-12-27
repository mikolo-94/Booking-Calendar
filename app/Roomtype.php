<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Roomtype extends Model
{
    //Fields that can be massassigned
    protected $fillable = [
        'roomtype',
        'price',
        'availability'
    ];

    public function calendar()
    {
        return $this->hasMany('App\Calendar');
    }
}
