<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Entities\Human;
use App\Entities\DoubleStudent;
use App\Entities\Petition;
use App\Entities\Group;
use App\User;
use Auth;
use Validator;

class StudentService {

    public function index(Request $request) {
        # code...
    }

    public function store(Request $request) {
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

    public function update(Human $human, User $user, Request $request) {
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

    public function delete(Request $request) {
        if($student != null) {//se estudante existir
            if($student->status == "active" && $student->user->type == "student") {//se estudante for active e for do type student
                $doubleStudents = DoubleStudent::all()->where('status','active');
                if($doubleStudents != null) {//se houver duplas
                    foreach($doubleStudents as $doubleStudent) {
                        if($doubleStudent->student_id == $student->id) {//se o primeiro aluno da dupla for o aluno da requisicao
                            $doubleStudent->status = 'inactive';//dupla torna-se inativa
                            $student2 = Human::find($doubleStudent->student2_id);//pegar estudante2
                            $student2->doubleS = 'NAO';//O estudante2 nao esta mais em nenhuma dupla
                            $student2->save();
                            $doubleStudent->save();
                        }
                        if($doubleStudent->student2_id == $student->id) {//se o segundo aluno da dupla for o aluno da requisicao
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
        } else {
            $request->session()->flash('status', 'Erro, Aluno não existe!');
            return redirect()->back();
        }
    }
}