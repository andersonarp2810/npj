<?php

namespace App\Services;

use App\Entities\Human;
use App\User;
use Illuminate\Http\Request;
use Validator;

class SupervisorService
{

    public function index()
    {

    }
//--------------------------------------------------------------------------------------------------
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validate->fails()) {
            $request->session()->flash('status', 'Falha ao cadastrar novo Supervisor!');
        } else {

            $user = User::create([
                'type' => 'supervisor',
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $human = Human::create([
                'status' => 'active',
                'name' => $request->name,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'user_id' => $user->id,
            ]);

            $request->session()->flash('status', 'Supervisor cadastrado com sucesso!');
        }
        return redirect()->back()->withErrors($validate)->withInput();
    }
//--------------------------------------------------------------------------------------------------
    public function editar(Human $human, User $user, Request $request)
    {
        if ($request['password'] != null) {
            $user->password = bcrypt($request['password']);
        }
        $human->name = $request['name'];
        $human->gender = $request['gender'];
        $human->phone = $request['phone'];
        $user->email = $request['email'];
        $user->save();
        $human->save();
        $request->session()->flash('status', 'Supervisor editado com sucesso!');
        return redirect()->back();
    }
//--------------------------------------------------------------------------------------------------
    public function destroy(Request $request, Human $supervisor, User $supervisor_User)
    {
        if ($supervisor != null) {
            if ($supervisor->status == "active" && $supervisor_User->type == "supervisor") {
                $supervisor->status = "inactive";
                $supervisor->save();
                $request->session()->flash('status', 'Supervisor excluído com sucesso!');
            }
        }
        return redirect()->back();
    }
}
