<?php

namespace App\Services;

use App\Entities\Assisted;
use Illuminate\Http\Request;

class AssistedService
{

    public function store(Request $request)
    {
        Assisted::create($request->all());

        $request->session->flash('status', 'Criado com sucesso!');
    }

    public function update(Request $request, Assisted $assisted)
    {
        $assisted->update($request->all());

        $request->session->flash('status', 'Atualizado com sucesso!');
    }

    public function destroy(Assisted $assisted)
    {
        $assisted->status = 'inactive';
        $assisted->save();

        $request->session->flash('status', 'Deletado com sucesso!');
    }

}
