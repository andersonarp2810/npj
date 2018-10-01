@extends('layouts.teacher')
@section('content')
<div class="card" style="margin-left:2%">
  <h4 class="card-title">Avaliar Petições</h4>

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
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <span class="text-center">
              <div class="input-group">
                <input type="search" name="" class="form-control" value="" placeholder="Buscar por Descrição..." onkeyup="filtroDeBusca(this.value)">
                <span class="input-group-addon">
                  <i class="fa fa-search"></i>
                </span>
              </div>
            </span>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-condensed table-striped table-bordered">
              <thead class="table">
                <tr>
                  <th style="font-size:18pt" class="text-center">VERSÃO</th>
                  <th style="font-size:18pt" class="text-center">DESCRIÇÃO</th>
                  <th style="font-size:18pt" class="text-center">AÇÕES</th>
                </tr>
              </thead>
              <tbody>
                @forelse($petitions as $petition)
                  @if($petition->student_ok == 'true' && $petition->teacher_ok != 'true')
                    <tr class="object" name="{{$petition->description}}">
                      <td style="width:15%;font-size:10pt;" class="text-center">{{$petition->version}}.0</td>
                      <td class="text-center" style="font-size:10pt">{{$petition->description}}</td>
                      <td style="font-size:10pt;width:15%;"class="text-center">
                        <button type="button" class="btn btn-outline-primary" role="button" onClick="location.href='Peticao/Avaliar/{{$petition->id}}'" title="Avaliar Petição">AVALIAR</button>
                      </td>
                    </tr>
                  @endif
                @empty
                <td class="text-center">Nenhuma Petição à ser Avaliada!</td>
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
