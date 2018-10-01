@extends('layouts.teacher')
@section('content')
<div class="card">
  <h4 class="card-title">Gerenciar Templates</h4>

  <div class="card-body">
    <div class="col-lg-12">
      <div class="card">
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
        <div class="row">
          <div class="col-md-4">
            <h4></h4>
          </div>
          <div class="col-md-4">
            <span class="text-center">
              <div class="input-group">
                <input type="search" name="" class="form-control" value="" placeholder="Buscar por título..." onkeyup="filtroDeBusca(this.value)">
                <span class="input-group-addon">
                  <i class="fa fa-search"></i>
                </span>
              </div>
            </span>
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-md btn-primary pull-right" onClick="location.href='{{URL::to('Professor/Template/Add')}}'" title="Clique para abrir o formulário de novo Template" ><i class="fa fa-plus"></i>Novo Template</button>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-condensed table-striped table-bordered">
              <thead class="table">
                <tr>
                  <th style="font-size:18pt" class="text-center">STATUS</th>
                  <th style="font-size:18pt" class="text-center">TÍTULO</th>
                  <th style="font-size:18pt" class="text-center">AÇÕES</th>
                </tr>
              </thead>
              <tbody>
                @forelse($templates as $template)
                    <tr class="object" name="{{$template->title}}">
                      <td style="font-size:10pt" class="text-center">
                        @if($template->status == 'inactive')
                         <button class="btn btn-danger" onclick="mudarStatusTemplate({{$template->id}})" title="POSTAR Template">Postar</button>
                       @else
                         <button type="button" class="btn btn-md btn-success" role="button" onclick="mudarStatusTemplate({{$template->id}})" title="Tornar Rascunho">Tornar Rascunho</button>
                       @endif
                      </td>
                      <td style="font-size:10pt" class="text-center">{{$template->title}}</td>
                      <td style="font-size:10pt;width:15%;" class="text-center">
                        <button type="button" class="btn btn-outline-success" role="button" onClick="location.href='Template/Show/{{$template->id}}'" title="Editar Template"><i class="fa fa-eye"></i></button>
                        <button type="button" class="btn btn-outline-warning" role="button" onClick="location.href='Template/Edit/{{$template->id}}'" title="Editar Template"><i class="fa fa-pencil"></i></button>
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
</div>
@stop
