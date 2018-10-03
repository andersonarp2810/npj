<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Human;
use App\Entities\Petition;
use App\Entities\Group;
use App\Entities\DoubleStudent;
use App\User;
use Auth;
use Validator;

use App\Services\DefenderService;

class DefenderController extends Controller
{

public function __construct(DefenderService $service){

  $this->service =$service;

}

  //
  public function index()
  {
      if(Auth::user()->type == 'admin'){
        $petitions = Petition::all()->where('visible','true');
        $defenders = Human::all()->where('status','=','active');
        return view('admin.defender')->with(['defenders'=>$defenders,'petitions'=>$petitions]);
      }else if(Auth::user()->type == 'defender'){
        $defenders = Human::all()->where('user_id','=',Auth::user()->id)->where('status','=','active');
        $defender = $defenders->first();
        if($defender == null){
          return redirect('Sair');
        }
        $petitions = Petition::all();
        $user = Auth::user();

        return view('defender.home')->with(['defender'=>$defender,'petitions'=>$petitions,'user'=>$user]);
    }else{
        return redirect()->back();
    }

  }
//--------------------------------------------------------------------------------------------------
  public function store(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    } 
return $this->service->store($request);
   }
//--------------------------------------------------------------------------------------------------
  public function update(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

          $human = Human::find($request['id']);
          $user = User::find($human->user_id);

  return $this->service->update($human, $user, $request);
  }
//--------------------------------------------------------------------------------------------------
  public function destroy(Request $request)
  {  //
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

     $defender = Human::find($request['id']);
     $defender_User = User::find($defender->user_id);

   return $this->service->destroy($defender, $request);
  }
}
