<?php

namespace App\Filters;

use App\User;


class ThreadFilters extends Filters{

  protected $filters = ['by'];
  
  public function by($username){
    $user = User::where('name',$username)->firstOrFail();//pega usuário

    return $this->builder->where('user_id',$user->id);//retorna threads do usuario
  }

}
