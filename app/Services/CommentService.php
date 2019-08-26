<?php

namespace App\Services;

use App\Entities\Comment;
use App\Entities\Group;
use App\Entities\Human;
use App\Entities\Petition;
use App\Services\PetitionService;
use App\User;
use Auth;
use Illuminate\Http\Request;

class CommentService
{

    public function __construct(PetitionService $service)
    {
        $this->service = $service;
    }

    public function professorStore(Request $request, Petition $petition)
    {

        $group = Group::find($petition->group_id);
        $teacher = Human::find($group->teacher_id);

        if ($request->botao == 'APROVAR') {
            $petition->teacher_ok = 'true';
            $petition->save();

        }
        else if($request->botao == 'ENVIAR'){ // professor poder corrigir e enviar petição de aluno desvinculado
            $this->service->newVersion($request, $petition);
            $petition->teacher_ok = 'true';
            $petition->save();

            
        }else if($request->botao == 'SALVAR'){ // salvar sem enviar
            $this->service->updateDraft($request, $petition);

        } else if ($request->botao == 'REPROVAR') { //se estiver clicado em REPROVAR
            $comment = Comment::create([
                'content' => $request['comment'],
                'human_id' => $teacher->id,
                'petition_id' => $request['idPetition'],
            ]);
            $petition->student_ok = 'false';
            $petition->teacher_ok = 'false';
            $petition->save();
            $request->session()->flash('status', 'Avaliação realizada com Sucesso!!');
        }

    }

    public function defensorStore(Request $request, Petition $petition)
    {

        $defender = Human::where('user_id', Auth::user()->id)->first();

        if ($request->botao == 'APROVAR') {
            $petition->defender_ok = 'true';
            $petition->defender_id = $defender->id; //petição passa a estar vinculada ao defensor
            $petition->save();

        } else if ($request->botao == 'REPROVAR') { //se estiver clicado em REPROVAR
            $comment = Comment::create([
                'content' => $request['comment'],
                'human_id' => $defender->id,
                'petition_id' => $request['idPetition'],
            ]);
            $petition->student_ok = 'true';
            $petition->teacher_ok = 'true';
            $petition->supervisor_ok = 'false'; // entra agora entre supervisor e professor
            $petition->defender_ok = 'false';
            $petition->defender_id = $defender->id; //petição passa a estar vinculada ao defensor
            $petition->save();
            $request->session()->flash('status', 'Avaliação realizada com Sucesso!!');
        }
    }

    public function supervisorStore(Request $request, Petition $petition){

        $supervisor = Human::where('user_id', Auth::user()->id)->first();

        if($request->botao == 'APROVAR'){
            $petition->supervisor_ok = 'true';
            $petition->save();
        }
        else if($request->botao == 'REPROVAR'){
            $comment = Comment::create([
                'content' => $request['comment'],
                'human_id' => $supervisor->id,
                'petition_id' => $request['idPetition']
            ]);
            $petition->student_ok = 'true';
            $petition->teacher_ok = 'false';
            $petition->supervisor_ok = 'false';
            $petition->save();
            $request->session()->flash('status', 'Avaliação realizada com sucesso!');

        }
    }
}
