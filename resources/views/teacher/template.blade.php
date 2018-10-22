@extends('layouts.teacher')
@section('component')
<div class="container">
  <div class="row justify-content-center my-5">
    <div class="col-lg-12 my-5">
      <div class="card">
        <div class="card-header">
            <h4>
                Gerenciar Templates
                <button type="button" class="btn btn-md btn-primary float-right" onClick="location.href='{{URL::to('Professor/Template/Add')}}'" title="Clique para abrir o formulário de novo Template" ><i class="fa fa-plus"></i>Novo Template</button>
            </h4>
        </div>
        <div class="card-body">
          <div class="col-lg-12">
              <div class="row">
                @if ($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif
                @if(Session::has('status'))
                  <p class="alert alert-info" style="width:20%;">{{ Session::get('status') }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
              </div>
              <div class="row mb-3">
                <div class="col-md-4">
                  <div class="input-group">
                    <input type="search" name="" class="form-control" value="" placeholder="Buscar por nome..." onkeyup="filtroDeBusca(this.value)">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="fas fa-search"></i>
                      </span>
                    </div>
                  </div>
                </div>
            </div>
             
                <div class="table-responsive">
                  <table class="table table-condensed table-striped table-bordered">
                    <thead class="table">
                      <tr>
                        <th class="text-center">Status</th>
                        <th class="text-center">Título</th>
                        <th class="text-center">Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($templates as $template)
                          <tr class="object align-middle" name="{{$template->title}}">
                            <td class="text-center align-middle">
                              @if($template->status == 'inactive')
                               <button class="btn btn-danger" onclick="mudarStatusTemplate({{$template->id}})" title="POSTAR Template">Postar</button>
                             @else
                               <button type="button" class="btn btn-md btn-success" role="button" onclick="mudarStatusTemplate({{$template->id}})" title="Tornar Rascunho">Tornar Rascunho</button>
                             @endif
                            </td>
                            <td class="text-center align-middle">{{$template->title}}</td>
                            <td class="text-center align-middle">
                              <button type="button" class="btn btn-outline-success" role="button" onClick="location.href='Template/Show/{{$template->id}}'" title="Editar Template"><i class="fa fa-eye"></i></button>
                              <button type="button" class="btn btn-outline-warning" role="button" onClick="location.href='Template/Edit/{{$template->id}}'" title="Editar Template"><i class="fa fa-edit"></i></button>
                            </td>
                          </tr>
                      @empty
                      <td class="text-center">Nenhum Template registrado!</td>
                      @endforelse
                    </tbody>
                  </table>
                    </div>
      

      </div>  
    </div>
  </div>
</div>


@endsection