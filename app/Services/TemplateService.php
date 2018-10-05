<?php

namespace App\Services;

use App\Entities\Petition;
use App\Entities\Human;
use App\Entities\DoubleStudent;
use App\Entities\Group;
use App\Entities\Template;
use App\User;
use Auth;

use Illuminate\Http\Request;

class TemplateService{

	public function store(Request $request){
     $teacher = Human::all()->where('user_id','=',Auth::user()->id)->where('status','=','active')->first();
        if($request->botao == 'POSTAR'){//professor clicou em POSTAR Template
          $template = Template::create([
            'title'      => $request['title'],
            'content'    => $request['content'],
            'teacher_id' => $teacher->id,
          ]);
          $request->session()->flash('status', 'Template postado com sucesso!');
        }else if($request->botao == 'SALVAR'){//Professor clicou em SALVAR Template
          $template = Template::create([
            'title'      => $request['title'],
            'content'    => $request['content'],
            'teacher_id' => $teacher->id,
            'status'     => 'inactive',
          ]);
          $request->session()->flash('status', 'Template salvo com sucesso!');
        }
        return redirect('Professor/Templates');
	}
//--------------------------------------------------------------------------------------------------
  public function update(Request $request){
  $teachers = Human::all()->where('user_id','=',Auth::user()->id)->where('status','=','active');
        $teacher = $teachers->first();//professor
        $template = Template::find($request['idTemplate']);

        if($template->title != $request['title']){
          $template->title = $request['title'];
          $template->save();
        }

        if($template->content != $request['content']){
          $template->content = $request['content'];
          $template->save();
        }
        $request->session()->flash('status', 'Template editado com Sucesso!!');
        return redirect('Professor/Templates');
  }
//--------------------------------------------------------------------------------------------------

public function editStatus(Request $request){
$template = Template::find($request['id']);
          if($template != null){
              $status = "";
              if($template->status == "active"){
                $template->status = "inactive";
                $status = "inactive";
              }else{
                $template->status = "active";
                $status = "active";
              }
              $template->save();
              return response()->json(['status' => $status]);
          }
}
//--------------------------------------------------------------------------------------------------
}