@extends('layouts.admin')
@section('content')
<div class="card">
  <h4 class="card-title">Gerenciar Grupos</h4>
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
                <input type="search" name="" class="form-control" value="" placeholder="Buscar por nome..." onkeyup="filtroDeBusca(this.value)">
                <span class="input-group-addon">
                  <i class="fa fa-search"></i>
                </span>
              </div>
            </span>
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-md btn-primary pull-right" role="button" data-toggle="modal" data-target="#newModalGroup" data-toggle="tooltip" data-placement="left" title="Clique para abrir o formulário de novo grupo"><i class="fa fa-plus"></i> Novo Grupo</button>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead class="thead-dark">
                <tr>
                  <th style="font-size:18pt" class="text-center">NOME</th>
                  <th style="font-size:18pt" class="text-center">PROFESSOR</th>
                  <th style="font-size:18pt" class="text-center">QTD DUPLAS</th>
<!--                  <th>QTD PETIÇÕES</th>-->
                  <th style="font-size:18pt" class="text-center">AÇÕES</th>
                </tr>
              </thead>
              <tbody>
                @forelse($groups as $group)
                  @if($group->status == 'active')
                      <tr class="object" name="{{$group->name}}">
                        <td style="font-size:10pt" class="text-center">{{$group->name}}</td>
                        <td style="font-size:10pt" class="text-center">{{$humans->find($group->teacher_id)->name}}</td>
                        <td style="font-size:10pt" class="text-center">{{$doubleStudents->where('group_id',$group->id)->count()}}</td>
                        <!--Pegar qtd de peticoes por dupla-->
                        <td style="font-size:10pt;width:15%" class="text-center">
                          <button type="button" class="btn btn-outline-warning" role="button" data-toggle="modal" data-target="#editModalGroup" onclick="editModalGroup('{{$group->id}}','{{$group->name}}','{{$group->teacher_id}}')" title="Editar Grupo"><i class="fa fa-pencil"></i></button>
                          <button type="button" class="btn btn-outline-danger" role="button" data-toggle="modal" data-target="#deleteModalGroup" onclick="deleteGroup('{{$group->id}}','{{$group->name}}')" title="Excluir Grupo"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                  @endif
                @empty
                    <td class="text-center">Nenhum Grupo registrado!</td>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newModalGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Nova Dupla</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-8">
          </div>
          <div class="col-md-4">
            <small class="pull-right">* Campos Obrigatórios</small>
          </div>
        </div>
        <form action="{{URL::to('Admin/Grupo/Cadastrar')}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row" style="margin-left:2%">
            <div class="form-group">
              <label for="">Nome</label>
              <input type="text" name="name" class="form-control" maxlength="80" value="" required>
            </div>
            <div class="form-group">
              <label for="">Professor</label>
              <select class="form-control" name="teacher_id" required>
                <option value="">Selecione o professor</option>
                @foreach($humans as $human)
                  <!--Está sem validação-->
                  @if($human->user->type == 'teacher' && $human->status == 'active' && $human->groupT == 'NAO')
                    <option value="{{$human->id}}">{{$human->name}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="row" style="margin-left:2px">
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
          </div>
      </form>
    </div>
  </div>
</div>
</div>





<div class="modal fade" id="editModalGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Editar Grupo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">

        <form action="{{URL::to('Admin/Grupo/Editar')}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row" style="margin-left:2%">
            <input type="hidden" name="id" id="groupId">
            <div class="form-group">
              <label for="">Nome</label>
              <input type="text" name="name" class="form-control" maxlength="80" value="" id="groupName" required>
            </div>
            <div class="form-group">
              <label for="">Professor</label>
              <select class="form-control" name="teacher_id" id="groupTeacher_id">
                <option value="">Selecione o professor</option>
                @foreach($humans as $human)
                  <!--Está sem validação(precisa)-->
                  @if($human->user->type == 'teacher' && $human->status == 'active' && $human->groupT == 'NÃO')
                    <option value="{{$human->id}}">{{$human->name}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="deleteModalGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form action="{{URL::to('Admin/Grupo/Excluir')}}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="id" id="deleteIdGroup" value="">
          <div class="text-center">
            <i class="fa fa-exclamation-circle fa-x6" aria-hidden="true"></i>
          </div>
          <h3 class="text-center"><strong style="color:red;">Atenção!</strong></h3>
          <p class="text-center">Caso deseje excluir o "GRUPO" clique no botão confirmar</p>
          <h4 class="text-center"><strong id="deleteNameGroup"></strong></h4>
          <br>
          <div class="text-center">
            <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-danger btn-lg">Confirmar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@stop
