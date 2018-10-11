<?php

namespace App\Services;

use App\Entities\Human;
use App\Entities\Petition;
use App\Entities\Template;
use App\User;
use Auth;
use Illuminate\Http\Request;

class TemplateService
{

    public function index()
    {
        $teachers = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active');
        $teacher = $teachers->first(); //professor
        $templates = Template::all()->where('teacher_id', $teacher->id);
        $defenders = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active');
        $defender = $defenders->first();
        $petitions = Petition::all()->where('defender_id', '=', $defender->id);
        $humans = Human::all()->where('status', '=', 'active');
        $user = Auth::user();

        return ['teacher' => $teacher, 'templates' => $templates, 'defender' => $defender, 'petitions' => $petitions, 'humans' => $humans, 'user' => $user];
    }

    public function store(Request $request)
    {
        $teacher = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active')->first();
        $template = Template::create([
            'title' => $request['title'],
            'content' => $request['content'],
            'teacher_id' => $teacher->id,
        ]);
        $mensagem = 'Template postado com sucesso!'; //professor clicou em POSTAR Template

        if ($request->botao == 'SALVAR') { //Professor clicou em SALVAR Template
            $template['status'] = 'inactive';
            $template->save();
            $mensagem = 'Template salvo com sucesso!';
        }
        $request->session()->flash('status', $mensagem);
    }
//--------------------------------------------------------------------------------------------------
    public function update(Request $request)
    {
        $teachers = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active');
        $teacher = $teachers->first(); //professor
        $template = Template::find($request['idTemplate']);

        if ($template->title != $request['title']) {
            $template->title = $request['title'];
            $template->save();
        }

        if ($template->content != $request['content']) {
            $template->content = $request['content'];
            $template->save();
        }
        $request->session()->flash('status', 'Template editado com Sucesso!!');
    }
//--------------------------------------------------------------------------------------------------

    public function editStatus(Request $request)
    {
        $template = Template::find($request['id']);
        if ($template != null) {
            $status = "";
            if ($template->status == "active") {
                $template->status = "inactive";
                $status = "inactive";
            } else {
                $template->status = "active";
                $status = "active";
            }
            $template->save();
        }
    }
//--------------------------------------------------------------------------------------------------
}
