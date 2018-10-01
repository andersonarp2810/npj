<?php

namespace App\Http\Controllers;

use App\User;
use App\Entities\Comment;
use App\Entities\DoubleStudent;
use App\Entities\Group;
use App\Entities\Human;
use App\Entities\Petition;
use App\Entities\Template;
use Illuminate\Http\Request;
use Auth;
use Validator;

class AdminController extends Controller
{

  /**
 * Create a new controller instance.
 *
 * @return void
 */
 public function __construct()
 {
     $this->middleware('auth');
 }

 /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
 public function index()
 {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }
    $count = 1;
    //
    $countG = 1;
    //
    $doubleStudents = DoubleStudent::all()->where('status','active')->sortByDesc('qtdPetitions');
    //
    $humans = Human::all()->where('status','active');
     //
     $petitions = Petition::all();
     //
     $groups = Group::all()->where('status','active')->sortByDesc('qtdPetitions');
     //
     $templates = Template::all()->where('status','active');
     //
     $comments = Comment::all();
     //
     $users = User::all();
     //
     return view('admin.home')->with(['count'=>$count,'countG'=>$countG,'doubleStudents'=>$doubleStudents,'humans'=>$humans,'petitions'=>$petitions,'groups'=>$groups,'templates'=>$templates, 'comments'=>$comments, 'users'=>$users]);
 }

 public function preferences()
 {
   if(Auth::user()->type != 'admin'){
     return redirect()->back();
   }
   $user  = User::find(Auth::user()->id);
   $human = Human::where('user_id',$user->id)->first();
   return view('admin.preferences')->with(['user'=>$user,'human'=>$human]);
 }

 public function editar(Request $request)
 {
   $user = User::find($request['idUser']);
   $human = Human::find($request['idHuman']);

   $human->name = $request['name'];
   $human->gender = $request['gender'];
   $human->phone = $request['phone'];
   $user->email = $request['email'];

   if($request['password'] != null){
     $user->password = $request['password'];
   }
   $human->save();
   $user->save();
   $request->session()->flash('status', 'Dados salvos com sucesso!!');
   return redirect()->back();
 }

}
