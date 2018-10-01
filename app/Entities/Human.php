<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Human extends Model
{
      protected $fillable = [
          'status','name','phone','gender','user_id','doubleS','groupT'
      ];

      public function user()
      {
          return $this->belongsTo('App\User')->withDefault([
            'email'=> 'Nenhum cadastrado'
          ]);
      }

      public function templates()
      {
        return $this->hasMany('App\Entities\Template');
      }

      public function petitions()
      {
        return $this->hasMany('App\Entities\Petition');
      }

      public function group()
      {
        return $this->hasOne('App\Entities\Group');
      }

      public function doubleStudent()
      {
        return $this->hasOne('App\Entities\DoubleStudent');
      }
}
