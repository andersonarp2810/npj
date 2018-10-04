<?php

namespace App\Http\Controllers;

use App\Entities\Comment;
use App\Entities\DoubleStudent;
use App\Entities\Group;
use App\Entities\Human;
use App\Entities\Petition;
use App\Entities\Photo;
use App\Entities\Template;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Storage;

class PetitionService{


    public function studentIndex(){
        $student = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active')->first();

            $doubleStudent = DoubleStudent::all()->where('status', '=', 'active')->where('student_id', '=', $student->id)->first();
            if ($doubleStudent == null) {
                $doubleStudent = DoubleStudent::all()->where('status', '=', 'active')->where('student2_id', '=', $student->id)->first();
            }
            $petitions = Petition::all()->where('doubleStudent_id', '=', $doubleStudent->id)->sortByDesc('updated_at');

            $group = Group::all()->where('status', '=', 'active')->where('id', '=', $doubleStudent->group_id)->first();

            $teacher = Human::all()->where('id', '=', $group->teacher_id)->where('status', '=', 'active')->first();

            $humans = Human::all()->where('status', '=', 'active');

            $user = Auth::user();
            $templates = Template::all()->where('status', 'active')->where('teacher_id', $teacher->id);

            return ['student' => $student, 'doubleStudent' => $doubleStudent, 'petitions' => $petitions, 'group' => $group, 'teacher' => $teacher, 'humans' => $humans, 'user' => $user, 'templates' => $templates];
    }

    public function teacherIndex(){
        
        $teacher = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active')->first();
        $group = Group::all()->where('status', '=', 'active')->where('teacher_id', '=', $teacher->id)->first();
        
        $doubleStudents = DoubleStudent::all()->where('status', '=', 'active')->where('group_id', '=', $group->id);
        
        $petitions = Petition::all()->where('group_id', $group->id)->where('visible', 'true')->sortByDesc('updated_at');
        $humans = Human::all()->where('status', '=', 'active');

        $user = Auth::user();

        return ['teacher' => $teacher, 'group' => $group, 'doubleStudents' => $doubleStudents, 'petitions' => $petitions, 'humans' => $humans, 'user' => $user];
    }

    public function defenderIndex(){
        
        $defender = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active')->first();
        $petitions = Petition::all()->where('visible', 'true')->sortByDesc('updated_at');
        $user = Auth::user();

        return ['defender' => $defender, 'petitions' => $petitions, 'user' => $user];
    }

    public function enviar(Request $request, Student $student){

                //Se o Student estiver na primeira posição da DUPLA
                $doubleStudent = DoubleStudent::all()->where('status', '=', 'active')->where('student_id', '=', $student->id)->first();
                if ($doubleStudent == null) { // se não estiver na primeira posição da DUPLA
                    $doubleStudent = DoubleStudent::all()->where('status', '=', 'active')->where('student2_id', '=', $student->id)->first();
                }
                $student_ok = $request->botao == 'ENVIAR' ? true : null; // 'ENVIAR'(para o professor) ou 'SALVAR'(rascunho)

                $petition = Petition::create([
                    'description' => $request['description'],
                    'content' => $request['content'],
                    'student_ok' => $student_ok,
                    'template_id' => $request['template_id'],
                    'doubleStudent_id' => $doubleStudent->id,
                    'group_id' => $doubleStudent->group_id,
                    'version' => 1,
                    'visible' => 'true',
                ]);
                $doubleStudent->qtdPetitions = ($doubleStudent->qtdPetitions + 1);
                $group = Group::find($doubleStudent->group_id);
                $group->qtdPetitions = ($group->qtdPetitions + 1);
                $doubleStudent->save();
                $group->save();

                $petition->petitionFirst = $petition->id;
                $petition->save();

                if ($request->hasFile('images')) {

                    $files = $request->file('images');

                    foreach ($files as $file) {

                        $fname = $file->getClientOriginalName();

                        Photo::create([
                            'photo' => Storage::disk('public')->put($fname, $file),
                            'petition_id' => $petition->id,
                        ]);
                        $diskPublic = Storage::disk('public');
                        $diskPublic->put('petition/' . $petition->id . '/' . $fname, $file);
                    }
                }

                $mensagem = $student_ok ? 'Petição enviada com sucesso!' : 'Petição salva com sucesso!';
                $request->session()->flash('status', $mensagem);
    }    


}