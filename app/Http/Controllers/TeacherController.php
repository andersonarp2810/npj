<?php

namespace App\Http\Controllers;

use App\Entities\Human;
use App\Services\TeacherService;
use App\User;
use Auth;
use Illuminate\Http\Request;

class TeacherController extends Controller
{

    public function __construct(TeacherService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        if (Auth::user()->type == 'admin') {
            $teachers = Human::all()->where('status', '=', 'active');
            return view('admin.teacher')->with(['teachers' => $teachers]);
        } else if (Auth::user()->type == 'teacher') {
            $dados = $this->service->index();
            return view('teacher.home')->with($dados);
        } else {
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->type != 'admin') {
            return redirect()->back();
        }
        return $this->service->store($request);
    }

    public function update(Request $request)
    {
        if (Auth::user()->type != 'admin') {
            return redirect()->back();
        }
        $human = Human::find($request['id']);
        $user = User::find($human->user_id);

        return $this->service->update($human, $user, $request);
    }

    public function destroy(Request $request)
    {
        if (Auth::user()->type != 'admin') {
            return redirect()->back();
        }

        $teacher = Human::find($request['id']); //Pega o id do professor

        return $this->service->destroy($request, $teacher);
    }

  public function preferences()
  {
      $user = User::find(Auth::user()->id);
      $human = Human::where('user_id', $user->id)->first();
      return view('teacher.preferences')->with(['user' => $user, 'human' => $human]);
  }

  public function preferencesEditar(Request $request)
  {
    $user = User::find($request['idUser']);
    $human = Human::find($request['idHuman']);

    return $this->service->editar($human, $user, $request);
  }

}
