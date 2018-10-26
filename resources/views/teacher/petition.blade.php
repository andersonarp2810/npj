@extends('layouts.teacher')
@section('component')
<div class="container">
  <div class="row justify-content-center my-5">
    <div class="col-lg-12 my-5">
      <div class="card">
        <div class="card-header">
            <h4>
              Avaliar Petições
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
                  <table class="table table-striped ">
                    <thead class="thead-dark">
                      <tr>
                        <th class="text-center">Versão</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Descrição</th>
                        <th class="text-center">Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($petitions as $petition)
                        @if($petition->student_ok != '')
                          <tr class="object align-middle" name="{{$petition->description}}">
                            <td class="text-center align-middle">
                              {{$petition->version}}.0
                            </td>
                            <td class="text-center align-middle">
                            @if($petition->defender_ok == 'true')
                              Finalizada
                            @elseif($petition->student_ok == 'true' && $petition->teacher_ok != 'true')
                              Avaliação Pendente
                            @elseif($petition->student_ok == 'true' && $petition->teacher_ok == 'true' && $petition->defender_ok != 'true')
                              Avaliação - Defensor
                            @elseif($petition->student_ok == 'false' && $petition->defender_ok == 'false')
                              Recusada - Defensor
                            @elseif($petition->teacher_ok == 'false' && $petition->student_ok == 'false')
                              Recusada - Aguardando Aluno
                            @endif
                            </td>
                            <td class="text-center align-middle">
                              {{$petition->description}}
                            </td>
                            <td class="text-center align-middle">
                              <button type="button" class="btn btn-outline-primary" role="button" onClick="location.href='Peticao/Avaliar/{{$petition->id}}'" title="Avaliar Petição">
                                <span class="fas fa-gavel"></span>
                              </button>
                            </td>
                          </tr>
                        @endif
                        @empty
                        <tr>
                          <td class="text-center" colspan="3">Nenhuma Petição à ser Avaliada!</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
       
       
        
        </div>
      </div>
    </div>



@endsection
