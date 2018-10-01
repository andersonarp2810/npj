<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
  protected $fillable = [
      'photo','petition_id',
  ];

  public function petition()
  {
    return $this->belongsTo('App\Entities\Petition');
  }
}
