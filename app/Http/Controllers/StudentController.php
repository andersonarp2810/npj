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

class StudentController extends Controller
{
    public function index()
    {
        if(Auth::user()->type == 'admin'){
          $students = Human::all()->where('status','active');
          return view('admin.student')->with(['students'=>$students]);

        }else if(Auth::user()->type == 'student'){
          $student = Human::all()->where('user_id','=',Auth::user()->id)->where('status','=','active')->first();

          if($student->doubleS == 'SIM'){
            $doubleStudent = DoubleStudent::all()->where('student_id','=',$student->id)->where('status','active')->first();

            if($doubleStudent != null){//aluno1 da dupla
              $petitions = Petition::all()->where('doubleStudent_id','=',$doubleStudent->id);
              $groups = Group::all()->where('status','active')->where('id','=',$doubleStudent->group_id);
              $group = $groups->first();
              $teachers = Human::all()->where('id','=',$group->teacher_id)->where('status','=','active');
              $teacher = $teachers->first();
              $humans = Human::all()->where('status','=','active');
              $user = Auth::user();
              return view('student.home')->with(['student'=>$student,'doubleStudent'=>$doubleStudent,'petitions'=>$petitions,'group'=>$group,'teacher'=>$teacher,'humans'=>$humans,'user'=>$user]);
            }else{//aluno2 da dupla
              $doubleStudents2 = DoubleStudent::all()->where('status','=','active')->where('student2_id','=',$student->id);
              $doubleStudent = $doubleStudents2->first();

              $petitions = Petition::all()->where('doubleStudent_id','=',$doubleStudent->id);
              $groups = Group::all()->where('status','=','active')->where('id','=',$doubleStudent->group_id);
              $group = $groups->first();
              $teachers = Human::all()->where('id','=',$group->teacher_id)->where('status','=','active');
              $teacher = $teachers->first();
              $humans = Human::all()->where('status','=','active');
              $user = Auth::user();
              return view('student.home')->with(['student'=>$student,'doubleStudent'=>$doubleStudent,'petitions'=>$petitions,'group'=>$group,'teacher'=>$teacher,'humans'=>$humans,'user'=>$user]);
            }
              return redirect('Sair');
          }else{//se o aluno nao tiver dupla
            return redirect('Sair');
          }
      }else{
          return redirect()->back();
      }
    }

    public function store(Request $request)
    {
      if(Auth::user()->type != 'admin'){
        return redirect()->back();
      }

              $user = User::create([
                 'type'     => 'student',
                 'email'    => $request->email,
                 'password' => bcrypt($request->password),
                 ]);

              $human = Human::create([
                 'status'=>'active',
                 'name'=> $request->name,
                 'phone'=> $request->phone,
                 'age'=> $request->age,
                 'gender'=> $request->gender,
                 'doubleS'=>'NAO',
                  'user_id' => $user->id//id do human Student
                ]);

              $request->session()->flash('status', 'Aluno cadastrado com sucesso!');

              return redirect()->back();
    }


    public function update(Request $request)
    {
      if(Auth::user()->type != 'admin'){
        return redirect()->back();
      }

            $human = Human::find($request['id']);
            $user = User::find($human->user->id);

            if($request['password'] != null){
                $user->password = bcrypt($request['password']);
            }
            $human->name = $request['name'];
            $human->gender = $request['gender'];
            $human->phone = $request['phone'];
            $user->email = $request['email'];
            $user->save();
            $human->save();
            $request->session()->flash('status', 'Aluno editado com sucesso!');
        return redirect()->back();
    }

    public function destroy(Request $request)
    {  //
      if(Auth::user()->type != 'admin'){
        return redirect()->back();
      }
       $student = Human::find($request['id']);
       if($student != null){//se estudante existir
         if($student->status == "active" && $student->user->type == "student"){//se estudante for active e for do type student
             $doubleStudents = DoubleStudent::all()->where('status','active');
             if($doubleStudents != null){//se houver duplas
               foreach($doubleStudents as $doubleStudent){
                 if($doubleStudent->student_id == $student->id){//se o primeiro aluno da dupla for o aluno da requisicao
                     $doubleStudent->status = 'inactive';//dupla torna-se inativa
                     $student2 = Human::find($doubleStudent->student2_id);//pegar estudante2
                     $student2->doubleS = 'NAO';//O estudante2 nao esta mais em nenhuma dupla
                     $student2->save();
                     $doubleStudent->save();
                 }
                 if($doubleStudent->student2_id == $student->id){//se o segundo aluno da dupla for o aluno da requisicao
                     $doubleStudent->status = "inactive";//dupla torna-se inativa
                     $student1 = Human::find($doubleStudent->student_id);//pegar estudante1
                     $student1->doubleS = 'NAO';//O estudante1 nao esta mais em nenhuma dupla
                     $student1->save();
                     $doubleStudent->save();
                 }
               }//fim foreach
             }

             $student->status = "inactive";
             $student->save();
             $request->session()->flash('status', 'Aluno excluído com sucesso!');
             return redirect()->back();
         }
       }else{
         $request->session()->flash('status', 'Erro, Aluno não existe!');
         return redirect()->back();
       }
    }

    
}
