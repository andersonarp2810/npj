<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Human;
use App\Entities\Group;
use App\Entities\Petition;
use App\Entities\DoubleStudent;
use Auth;
use Validator;

class GroupController extends Controller
{
  //
  public function index()
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }
    $petitions = Petition::all();
    $doubleStudent = DoubleStudent::all()->where('status','=','active');
    $humans = Human::all()->where('status','=','active');
    $groups = Group::all()->where('status','=','active');
    $doubleStudents = DoubleStudent::all()->where('status','=','active');

    return view('admin.group')->with(['petitions'=>$petitions,'humans'=>$humans,'groups'=>$groups,'doubleStudents'=>$doubleStudents]);
  }

  public function store(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

    $gp = Group::all()->where('name',$request['name'])->first();
    if($gp != null){
      $request->session()->flash('status', 'Cadastro Impossível, Já existe um Grupo com esse Nome!');
      return redirect()->back();
    }

    $group = Group::create([
      'name'         => $request['name'],
      'teacher_id'   => $request['teacher_id'],
      'qtdPetitions' => 0
    ]);

    $teacher = Human::find($group->teacher_id);
    if($teacher != null)
    {
      $teacher->groupT = 'SIM';
      $teacher->save();
      $request->session()->flash('status', 'Grupo cadastrado com sucesso!');
      return redirect()->back();
    }
    $request->session()->flash('status', 'Erro ao tentar cadastrar Grupo!');
    return redirect()->back();

  }

  //alterar update
  public function update(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }
          $group = Group::find($request['id']);

          if($group->teacher_id != $request['teacher_id'] && $request['teacher_id'] != null)//se houver alteracão do professor
          {

            $teacherVelho = Human::find($group->teacher_id);
            $teacherNovo = Human::find($request['teacher_id']);
            dd($request['teacher_id']);
            $teacherVelho->groupT = 'NAO';
            $teacherVelho->save();
            $teacherNovo->groupT = 'SIM';
            $teacherNovo->save();
            $group->teacher_id = $request['teacher_id'];

          }

          if($group->name != $request['name']){//se houver alteração no nome do grupo
            if($request['name'] != null ){
              $group->name = $request['name'];
            }else{
              $request->session()->flash('status', 'Falha ao tentar editar Grupo! - O nome do grupo não pode ser nulo');
              return redirect()->back();
            }

          }

          $group->save();
          $request->session()->flash('status', 'Grupo editado com sucesso!');
      return redirect()->back();
  }

  public function destroy(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

    $group = Group::find($request['id']);
    //dd($group);

    if($group != null && $group->status == 'active'){//se o professor participar de algum grupo e se esse for active
      $group->status = 'inactive';
      $teacher = Human::find($group->teacher_id);//pega o professor do grupo
      $teacher->groupT = 'NAO';//o professor fica sem grupo
      $teacher->save();
      $group->save();

      $doubleStudents = DoubleStudent::all()->where('status','active');//todas as duplas
      foreach($doubleStudents as $doubleStudent){///
        if($doubleStudent->group_id == $group->id){//se o grupo da dupla iterada for o grupo
          $doubleStudent->status = 'inactive';
          $student1 = Human::find($doubleStudent->student_id);
          $student1->doubleS = 'NAO';
          $student1->save();
          $student2 = Human::find($doubleStudent->student2_id);
          $student2->doubleS = 'NAO';
          $student2->save();
          $doubleStudent->save();
        }
      }
      $request->session()->flash('status', 'Grupo excluído com sucesso!');
      return redirect()->back();
    }

    if($group != null){
      $group->status = 'inactive';
      $teacher = Human::find($group->teacher_id);
      $teacher->groupT = 'NAO';
      $teacher->save();
      $group->save();
      $request->session()->flash('status', 'Grupo excluido com sucesso!');
      return redirect()->back();
    }
    $request->session()->flash('status', 'Erro ao tentar excluir Grupo!');
    return redirect()->back();

  }

}
