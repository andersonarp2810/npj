<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
  protected $fillable = [
      'title','content', 'teacher_id','status'
  ];

  public function human()
  {
    return $this->belongsTo('App\Entities\Human');
  }

  public function petition()
  {
      return $this->hasOne('App\Entities\Petition');
  }
}
