<?php

namespace App\Http\Controllers;

use App\Entities\Comment;
use App\Entities\Petition;
use App\Entities\Group;
use App\Entities\Human;
use App\User;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request){

      $petition = Petition::find($request['idPetition']);
      if(Auth::user()->type == 'teacher'){
        $group = Group::find($petition->group_id);
        $teacher = Human::find($group->teacher_id);

        if($request->botao == 'APROVAR'){
          $petition->teacher_ok = 'true';
          $petition->save();

        }else if($request->botao == 'REPROVAR'){//se estiver clicado em REPROVAR
          $comment = Comment::create([
            'content'     => $request['comment'],
            'human_id'    => $teacher->id,
            'petition_id' => $request['idPetition'],
          ]);
          $petition->student_ok = 'false';
          $petition->teacher_ok = 'false';
          $petition->save();
          $request->session()->flash('status', 'Avaliação realizada com Sucesso!!');
        }
        return redirect('Professor/Peticoes');

      }else if(Auth::user()->type == 'defender'){//Área do Defensor
        $defender = Human::where('user_id',Auth::user()->id)->first();
        if($request->botao == 'APROVAR'){
          $petition->defender_ok = 'true';
          $petition->defender_id = $defender->id;//petição passa a estar vinculada ao defensor
          $petition->save();

        }else if($request->botao == 'REPROVAR'){//se estiver clicado em REPROVAR
          $comment = Comment::create([
            'content'     => $request['comment'],
            'human_id'    => $defender->id,
            'petition_id' => $request['idPetition'],
          ]);
          $petition->student_ok = 'false';
//          $petition->teacher_ok = null;
          $petition->defender_ok = 'false';
          $petition->defender_id = $defender->id;//petição passa a estar vinculada ao defensor
          $petition->save();
          $request->session()->flash('status', 'Avaliação realizada com Sucesso!!');
        }
        return redirect('Defensor/Peticoes');

      }else{
          $request->session()->flash('status', 'Você não possui Autorização de Acesso!!');
          return redirect()->back();
      }
    }
}
