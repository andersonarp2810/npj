<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  protected $fillable = [
      'name','teacher_id','status','qtdPetitions'
  ];

  public function human()
  {
    return $this->belongsTo('App\Entities\Human');
  }

  public function doubleStudents()
  {
    return $this->hasMany('App\Entities\DoubleStudent');
  }
}
