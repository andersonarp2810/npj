<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Human;
use App\Entities\Group;
use App\Entities\Petition;
use App\Entities\DoubleStudent;
use Auth;
use Validator;

use App\Services\GroupService;

class GroupController extends Controller
{

public function __construct(GroupService $service)
    {
        $this->service = $service;
    }
//--------------------------------------------------------------------------------------------------
  public function index()
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }
    $dados = $this->service->index();

    return view('admin.group')->with($dados);
  }
//--------------------------------------------------------------------------------------------------
  public function store(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

    return $this->service->store($request);
    return redirect()->back();

  }
//--------------------------------------------------------------------------------------------------
  //alterar update
  public function update(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }
          return $this->service->update($request);
          return redirect()->back();
  }
//--------------------------------------------------------------------------------------------------
  public function destroy(Request $request)
  {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }
    return $this->service->destroy($request);
    return redirect()->back();
  }
//--------------------------------------------------------------------------------------------------
}
