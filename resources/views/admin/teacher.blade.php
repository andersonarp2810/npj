@extends('layouts.admin')
@section('component')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-12 my-5">

      <div class="card my-5">
        <div class="card-header">
              <h4>
                Gerenciar Professores
                <button type="button" class="btn btn-primary float-right" role="button" data-toggle="modal" data-target="#newModalTeacher" data-toggle="tooltip" data-placement="left" title="Clique para abrir o formulário de novo aluno">
                  <i class="fa fa-plus"></i>
                  Novo Professor
                </button>
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
                  <table class="table table-striped">
                    <thead class="thead-dark">
                      <tr>
                        <th  class="text-center">Nome</th>
                        <th  class="text-center">E-mail</th>
                        <th  class="text-center">Gênero</th>
                        <th  class="text-center">Telefone</th>
                        <th  class="text-center">Grupo</th>
                        <th  class="text-center">Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($teachers as $teacher)
                        @if($teacher->user->type == "teacher")
                          <tr class="my-auto align-middle" name="{{$teacher->name}}">
                            <td class="text-center align-middle">{{$teacher->name}}</td>
                            <td class="text-center align-middle">{{$teacher->user->email}}</td>
                            <td class="text-center align-middle">{{$teacher->gender}}</td>
                            <td class="text-center align-middle">{{$teacher->phone}}</td>
                            <td class="text-center align-middle">
                              @if($teacher->groupT == "SIM")
                              <span class="fas fa-check-circle fa-lg text-success"></span>
                              @else
                              <span class="fas fa-times-circle fa-lg text-danger"></span>
                              @endif
                            </td>
                            <td style="font-size:10pt;width:15%" class="text-center">
                              <button type="button" class="btn btn-outline-warning" role="button" data-toggle="modal" data-target="#editModalTeacher" onclick="editTeacher('{{$teacher->id}}','{{$teacher->name}}','{{$teacher->user->email}}','{{$teacher->gender}}','{{$teacher->phone}}')"><i class="fa fa-edit"></i></button>
                              <button type="button" class="btn btn-outline-danger" role="button" data-toggle="modal" data-target="#deleteModalTeacher" onclick="deleteTeacher('{{$teacher->id}}','{{$teacher->name}}')"><i class="fa fa-trash"></i></button>
                            </td>
                          </tr>
                        @endif
                      @empty
                      <tr class="my-auto align-middle">
                        <td class="text-center" colspan="6">Nenhum Professor registrado!</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
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
          <h4 class="modal-title" id="myModalLabel">Novo Professor</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form action="{{URL::to('Admin/Professor/Cadastrar')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row mb-3">
              <div class="col-md-4">
                <small class="text-danger">* Campos Obrigatórios</small>
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
            <div class="row">
                <div class="col-lg-5">
                  <div class="form-group">
                    <label for="">Sexo</label>
                    <select class="form-control" name="gender" required>
                      <option value="">Selecione o sexo</option>
                      <option value="Masculino">Masculino</option>
                      <option value="Feminino">Feminino</option>
                    </select>
                  </div>
              </div>
              <div class="col-lg-7">
                <div class="form-group">
                  <label for="">Telefone</label>
                  <input type="tel" name="phone" class="form-control input-phone" value="">
                </div>
              </div>
              </div>
            <div class="form-group">
              <label for="">Senha *</label>
              <div class="input-group">
                <input type="password" name="password" class="form-control" id="inputSenha" required>
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
            <div class="row">
                <div class="col-lg-5">
                  <div class="form-group">
                    <label for="">Sexo</label>
                    <select class="form-control" name="gender" required>
                      <option value="">Selecione o sexo</option>
                      <option value="Masculino">Masculino</option>
                      <option value="Feminino">Feminino</option>
                    </select>
                  </div>
              </div>
              <div class="col-lg-7">
                <div class="form-group">
                  <label for="">Telefone</label>
                  <input type="tel" name="phone" class="form-control input-phone" value="">
                </div>
              </div>
              </div>
            <div class="form-group">
              <label for="">Senha</label>
              <input type="password" name="password" class="form-control">
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
</div>
@endsection
