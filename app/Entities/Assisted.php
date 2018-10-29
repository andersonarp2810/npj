<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Assisted extends Model
{
    //

    protected $fillalbe = ['name', 'rg', 'cpf', 'telefone'];

    protected $hidden = ['status'];

    public function petitions(){
        return $this->hasMany('App\Entities\Petition');
    }
}
