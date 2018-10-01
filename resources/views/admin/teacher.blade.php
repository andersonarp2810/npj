@extends('layouts.admin')
@section('content')
<div class="card">
  <h4 class="card-title">Gerenciar Professores</h4>

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
            <button type="button" class="btn btn-md btn-primary pull-right" role="button" data-toggle="modal" data-target="#newModalTeacher" data-toggle="tooltip" data-placement="left" title="Clique para abrir o formulário de novo professor"><i class="fa fa-plus"></i> Novo Professor</button>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead class="thead-dark">
                <tr>
                  <th style="font-size:18pt" class="text-center">NOME</th>
                  <th style="font-size:18pt" class="text-center">E-MAIL</th>
                  <th style="font-size:18pt" class="text-center">GÊNERO</th>
                  <th style="font-size:18pt" class="text-center">TELEFONE</th>
                  <th style="font-size:18pt" class="text-center">GRUPO</th>
                  <th style="font-size:18pt" class="text-center">AÇÕES</th>
                </tr>
              </thead>
              <tbody>
                @forelse($teachers as $teacher)
                  @if($teacher->user->type == "teacher")
                    <tr class="object" name="{{$teacher->name}}">
                      <td style="font-size:10pt" class="text-center">{{$teacher->name}}</td>
                      <td style="font-size:10pt" class="text-center">{{$teacher->user->email}}</td>
                      <td style="font-size:10pt" class="text-center">{{$teacher->gender}}</td>
                      <td style="font-size:10pt" class="text-center">{{$teacher->phone}}</td>
                      <td style="font-size:10pt" class="text-center">{{$teacher->groupT}}</td>
                      <td style="font-size:10pt;width:15%" class="text-center">
                        <button type="button" class="btn btn-outline-warning" role="button" data-toggle="modal" data-target="#editModalTeacher" onclick="editTeacher('{{$teacher->id}}','{{$teacher->name}}','{{$teacher->user->email}}','{{$teacher->gender}}','{{$teacher->phone}}')"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="btn btn-outline-danger" role="button" data-toggle="modal" data-target="#deleteModalTeacher" onclick="deleteTeacher('{{$teacher->id}}','{{$teacher->name}}')"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
                  @endif
                @empty
                <td class="text-center">Nenhum Professor registrado!</td>
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
<div class="modal fade" id="newModalTeacher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Novo Professor </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form action="{{URL::to('Admin/Professor/Cadastrar')}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-8">
            </div>
            <div class="col-md-4">
              <small class="pull-right" style="color:red">* Campos Obrigatórios</small>
            </div>
          </div>
          <div class="form-group">
            <label for="">Nome *</label>
            <input type="text" name="name" class="form-control" maxlength="80" value="" required>
          </div>
          <div class="form-group">
            <label for="">E-mail *</label>
            <input type="email" name="email" class="form-control" maxlength="80" value="" required>
          </div>
          <div class="row" style="margin-left:2px">
            <div class="form-group">
            <label for="">Sexo</label>
            <select class="form-control" name="gender" required>
              <option value="">Selecione o sexo</option>
              <option value="Masculino">Masculino</option>
              <option value="Feminino">Feminino</option>
            </select>
          </div>
          <div class="form-group">
              <label for="">Telefone</label>
              <input type="tel" name="phone" class="form-control input-phone" value="">
            </div>
          </div>
          <div class="form-group">
            <label for="">Senha *</label>
            <div class="input-group">
              <input type="text" name="password" class="form-control" id="inputSenha" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModalTeacher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Editar Professor</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">

        <form action="{{URL::to('Admin/Professor/Editar')}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-8">
            </div>
          </div>
          <input type="hidden" name="id" id="teacherId">
          <div class="form-group">
            <label for="">Nome</label>
            <input type="text" name="name" class="form-control" maxlength="80" value="" id="teacherName" required>
          </div>

          <div class="form-group">
            <label for="">E-mail</label>
            <input type="email" name="email" class="form-control" maxlength="80" value="" id="teacherEmail" required>
          </div>
        <div class="row" style="margin-left:2px">
          <div class="form-group">
            <label for="">Sexo</label>
            <select class="form-control" name="gender" id="teacherGender" required>
              <option value="">Selecione o sexo</option>
              <option value="Masculino">Masculino</option>
              <option value="Feminino">Feminino</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Telefone</label>
            <input type="tel" name="phone" class="form-control input-phone" id="teacherPhone" value="">
          </div>
        </div>
          <div class="form-group">
            <label for="">Senha</label>
            <input type="text" name="password" class="form-control">
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

<!-- Modal -->
<div class="modal fade" id="deleteModalTeacher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form action="{{URL::to('Admin/Professor/Excluir')}}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="id" id="deleteIdTeacher" value="">
          <div class="text-center">
            <i class="fa fa-exclamation-circle fa-x6" aria-hidden="true"></i>
          </div>
          <h3 class="text-center"><strong style="color:red;">Atenção!</strong></h3>
          <p class="text-center">Caso deseje excluir o "Professor" clique no botão confirmar</p>
          <h4 class="text-center"><strong id="deleteNameTeacher"></strong></h4>
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
