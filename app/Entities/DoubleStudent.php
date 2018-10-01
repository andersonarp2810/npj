<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class DoubleStudent extends Model
{

  protected $fillable = [
      'student_id','student2_id','group_id','status','qtdPetitions'
  ];


  public function group()
  {
    return $this->belongsTo('App\Entities\Group');
  }

  public function human()
  {
    return $this->belongsTo('App\Entities\Human');
  }

  public function petitions()
  {
    return $this->hasMany('App\Entities\Petition');
  }
}
