<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //
    protected $fillable = ['user_id', 'route', 'request'];

    public function user()
    {
        return $this->belongsTo('App\User')->withDefault([
            'type' => 'guest'
        ]);
    }

}
