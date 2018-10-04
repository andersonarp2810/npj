<?php

namespace App\Http\Controllers;

use App\Entities\Human;
use App\Services\AdminService;
use App\User;
use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type != 'admin') {
            return redirect()->back();
        }

        $dados = $this->service->index();

        return view('admin.home')->with($dados);
    }

    public function preferences()
    {
        $user = User::find(Auth::user()->id);
        $human = Human::where('user_id', $user->id)->first();
        return view('admin.preferences')->with(['user' => $user, 'human' => $human]);
    }

    public function editar(Request $request)
    {
        $user = User::find($request['idUser']);
        $human = Human::find($request['idHuman']);

        return $this->service->editar($human, $user, $request);
    }

}
