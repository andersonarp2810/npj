<?php

namespace App\Http\Controllers;

use App\Entities\Log;
use Illuminate\Http\Request;
use Auth;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Auth::user()->type!='admin'){
            return redirect()->back();
        }

        $logs = Log::all()->sortByDesc('created_at'); # ordenar por mais recente

        return view('admin.log')->with(['logs' => $logs]);
    }

    #logs são gerados automaticamente e não devem sofrer qualquer modificação (eu acho) então aqui só vai ter isso mesmo até segunda ordem
}
