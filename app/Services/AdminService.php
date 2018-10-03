<?php

namespace App\Services;

use App\User;
use App\Entities\Comment;
use App\Entities\DoubleStudent;
use App\Entities\Group;
use App\Entities\Human;
use App\Entities\Petition;
use App\Entities\Template;
use Illuminate\Http\Request;
use Auth;
use Validator;

class AdminService{


    public function index(){
        
    $count = 1;
    //
    $countG = 1;
    //
    $doubleStudents = DoubleStudent::all()->where('status','active')->sortByDesc('qtdPetitions');
    //
    $humans = Human::all()->where('status','active');
     //
     $petitions = Petition::all();
     //
     $groups = Group::all()->where('status','active')->sortByDesc('qtdPetitions');
     //
     $templates = Template::all()->where('status','active');
     //
     $comments = Comment::all();
     //
     $users = User::all();
     //

     return ['count'=>$count,'countG'=>$countG,'doubleStudents'=>$doubleStudents,'humans'=>$humans,'petitions'=>$petitions,'groups'=>$groups,'templates'=>$templates, 'comments'=>$comments, 'users'=>$users];
    }

    public function editar(Human $human, User $user, Request $request){
        
   $human->name = $request['name'];
   $human->gender = $request['gender'];
   $human->phone = $request['phone'];
   $user->email = $request['email'];

   if($request['password'] != null){
     $user->password = $request['password'];
   }
   $human->save();
   $user->save();
   $request->session()->flash('status', 'Dados salvos com sucesso!!');

    return redirect()->back();

    }
}