<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()

    {
      if(Auth::user()->type == "admin"){
        return redirect('Admin');
      }elseif(Auth::user()->type == "student"){
        return redirect('Aluno');
      }elseif(Auth::user()->type == "teacher"){
        return redirect('Professor');
      }elseif(Auth::user()->type == "defender"){
        return redirect('Defensor');
      }
      return redirect('/');
    }
}
