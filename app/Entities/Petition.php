<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Petition extends Model
{
  protected $fillable = [
      'description','content', 'student_ok','teacher_ok','defender_ok', 'template_id','defender_id','doubleStudent_id','group_id','version','visible','petitionFirst',
  ];

  public function human()
  {
    return $this->belongsTo('App\Entities\Human');
  }

  public function template()
  {
    return $this->belongsTo('App\Entities\Template');
  }

  public function doubleStudent()
  {
    return $this->belongsTo('App\Entities\DoubleStudent');
  }

  public function comments()
  {
    return $this->hasMany('App\Entities\Comment');
  }
}
