<?php

namespace App\Http\Controllers;

use App\Entities\Assisted;
use App\Services\AssistedService;
use Auth;
use Illuminate\Http\Request;

class AssistedController extends Controller
{
    public function __construct(AssistedService $service)
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
        //
        $user = Auth::user();
        if ($user->type == 'student' || $user->type == 'admin') {
            $assisteds = Assisted::all()->where('status', 'active');
            return view($user->type . '.assistedIndex', ['assisteds' => $assisteds]);
        }

        return redirect()->back();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = Auth::user();
        if ($user->type == 'student' || $user->type == 'admin') {
            return view(Auth::user()->type . '.assistedCreate');
        }

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = Auth::user();
        if ($user->type == 'student' || $user->type == 'admin') {
            $this->service->store($request);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Assisted  $assisted
     * @return \Illuminate\Http\Response
     */
    public function show(Assisted $assisted)
    {
        //
        return view(Auth::user()->type . '.assistedShow', ['assisted' => $assisted]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entities\Assisted  $assisted
     * @return \Illuminate\Http\Response
     */
    public function edit(Assisted $assisted)
    {
        //
        $user = Auth::user();
        if ($user->type == 'student' || $user->type == 'admin') {
            return view(Auth::user()->type . '.assistedEdit', ['assisted' => $assisted]);
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Assisted  $assisted
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assisted $assisted)
    {
        //
        $user = Auth::user();
        if ($user->type == 'student' || $user->type == 'admin') {
            $this->service->update($request, $assisted);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Assisted  $assisted
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assisted $assisted)
    {
        //
        $user = Auth::user();
        if ($user->type == 'student' || $user->type == 'admin') {
            $this->service->destroy($assisted);
        }

        return redirect()->back();
    }

    public function peticoes(Assisted $assisted)
    {
        $user = Auth::user();
        if ($user->type == 'student' || $user->type == 'admin') {
            $petitions = Petition::all()->where('assisted_id', $assisted->id)->where('status', 'active');
            return view($user->type . 'assistedPetition', ['petitions' => $petitions, 'assisted' => $assisted]);
        }
        return redirect()->back();
    }
}
