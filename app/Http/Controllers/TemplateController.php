<?php

namespace App\Http\Controllers;

use App\Entities\Human;
use App\Entities\Template;
use App\Services\TemplateService;
use App\User;
use Auth;
use Illuminate\Http\Request;

class TemplateController extends Controller
{

    public function __construct(TemplateService $service)
    {
        $this->service = $service;
    }
//--------------------------------------------------------------------------------------------------
    public function index()
    {

        if (Auth::user()->type == 'teacher') {
            $dados = $this->service->index();
            return view('teacher.template')->with($dados);
        } else {
            return redirect()->back();
        }

    }
//--------------------------------------------------------------------------------------------------
    public function add()
    { //Professor
        if (Auth::user()->type != 'teacher') {
            return redirect()->back();
        }
        $humans = Human::all()->where('status', 'active');
        return view('teacher.templateCadastrar')->with(['humans' => $humans]);
    }
//--------------------------------------------------------------------------------------------------
    public function store(Request $request)
    {
        if (Auth::user()->type == 'teacher') {
            $this->service->store($request);
            return redirect('Professor/Templates');
        } else {
            return redirect()->back();
        }
    }
//--------------------------------------------------------------------------------------------------
    public function update(Request $request)
    {
        if (Auth::user()->type == 'teacher') {
            $this->service->update($request);
            return redirect('Professor/Templates');
        } else {
            return redirect()->back();
        }
    }
//--------------------------------------------------------------------------------------------------

    public function editStatus(Request $request)
    {
        if (Auth::user()->type == 'teacher') {
            $this->service->editStatus($request);
            return response()->json(['status' => $status]);
        } else {
            return redirect()->back();
        }
        return null;
    }
//--------------------------------------------------------------------------------------------------

    public function edit(Request $request, $id)
    {
        $template = Template::find($id);
        $hu = Human::all()->where('user_id', Auth::user()->id)->first();

        if ($template != null && ($hu->id == $template->teacher_id)) { //se template pertencer ao usuario corrente
            return view('teacher.templateEditar')->with(['template' => $template]);
        } else {
            return redirect()->back();
        }
    }

    public function show(Request $request, $id)
    {
        $template = Template::find($id);
        $hu = Human::all()->where('user_id', Auth::user()->id)->first();

        if ($template != null && ($hu->id == $template->teacher_id)) { //se tempalte pertencer ao usuario corrente
            $humans = Human::all()->where('status', 'active');
            return view('teacher.templateShow')->with(['template' => $template, 'humans' => $humans]);
        } else {
            return redirect()->back();
        }
    }
}
