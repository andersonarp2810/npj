@extends('layouts.defender')
@section('component')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-12 my-5">
      <div class="card">
        <div class="card-header">
          <h4>Gerenciar Petições
            
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
              <p class="alert alert-info" style="width:20%;">{{ Session::get('status') }} <a href="#" class="close"
                  data-dismiss="alert" aria-label="close">&times;</a></p>
              @endif
            </div>
            <div class="row mb-3">
              <div class="col-md-4">
                <div class="input-group">
                  <input type="search" name="" class="form-control" value="" placeholder="Buscar pela descrição..." onkeyup="filtroDeBusca(this.value)">
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fas fa-search"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>


            <div class="table-responsive">
              <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th class="text-center">Status</th>
                    <th class="text-center">Título</th>
                    <th class="text-center">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($petitions as $petition)
                  @if($petition->defender_id == $defender->id || ($petition->student_ok == 'true' &&
                  $petition->teacher_ok == 'true' && $petition->defender_ok == '' && $petition->defender_id == ''))
                  <tr class="object" name="{{$petition->description}}">
                    <td style="font-size:10pt" class="text-center">
                      @if($petition->student_ok == 'true' && $petition->teacher_ok == 'true' && $petition->defender_ok !=
                      'true')
                      AGUARDANDO DEFENSOR
                      @endif
                      @if($petition->defender_ok == 'false' && $petition->student_ok == 'false')
                      DEFENSOR RECUSADA - AGUARDANDO ALUNO
                      @endif
                      @if($petition->defender_ok == 'true' && $petition->defender_id == $defender->id )
                      FINALIZADA / AGUARDANDO EMISSÃO
                      @endif

                    </td>
                    <td style="font-size:10pt" class="text-center">
                      {{$petition->description}}
                    </td>
                    <td style="font-size:18pt;width:15%" class="text-center">
                      @if($petition->defender_ok == 'true' && $petition->defender_id == $defender->id)
                      <button type="button" class="btn btn-outline-success" role="button" onClick="location.href='Peticao/Emitir/{{$petition->id}}'"
                        title="Emitir Petição">EMITIR</button>
                      @endif
                      @if(($petition->defender_ok == 'false' && $petition->teacher_ok == 'true') ||
                      $petition->defender_ok == '')
                      <button type="button" class="btn btn-outline-success" role="button" onClick="location.href='Peticao/Show/{{$petition->id}}'"
                        title="Visualizar Petição"><i class="fa fa-eye"></i></button>
                      @endif
                      @if($petition->student_ok == 'true' && $petition->teacher_ok == 'true' && $petition->defender_ok !=
                      'true')
                      <button type="button" class="btn btn-outline-primary" role="button" onClick="location.href='Peticao/Avaliar/{{$petition->id}}'"
                        title="Avaliar Petição">AVALIAR</button>
                      @endif
                    </td>
                  </tr>
                  @endif
                  @empty
                  <td class="text-center">Nenhuma Petição registrada!</td>
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
@stop