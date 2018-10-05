<?php

namespace App\Http\Controllers;

use App\Entities\Comment;
use App\Entities\DoubleStudent;
use App\Entities\Human;
use App\Entities\Petition;
use App\Entities\Photo;
use App\Entities\Template;
use App\Services\PetitionService;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Storage;

class PetitionController extends Controller
{
    //
    public function __construct(PetitionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        if (Auth::user()->type == 'student') {
            $dados = $this->service->studentIndex();

            return view('student.petition')->with($dados);

        } else if (Auth::user()->type == 'teacher') {
            $dados = $this->service->teacherIndex();

            return view('teacher.petition')->with($dados);

        } else if (Auth::user()->type == 'defender') {
            $dados = $this->service->defenderIndex();

            return view('defender.petition')->with($dados);
        }
    }

    public function add()
    { //aluno
        if (Auth::user()->type != 'student') {
            return redirect()->back();
        }

        return view('student.petitionCadastrar')->with(['templates' => $templates]);

    }

    public function store(Request $request)
    {
        //dd($request->botao);
        if (Auth::user()->type == 'student') { // só autenticação

            $student = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active')->first();
            $this->service->newPetition($request, $student);

            return redirect('Aluno/Peticoes');

        } else { //se nao for Aluno
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        if (Auth::user()->type == 'student') { // autenticação
            $petition = Petition::find($request['id']);
            if ($petition != null) { // não requisitar id indisponível
                if ($petition->student_ok == 'false') { //aluno esta editando Peticao RECUSADA
                    if ($request->botao == 'ENVIAR') { //aluno vai ENVIAR a Petição RECUSADA editada
                        $this->service->newVersion($request, $petition);

                        $request->session()->flash('status', 'Petição Enviada com sucesso!');

                    } else if ($request->botao == 'SALVAR') { //aluno vai apenas salvar as alterações e nao vai ENVIAR a Petição RECUSADA
                        $this->service->updateDraft($request, $petition);
                        $request->session()->flash('status', 'Alterações foram salvas com Sucesso!!');
                    }
                    return redirect('Aluno/Peticoes');

                } else if ($petition->student_ok == null) { //aluno esta editando Peticao RASCUNHO
                    if ($request->botao == 'ENVIAR') { //aluno vai enviar Petição RASCUNHO editada

                        $petition->student_ok = 'true'; //student_ok era null, agr é true
                        $this->service->updateDraft($request, $petition);

                        $doubleStudent = DoubleStudent::find($petition->doubleStudent_id);
                        $this->service->countPetition($doubleStudent);

                        $request->session()->flash('status', 'Petição Enviada com sucesso!');
                        
                    } else if ($request->botao == 'SALVAR') { //aluno vai salvar Petição RASCUNHO editada
                        $this->service->updateDraft($request, $petition);
                        $request->session()->flash('status', 'Alterações foram salvas com Sucesso!!');
                    }

                    return redirect('Aluno/Peticoes');
                }
            } else { // se petição nula
                return redirect()->back();
            }
        } else { // se usuário não é aluno
            return redirect()->back();
        }
    }

    public function changePetition(Request $request)
    {

        $p = Petition::find($request['id']); //Peticao escolhida
        $pOld = Petition::all()->where('petitionFirst', $p->petitionFirst)->where('visible', 'true')->first(); //Peticao antiga
        if ($p != null && $pOld != null && $p != $pOld) {
            if ($pOld->defender_ok != 'true') { //Se defensor nao tiver APROVADO a peticao antiga, FAZ A TROCA DAS PETICOES
                $pOld->visible = 'false';
                $p->student_ok = $pOld->student_ok;
                $p->teacher_ok = $pOld->teacher_ok;
                $p->defender_ok = $pOld->defender_ok;
                $p->defender_id = $pOld->defender_id;

                $comment = Comment::where('petition_id', $pOld->id)->orderBy('id', 'desc')->first(); //pegar o ultimo comentario da petição antiga
                //$comment = Comment::where('petition_id',$pOld->id);
                if ($comment != null) {
                    Comment::create([
                        'content' => $comment->content,
                        'human_id' => $comment->human_id,
                        'petition_id' => $p->id, //passando o comentario da petição antiga para a peticao escolhida
                    ]);
                }

                $pOld->student_ok = null;
                $pOld->teacher_ok = null;
                $pOld->defender_ok = null;
                $pOld->defender_id = null;
                $pOld->save();
                $p->visible = 'true';
                $p->save();
                $status = "Deu certo";
                return response()->json(['status' => $status]);

            }
        } else {
            return redirect()->back();
        }
        return null;

    }

    public function copyPetition(Request $request)
    {
        $petition = Petition::find($request['id']); //Peticao escolhida
        //$pOld = Petition::all()->where('petitionFirst',$p->petitionFirst)->where('visible','true')->first();//Peticao antiga

        if ($petition != null) { //se a petição ja tiver sido finalizada FAZ A COPIA DA PETIÇÃO

            //cria nova versao da peticao
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
            return response()->json(['status' => $status]);
        } else {
            return redirect()->back();
        }
        return null;
    }

    public function escolherTemplate(Request $request)
    {
        $template = Template::find($request->template_id);
        return view('student.petitionCadastrar')->with(['template' => $template]);
    }

    public function delete(Request $request)
    {
        $petition = Petition::find($request['id']);
        if ($petition != null && $petition->student_ok == '') { //peticao diferente de nulo e sendo RASCUNHO
            $photos = Photo::all()->where('petition_id', $petition->id);

            if ($photos != null) {
                Storage::disk('public')->delete('petition' . $petition->id);
                foreach ($photos as $photo) {
                    //Storage::delete('petition/'.$petition->id.'/'.$photo);

                    //Storage::disk('public')->delete('petition/'.$petition->id.'/'.$photo);

                    $photo->delete();
                }
            }
            $petition->delete();
            $request->session()->flash('status', 'Petição rascunho excluida com Sucesso!!');
            return redirect('Aluno/Peticoes');
        } else {
            return redirect('Aluno/Peticoes');
        }
    }

}
