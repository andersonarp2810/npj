<?php

namespace App\Http\Controllers;

use App\Entities\Comment;
use App\Entities\DoubleStudent;
use App\Entities\Group;
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
            $this->service->enviar($request, $student);

            return redirect('Aluno/Peticoes');

        } else { //se nao for Aluno
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        if (Auth::user()->type == 'student') { // autenticação
            $petition = Petition::find($request['id']);
            if ($petition != null) {
                if ($petition->student_ok == 'false') { //aluno esta editando Peticao RECUSADA
                    if ($request->botao == 'ENVIAR') { //aluno vai ENVIAR a Petição RECUSADA editada

                        $comment = Comment::where('petition_id', $petition->id)->orderBy('id', 'desc')->first(); //pegar o ultimo comentario
                        //$comment = Comment::where('petition_id',$petition->id);

                        $photos = Photo::all()->where('petition_id', $petition->id);

                        //cria nova versao da peticao
                        $totalVersao = Petition::all()->where('petitionFirst', $petition->petitionFirst)->count();

                        $p = Petition::create([
                            'description' => $petition->description,
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
                        ]);
                        $p->petitionFirst = $petition->petitionFirst;
                        $p->save();

                        if ($photos != null) {
                            foreach ($photos as $photo) { //fotos da petition antiga

                                $po = Photo::create([
                                    'photo' => $photo->photo,
                                    'petition_id' => $p->id, //id da nova Petition
                                ]);
                                $diskPublic = Storage::disk('public');
                                //Storage::disk('public')->put('petition/'.$petition->id,$file),
                                $diskPublic->copy('petition/' . $petition->id . '/' . $photo->photo, 'petition/' . $p->id . '/' . $po->photo);
                            }
                        } else {
                            if ($request['images'] != null) {
                                $photos = Photo::all()->where('petition_id', $petition->id);

                                if ($photos->count() == 0) { //se nao existirem fotos
                                    $files = $request->file('images');

                                    foreach ($files as $file) {

                                        $fname = $file->getClientOriginalName();
                                        dd($petition->id);
                                        Photo::create([
                                            'photo' => Storage::disk('public')->put($fname, $file),
                                            'petition_id' => $petition->id,
                                        ]);
                                        $diskPublic = Storage::disk('public');
                                        $diskPublic->put('petition/' . $petition->id . '/' . $fname, $file);
                                    }
                                }
                            }
                        }

                        if ($comment != null) {
                            Comment::create([
                                'content' => $comment->content,
                                'human_id' => $comment->human_id,
                                'petition_id' => $p->id, //passando o ultimo comentario da versao anterior para essa nova versão da petição
                            ]);
                        }

                        /*if($comment != null){
                        foreach($comment as $co){
                        Comment::create([
                        'content'     => $co->content,
                        'human_id'    => $co->human_id,
                        'petition_id' => $p->id,//passando o comentario da versao anterior para essa nova versão da petição
                        ]);
                        }
                        }**/

                        $petition->visible = 'false'; //tornour-se versão anterior
                        $petition->student_ok = null;
                        $petition->teacher_ok = null;
                        $petition->defender_ok = null;
                        $petition->defender_id = null; //defensor nao deve estar vinculado a uma versao anterior, somente a vesao finalizada
                        $petition->save();
                        $request->session()->flash('status', 'Petição Enviada com sucesso!');
                    } else if ($request->botao == 'SALVAR') { //aluno vai apenas salvar as alterações e nao vai ENVIAR a Petição RECUSADA
                        if ($request['images'] != null) {
                            $photos = Photo::all()->where('petition_id', $petition->id);

                            if ($photos->count() == 0) { //se nao existirem fotos
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
                        $petition->description = $request->description;
                        $petition->content = $request->content;
                        $petition->save();
                        $request->session()->flash('status', 'Alterações foram salvas com Sucesso!!');
                    }
                    return redirect('Aluno/Peticoes');
                } else if ($petition->student_ok == null) { //aluno esta editando Peticao RASCUNHO
                    if ($request->botao == 'ENVIAR') { //aluno vai enviar Petição RASCUNHO editada

                        $doubleStudent = DoubleStudent::find($petition->doubleStudent_id);
                        $doubleStudent->qtdPetitions = ($doubleStudent->qtdPetitions + 1);
                        $group = Group::find($doubleStudent->group_id);
                        $group->qtdPetitions = ($group->qtdPetitions + 1);
                        $doubleStudent->save();
                        $group->save();

                        if ($request['images'] != null) {
                            $photos = Photo::all()->where('petition_id', $petition->id);

                            if ($photos->count() == 0) { //se nao existirem fotos
                                $files = $request->file('images');

                                foreach ($files as $file) {

                                    $fname = $file->getClientOriginalName();
                                    dd($petition->id);
                                    Photo::create([
                                        'photo' => Storage::disk('public')->put($fname, $file),
                                        'petition_id' => $petition->id,
                                    ]);
                                    $diskPublic = Storage::disk('public');
                                    $diskPublic->put('petition/' . $petition->id . '/' . $fname, $file);
                                }
                            }
                        }

                        $petition->description = $request['description'];
                        $petition->content = $request['content'];
                        $petition->student_ok = 'true'; //student_ok era null, agr é true
                        $petition->save();
                        $request->session()->flash('status', 'Petição Enviada com sucesso!');
                    } else if ($request->botao == 'SALVAR') { //aluno vai salvar Petição RASCUNHO editada

                        if ($request['images'] != null) {
                            $photos = Photo::all()->where('petition_id', $petition->id);

                            if ($photos->count() == 0) { //se ainda nao existirem fotos
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

                        $petition->description = $request['description'];
                        $petition->content = $request['content'];
                        $petition->save();
                        $request->session()->flash('status', 'Alterações foram salvas com Sucesso!!');
                    }
                    return redirect('Aluno/Peticoes');
                }
            } else {
                return redirect()->back();
            }
        } else {
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
