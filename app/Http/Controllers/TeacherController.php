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

class TeacherController extends Controller
{

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
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

          $validate = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            ]);

            if($validate->fails()){
                $request->session()->flash('status', 'Falha ao tentar cadastrar novo professor!');
            }else{

            $user = User::create([
               'type'     => 'teacher',
               'email'    => $request->email,
               'password' => bcrypt($request->password),
               ]);

            $human = Human::create([
               'status'=>'active',
               'name'=> $request->name,
               'phone'=> $request->phone,
               'age'=> $request->age,
               'gender'=> $request->gender,
               'user_id'=>$user->id,
               'groupT'=>'NAO'
              ]);

                $request->session()->flash('status', 'Professor cadastrado com sucesso!');
              }
            return redirect()->back()->withErrors($validate)->withInput();
}

  public function update(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }
          $human = Human::find($request['id']);
          $user = User::find($human->user_id);

          if($request['password'] != null){
              $user->password = bcrypt($request['password']);
          }
          $human->name = $request['name'];
          $human->gender = $request['gender'];
          $human->phone = $request['phone'];
          $user->email = $request['email'];
          $user->save();
          $human->save();
          $request->session()->flash('status', 'Professor editado com sucesso!');
      return redirect()->back();
  }

  public function destroy(Request $request)
  {  //
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

     $teacher = Human::find($request['id']);//Pega o id do professor
     //dd($teacher);
     //$teacher_User = User::find($teacher->user_id);
    if($teacher != null && $teacher->status == 'active'){
      //->where('teacher_id',$teacher->id)
       $groups = Group::all();
       foreach($groups as $group){
         if($group->teacher_id == $teacher->id){
//           dd($group);

           if($group != null && $group->status == 'active'){//se o professor participar de algum grupo e se esse for active
//             dd($group->status);
             $group->status = 'inactive';
             $group->save();

             $doubleStudents = DoubleStudent::all();//todas as duplas
             //dd($doubleStudents);
             if($doubleStudents != null){
               foreach($doubleStudents as $doubleStudent){
                 if($doubleStudent->group_id == $group->id){//se o grupo da dupla iterada for o grupo a qual o professor pertence
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
             }
           }
         }
       }
       //dd($teacher);
       $teacher->status = 'inactive';

       $teacher->save();
       $request->session()->flash('status', 'Professor excluído com sucesso!');
       return redirect()->back();
   }else{
     $request->session()->flash('status', 'Erro ao tentar excluir o Professor!');
     return redirect()->back();
   }

  }

}
