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

class DefenderController extends Controller
{
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

  public function store(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

      $validate = Validator::make($request->all(), [
          'email' => 'required|string|email|max:255|unique:users',
          'password' => 'required|string|min:6',
          ]);

          if($validate->fails()){
              $request->session()->flash('status', 'Falha ao cadastrar novo Defensor!');
          }else{

            $user = User::create([
               'type'     => 'defender',
               'email'    => $request->email,
               'password' => bcrypt($request->password),
            ]);

            $human = Human::create([
               'status'=>'active',
               'name'=> $request->name,
               'phone'=> $request->phone,
               'gender'=> $request->gender,
               'user_id'=>$user->id
            ]);

                $request->session()->flash('status', 'Defensor cadastrado com sucesso!');
              }
                  return redirect()->back()->withErrors($validate)->withInput();
          }

  public function update(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

          $human = Human::find($request['id']);
          $user = User::find($human->user_id);

          if($request['password'] != null){
              $user->password = bcrypt($request['password']);
          }
          $human->name = $request['name'];
          $human->gender = $request['gender'];
          $human->phone = $request['phone'];
          $user->email = $request['email'];
          $user->save();
          $human->save();
          $request->session()->flash('status', 'Defensor editado com sucesso!');
      return redirect()->back();
  }

  public function destroy(Request $request)
  {  //
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

     $defender = Human::find($request['id']);
     $defender_User = User::find($defender->user_id);

     if($defender != null){
        if($defender->status == "active" && $defender_User->type == "defender"){
            $defender->status = "inactive";
            $defender->save();
            $request->session()->flash('status', 'Defensor excluído com sucesso!');
        }
     }
     return redirect()->back();
  }
}
