<?php

namespace App\Services;

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

class PetitionService
{

    public function studentIndex()
    {
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

    public function teacherIndex()
    {

        $teacher = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active')->first();
        $group = Group::all()->where('status', '=', 'active')->where('teacher_id', '=', $teacher->id)->first();

        $doubleStudents = DoubleStudent::all()->where('status', '=', 'active')->where('group_id', '=', $group->id);

        $petitions = Petition::all()->where('group_id', $group->id)->where('visible', 'true')->sortByDesc('updated_at');
        $humans = Human::all()->where('status', '=', 'active');

        $user = Auth::user();

        return ['teacher' => $teacher, 'group' => $group, 'doubleStudents' => $doubleStudents, 'petitions' => $petitions, 'humans' => $humans, 'user' => $user];
    }

    public function defenderIndex()
    {

        $defender = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active')->first();
        $petitions = Petition::all()->where('visible', 'true')->sortByDesc('updated_at');
        $user = Auth::user();

        return ['defender' => $defender, 'petitions' => $petitions, 'user' => $user];
    }

    public function newPetition(Request $request, Human $student)
    {

        //Se o Student estiver na primeira posição da DUPLA
        $doubleStudent = DoubleStudent::all()->where('status', '=', 'active')->where('student_id', '=', $student->id)->first();
        if ($doubleStudent == null) { // se não estiver na primeira posição da DUPLA
            $doubleStudent = DoubleStudent::all()->where('status', '=', 'active')->where('student2_id', '=', $student->id)->first();
        }
        $student_ok = $request->botao == 'ENVIAR'; // 'ENVIAR'(para o professor) ou 'SALVAR'(rascunho)

        $novapeticao = [
            'description' => $request['description'],
            'content' => $request['content'],
            'template_id' => $request['template_id'],
            'doubleStudent_id' => $doubleStudent->id,
            'group_id' => $doubleStudent->group_id,
            'version' => 1,
            'visible' => 'true',
        ];

        if ($student_ok) {
            $novapeticao['student_ok'] = 'true';
        }

        $petition = Petition::create($novapeticao);
        countPetition($doubleStudent);

        $petition->petitionFirst = $petition->id;
        $petition->save();

        if ($request['images'] != null) {

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

    public function updateDraft(Request $request, Petition $petition)
    {

        addImages($request, $petition);

        $petition->description = $request['description'];
        $petition->content = $request['content'];
        $petition->save();
    }

    public function addImages(Request $request, Petition $petition)
    {
        if ($request['images'] != null) {

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
    }

    public function countPetition(DoubleStudent $doubleStudent)
    {
        $doubleStudent->qtdPetitions = ($doubleStudent->qtdPetitions + 1);
        $group = Group::find($doubleStudent->group_id);
        $group->qtdPetitions = ($group->qtdPetitions + 1);
        $doubleStudent->save();
        $group->save();
    }

    public function newVersion(Request $request, Petition $petition)
    {
//cria nova versao da peticao
        $totalVersao = Petition::all()->where('petitionFirst', $petition->petitionFirst)->count();

        $newPetition = Petition::create([
            'description' => $request['description'],
            'content' => $request['content'],
            'student_ok' => 'true', //era 'false' agr é 'true'
            'teacher_ok' => $petition->teacher_ok,
            'defender_ok' => $petition->defender_ok,
            'defender_id' => $petition->defender_id,
            'template_id' => $petition->template_id,
            'doubleStudent_id' => $petition->doubleStudent_id,
            'group_id' => $petition->group_id,
            'version' => $totalVersao + 1,
            'visible' => 'true',
            'petitionFirst' => $petition->petitionFirst,
        ]);

        $photos = Photo::all()->where('petition_id', $petition->id);
        if ($photos != null) {
            foreach ($photos as $photo) { //fotos da petition antiga

                $po = Photo::create([
                    'photo' => $photo->photo,
                    'petition_id' => $newPetition->id, //id da nova Petition
                ]);
                $diskPublic = Storage::disk('public');
                //Storage::disk('public')->put('petition/'.$petition->id,$file),
                $diskPublic->copy('petition/' . $petition->id . '/' . $photo->photo, 'petition/' . $newPetition->id . '/' . $po->photo);
            }
        }
        addImages($request, $newPetition);

        $comments = Comment::all()->where('petition_id', $petition->id);
        if ($comments != null) {
            foreach ($comments as $co) {
                Comment::create([
                    'content' => $co->content,
                    'human_id' => $co->human_id,
                    'petition_id' => $newPetition->id, //passando o comentario da versao anterior para essa nova versão da petição
                ]);
            }
        }

        $petition->visible = 'false'; //tornour-se versão anterior
        $petition->student_ok = null;
        $petition->teacher_ok = null;
        $petition->defender_ok = null;
        $petition->defender_id = null; //defensor nao deve estar vinculado a uma versao anterior, somente a vesao finalizada
        $petition->save();
    }

    public function changePetition(Petition $petition, Petition $oldPetition)
    {
        $oldPetition->visible = 'false';
        $petition->student_ok = $oldPetition->student_ok;
        $petition->teacher_ok = $oldPetition->teacher_ok;
        $petition->defender_ok = $oldPetition->defender_ok;
        $petition->defender_id = $oldPetition->defender_id;

        //$comment = Comment::where('petition_id', $oldPetition->id)->orderBy('id', 'desc')->first(); //pegar o ultimo comentario da petição antiga
        $comments = Comment::where('petition_id', $oldPetition->id); //pegar todos
        if ($comments != null) {
            foreach ($comments as $comment) {
                Comment::create([
                    'content' => $comment->content,
                    'human_id' => $comment->human_id,
                    'petition_id' => $petition->id, //copiando o comentario da petição antiga para a peticao escolhida
                ]);
            }
        }

        $oldPetition->student_ok = null;
        $oldPetition->teacher_ok = null;
        $oldPetition->defender_ok = null;
        $oldPetition->defender_id = null;
        $oldPetition->save();
        $petition->visible = 'true';
        $petition->save();
        $status = "Deu certo";
    }

    public function copyPetition(Petition $petition)
    {
        $p = Petition::create([
            'description' => $petition->description,
            'content' => $petition->content,
            'template_id' => $petition->template_id,
            'doubleStudent_id' => $petition->doubleStudent_id,
            'group_id' => $petition->group_id,
            'version' => 1,
            'visible' => 'true',
        ]);
        $p->petitionFirst = $p->id;
        $p->save();

        $status = "Deu certo";

        return $status;
    }

    public function delete(Petition $petition)
    {
        $photos = Photo::all()->where('petition_id', $petition->id);

        if ($photos != null) {
            Storage::disk('public')->delete('petition' . $petition->id);
            foreach ($photos as $photo) {
                $photo->delete();
            }
        }
        $petition->delete();

    }

    public function edit(Petition $petition)
    {
        $templates = Template::all();
        $photos = Photo::all()->where('petition_id', $petition->id);
        $IsPhotos = $photos->count() != 0 ? 'true' : 'false';
        $comments = Comment::all()->where('petition_id', $petition->id);

        return ['petition' => $petition, 'templates' => $templates, 'photos' => $photos, 'IsPhotos' => $IsPhotos, 'comments' => $comments];
    }

    public function show(Petition $petition)
    {
        $humans = Human::all()->where('status', 'active');
        $temps = Template::all();
        $petitions = Petition::all()->where('petitionFirst', $petition->petitionFirst);
        $photos = Photo::all()->where('petition_id', $petition->id);
        $comments = Comment::all()->where('petition_id', $petition->id);

        return ['petition' => $petition, 'humans' => $humans, 'temps' => $temps, 'petitions' => $petitions, 'photos' => $photos, 'comments' => $comments];
    }

    public function avaliar(Petition $petition)
    {

        $photos = Photo::all()->where('petition_id', $petition->id);
        $humans = Human::all()->where('status', 'active');
        $template = Template::find($petition->template_id);
        $comments = Comment::all()->where('petition_id', $petition->id);

        return ['petition' => $petition, 'photos' => $photos, 'humans' => $humans, 'template' => $template, 'comments' => $comments];
    }
}
