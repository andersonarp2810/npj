<?php

namespace App\Http\Controllers;

use App\Entities\Petition;
use App\Entities\Human;
use App\Entities\DoubleStudent;
use App\Entities\Group;
use App\Entities\Template;
use App\User;
use Auth;

use Illuminate\Http\Request;

use App\Services\TemplateService;

class TemplateController extends Controller
{

public function __construct(TemplateService $service)
    {
        $this->service = $service;
    }
//--------------------------------------------------------------------------------------------------
    public function index(){

      if(Auth::user()->type == 'teacher'){
        $teachers = Human::all()->where('user_id','=',Auth::user()->id)->where('status','=','active');
        $teacher = $teachers->first();//professor
        $templates = Template::all()->where('teacher_id',$teacher->id);
        $defenders = Human::all()->where('user_id','=',Auth::user()->id)->where('status','=','active');
        $defender = $defenders->first();
        $petitions = Petition::all()->where('defender_id','=',$defender->id);
        $humans = Human::all()->where('status','=','active');
        $user = Auth::user();
        return view('teacher.template')->with(['teacher'=>$teacher,'templates'=>$templates,'defender'=>$defender,'petitions'=>$petitions,'humans'=>$humans,'user'=>$user]);
      }else{
          return redirect()->back();
      }

    }
//--------------------------------------------------------------------------------------------------
    public function add(){//Professor
      if(Auth::user()->type != 'teacher'){
        return redirect()->back();
      }
        $humans = Human::all()->where('status','active');
        return view('teacher.templateCadastrar')->with(['humans'=>$humans]);
    }
//--------------------------------------------------------------------------------------------------
    public function store(Request $request){
      if(Auth::user()->type == 'teacher'){
        return $this->service->store($request);
      }else{
          return redirect()->back();
      }
    }
//--------------------------------------------------------------------------------------------------
    public function update(Request $request){
      if(Auth::user()->type == 'teacher'){
        return $this->service->update($request);
      }else{
          return redirect()->back();
      }
    }
//--------------------------------------------------------------------------------------------------

      public function editStatus(Request $request)
      {
        if(Auth::user()->type == 'teacher'){
          return $this->service->editStatus($request);
        }else{
          return redirect()->back();
        }
        return null;
      }
//--------------------------------------------------------------------------------------------------
}
