<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $fillable = [
      'content', 'human_id', 'petition_id'
  ];

  public function petition()
  {
    return $this->belongsTo('App\Entities\Petition');
  }

  public function human()
  {
    return $this->belongsTo('App\Entities\Human');
  }
}
