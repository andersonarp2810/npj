<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Human;
use App\Entities\Petition;
use App\Entities\Group;
use App\Entities\DoubleStudent;
use App\User;
use Auth;
use Validator;

use App\Services\TeacherService;

class TeacherController extends Controller
{

  public function __construct(TeacherService $service) {
    $this->service = $service;
  }

  public function index()
  {

    if(Auth::user()->type == 'admin'){
      $teachers = Human::all()->where('status','=','active');
      return view('admin.teacher')->with(['teachers'=>$teachers]);
    }else if(Auth::user()->type == 'teacher'){
      $teacher = Human::all()->where('user_id','=',Auth::user()->id)->where('status','=','active')->first();

      $group = Group::all()->where('status','=','active')->where('teacher_id','=',$teacher->id)->first();

      if($group == null){
        return redirect('Sair');
      }

      $doubleStudents = DoubleStudent::all()->where('status','=','active')->where('group_id',$group->id)->sortByDesc('qtdPetitions');;

      $petitions = Petition::all()->where('group_id',$group->id);

      $humans = Human::all()->where('status','=','active');
      $user = Auth::user();
      $count = 1;
      return view('teacher.home')->with(['teacher'=>$teacher,'group'=>$group,'doubleStudents'=>$doubleStudents,'petitions'=>$petitions,'humans'=>$humans,'user'=>$user,'count'=>$count]);
    }else{
      return redirect()->back();
    }
  }

  public function store(Request $request)
  {
    if(Auth::user()->type != 'admin') {
      return redirect()->back();
    }
    return $this->service->store($request);
  }

  public function update(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    } 
    $human = Human::find($request['id']);
    $user = User::find($human->user_id);

    return $this->service->update($human, $user, $request);
  }

  public function destroy(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

     $teacher = Human::find($request['id']);//Pega o id do professor
     
    return $this->service->destroy($teacher, $request);
  }

}
