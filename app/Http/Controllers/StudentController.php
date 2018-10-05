<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Human;
use App\Entities\DoubleStudent;
use App\Entities\Petition;
use App\Entities\Group;
use App\User;
use Auth;
use Validator;

use App\Services\StudentService;

class StudentController extends Controller
{
  public function __construct(StudentService $service) {
    $this->service = $service;
  }

  public function index()
  {
    if(Auth::user()->type == 'admin') {
      $students = Human::all()->where('status','active');
      return view('admin.student')->with(['students'=>$students]);

    } else if(Auth::user()->type == 'student') {
      $student = Human::all()->where('user_id','=',Auth::user()->id)->where('status','=','active')->first();

      if($student->doubleS == 'SIM') {
        $doubleStudent = DoubleStudent::all()->where('student_id','=',$student->id)->where('status','active')->first();

        if($doubleStudent == null) {
          $doubleStudent = DoubleStudent::all()->where('status','=','active')->where('student2_id','=',$student->id)->first();
        }

        $petitions = Petition::all()->where('doubleStudent_id','=',$doubleStudent->id);
        $groups = Group::all()->where('status','=','active')->where('id','=',$doubleStudent->group_id);
        $group = $groups->first();
        $teachers = Human::all()->where('id','=',$group->teacher_id)->where('status','=','active');
        $teacher = $teachers->first();
        $humans = Human::all()->where('status','=','active');
        $user = Auth::user();
        return view('student.home')->with(['student'=>$student,'doubleStudent'=>$doubleStudent,'petitions'=>$petitions,'group'=>$group,'teacher'=>$teacher,'humans'=>$humans,'user'=>$user]);
      } else {//se o aluno nao tiver dupla
        return redirect('Sair');
      }
    } else {
      return redirect()->back();
    }
  }

  public function store(Request $request)
  {
    if(Auth::user()->type != 'admin'){
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
    $user = User::find($human->user->id);

    return $this->service->update($human, $user, $request);
  }

  public function destroy(Request $request)
  {  
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }
    $student = Human::find($request['id']);
       
    return $this->service->destroy($student, $request);
  }
}
