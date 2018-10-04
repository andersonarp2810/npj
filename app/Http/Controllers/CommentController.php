<?php

namespace App\Http\Controllers;

use App\Entities\Petition;
use App\Services\CommentService;
use App\User;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {

        $petition = Petition::find($request['idPetition']);
        if (Auth::user()->type == 'teacher') {

            return $this->service->professorStore($request, $petition);

        } else if (Auth::user()->type == 'defender') { //Área do Defensor

            return $this->service->defensorStore($request, $petition);

        } else {
            $request->session()->flash('status', 'Você não possui Autorização de Acesso!!');
            return redirect()->back();
        }
    }
}
