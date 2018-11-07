<?php

namespace App\Services;

use App\Entities\DoubleStudent;
use App\Entities\Group;
use App\Entities\Human;
use App\Entities\Petition;
use App\User;
use Auth;
use Illuminate\Http\Request;

class StudentService
{

    public function index()
    {
        $student = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active')->first();

        $doubleStudent = DoubleStudent::all()->where('student_id', '=', $student->id)->where('status', 'active')->first();

        if ($doubleStudent == null) { // se não for o aluno 1 da dupla talvez seja o 2
            $doubleStudent = DoubleStudent::all()->where('status', '=', 'active')->where('student2_id', '=', $student->id)->first();
        }

        if ($doubleStudent != null) { // se for da dupla
            $petitions = Petition::all()->where('doubleStudent_id', '=', $doubleStudent->id);
            $group = Group::all()->where('status', '=', 'active')->where('id', '=', $doubleStudent->group_id)->first();
            $teacher = Human::all()->where('id', '=', $group->teacher_id)->where('status', '=', 'active')->first();
            $humans = Human::all()->where('status', '=', 'active');
            $user = Auth::user();

            return ['student' => $student, 'doubleStudent' => $doubleStudent, 'petitions' => $petitions, 'group' => $group, 'teacher' => $teacher, 'humans' => $humans, 'user' => $user];
        } else {
            return redirect()->back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', 'Aluno não registrado em nenhuma dupla.');
        }
    }

    public function store(Request $request)
    {
        $verifica = User::all()->where('email', $request->email)->first();

        if ($verifica == null) {
            $user = User::create([
                'type' => 'student',
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $human = Human::create([
                'status' => 'active',
                'name' => $request->name,
                'phone' => $request->phone,
                'age' => $request->age,
                'gender' => $request->gender,
                'doubleS' => 'NAO',
                'user_id' => $user->id, //id do human Student
            ]);

            $request->session()->flash('status', 'Aluno cadastrado com sucesso!');
            return redirect()->back();
        }

        $request->session()->flash('erro', 'Email já cadastrado!');
        return redirect()->back()->withInput($request->except(['password', 'password_confirmation']));
    }

    public function update(Human $human, User $user, Request $request)
    {
        $verifica = User::all()->where('status', 'active')->where('email', $request->email)->first();

        if ($verifica == null || $user->email == $request->email) {
            if ($request['password'] != null) {
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
        $request->session()->flash('erro', 'Email já cadastrado!');
        return redirect()->back()->withInput($request->except(['password', 'password_confirmation']));
    }

    public function destroy(Request $request, Human $student)
    {
        if ($student != null) { //se estudante existir
            if ($student->status == "active" && $student->user->type == "student") { //se estudante for active e for do type student
                $doubleStudents = DoubleStudent::all()->where('status', 'active');
                if ($doubleStudents != null) { //se houver duplas
                    foreach ($doubleStudents as $doubleStudent) {
                        if ($doubleStudent->student_id == $student->id) { //se o primeiro aluno da dupla for o aluno da requisicao
                            $doubleStudent->status = 'inactive'; //dupla torna-se inativa
                            $student2 = Human::find($doubleStudent->student2_id); //pegar estudante2
                            $student2->doubleS = 'NAO'; //O estudante2 nao esta mais em nenhuma dupla
                            $student2->save();
                            $doubleStudent->save();
                        }
                        if ($doubleStudent->student2_id == $student->id) { //se o segundo aluno da dupla for o aluno da requisicao
                            $doubleStudent->status = "inactive"; //dupla torna-se inativa
                            $student1 = Human::find($doubleStudent->student_id); //pegar estudante1
                            $student1->doubleS = 'NAO'; //O estudante1 nao esta mais em nenhuma dupla
                            $student1->save();
                            $doubleStudent->save();
                        }
                    } //fim foreach
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

    public function editar(Human $human, User $user, Request $request)
    {

        $human->name = $request['name'];
        $human->gender = $request['gender'];
        $human->phone = $request['phone'];
        $user->email = $request['email'];

        if ($request['password'] != null) {
            $user->password = bcrypt($request['password']);
        }
        $human->save();
        $user->save();
        $request->session()->flash('status', 'Dados salvos com sucesso!!');

        return redirect()->back();

    }
}
