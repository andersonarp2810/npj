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


class DoubleStudentController extends Controller
{
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

  public function store(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

    $aluno1 = Human::find($request['student_id']);
    $aluno2 = Human::find($request['student2_id']);

    if($aluno1->id == $aluno2->id){
      $request->session()->flash('status', 'Erro ao Cadastrar, Cadastre Dupla com Alunos diferentes!!');
      return redirect()->back();
    }

    if($aluno1->doubleS == 'SIM'){
      $request->session()->flash('status', 'Erro ao Cadastrar, O primeiro Aluno já possui dupla!!');
      return redirect()->back();
    }

    if($aluno2->doubleS == 'SIM'){
      $request->session()->flash('status', 'Erro ao Cadastrar, O segundo Aluno já possui dupla!!');
      return redirect()->back();
    }

    DoubleStudent::create([
     'student_id'  => $request['student_id'],
     'student2_id' => $request['student2_id'],
     'group_id'    => $request['group_id'],
     'qtdPetitions'=> 0
    ]);

    $student = Human::find($request['student_id']);
    $student->doubleS = 'SIM';
    $student->save();
    $student2 = Human::find($request['student2_id']);
    $student2->doubleS = 'SIM';
    $student2->save();

    $request->session()->flash('status', 'Dupla cadastrada com sucesso!');
    return redirect()->back();
  }

  public function update(Request $request)//recebe idestudante1, idestudante2 e idgrupo
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

          $doubleStudent = DoubleStudent::find($request['id']);

          if($doubleStudent != null){

            if($request['student_id'] != null)
            {
              $estudante1VELHO = Human::find($doubleStudent->student_id);
              $estudante1NOVO = Human::find($request['student_id']);
              //dd($estudante1NOVO->id);

              $doubleStudent->student_id = $estudante1NOVO->id;
              $estudante1NOVO->doubleS = 'SIM';
              $estudante1VELHO->doubleS = 'NAO';
              $estudante1NOVO->save();
              $estudante1VELHO->save();
            }

            if($request['student2_id'] != null)
            {
              $estudante2VELHO = Human::find($doubleStudent->student2_id);
              $estudante2NOVO = Human::find($request['student2_id']);

              $doubleStudent->student2_id = $estudante2NOVO->id;
              $estudante2NOVO->doubleS = 'SIM';
              $estudante2VELHO->doubleS = 'NAO';
              $estudante2NOVO->save();
              $estudante2VELHO->save();
            }

            if($request['group_id'] != null)
            {
              $grupoVELHO = Group::find($doubleStudent->group_id);
              $grupoNOVO = Group::find($request['group_id']);
              $doubleStudent->group_id = $grupoNOVO->id;
              $grupoVELHO->save();
              $grupoNOVO->save();
            }




            $doubleStudent->save();
            $request->session()->flash('status', 'Dupla editada com sucesso!');
        return redirect()->back();
      }
  }

  public function destroy(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

    $doubleStudent = DoubleStudent::find($request['id']);
    if($doubleStudent != null){
      $student1 = Human::find($doubleStudent->student_id);
      //dd($student1->doubleS);
      $student1->doubleS = 'NAO';
      $student1->save();
      //dd($student1);
      $student2 = Human::find($doubleStudent->student2_id);
      $student2->doubleS = 'NAO';
      $student2->save();

      $doubleStudent->status = 'inactive';
      $doubleStudent->save();


      $request->session()->flash('status', 'Dupla excluida com sucesso!');
      return redirect()->back();
    }

    $request->session()->flash('status', 'Erro ao tentar excluir Grupo!');
    return redirect()->back();
  }

}
