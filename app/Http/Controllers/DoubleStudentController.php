<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\DoubleStudent;
use App\Entities\Petition;
use App\Entities\Group;
use App\Entities\Human;
use App\User;
use Auth;
use Validator;

use App\Services\DoubleStudentService;

class DoubleStudentController extends Controller
{

public function __construct(DoubleStudentService $service){

  $this->service =$service;

}

  //
  public function index()
  {
    if(Auth::user()->type == 'admin'){
      $petitions = Petition::all()->where('visible','true');
      $users = User::all();
      $humans = Human::all()->where('status','active');
      $groups = Group::all()->where('status','active');
      $doubleStudents = DoubleStudent::all()->where('status','active');
      return view('admin.doubleStundents')->with(['petitions'=>$petitions,'users'=>$users,'doubleStudents'=>$doubleStudents,'humans'=>$humans,'groups'=>$groups]);
    }else if(Auth::user()->type == 'teacher'){
      $teachers = Human::all()->where('user_id','=',Auth::user()->id)->where('status','=','active');
      $teacher = $teachers->first();
//      dd($teacher);
      $groups = Group::all()->where('status','=','active')->where('teacher_id','=',$teacher->id);
      $group = $groups->first();
      //dd($group);
      $petitions = Petition::all()->where('group_id','=',$group->id);
      //dd($petitions);
      $users = User::all();
      $humans = Human::all()->where('status','active');
      //dd($humans);
      $doubleStudents = DoubleStudent::all()->where('status','=','active')->where('group_id','=',$group->id);
      //dd($doubleStudents);
      return view('teacher.doubleStudents')->with(['teacher'=>$teacher,'group'=>$group,'petitions'=>$petitions,'users'=>$users,'humans'=>$humans,'doubleStudents'=>$doubleStudents]);
    }else{
        return redirect()->back();
    }

  }

  //--------------------------------------------------------------------------------------------------

  public function store(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

    return $this->service->store($request);

  }

  //--------------------------------------------------------------------------------------------------

  public function update(Request $request)//recebe idestudante1, idestudante2 e idgrupo
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

      return $this->service->update($request);
  }

 //--------------------------------------------------------------------------------------------------

  public function destroy(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

   return $this->service->destroy($request);

  }
}