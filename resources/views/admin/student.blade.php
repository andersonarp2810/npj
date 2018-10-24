@extends('layouts.admin')
@section('component')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-12 my-5">
      <div class="card my-5">
        <div class="card-header">
          <h4>
            Gerenciar Alunos
            <button type="button" class="btn btn-primary float-right" role="button" data-toggle="modal" data-target="#newModalStudent" data-toggle="tooltip" data-placement="left" title="Clique para abrir o formulário de novo aluno">
              <i class="fa fa-plus"></i>
              Novo Aluno
            </button>
          </h4>
        </div>
        <div class="card-body">
          <div>
            <div>
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
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ Session::get('status') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>                  
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
                        <th class="text-center">Nome</th>
                        <th class="text-center">E-mail</th>
                        <th class="text-center">Gênero</th>
                        <th class="text-center">Telefone</th>
                        <th class="text-center">Dupla?</th>
                        <th class="text-center">Ações</th>
                      </tr>
                    </thead>
                    <tbody>

                      @forelse($students as $student)
                        @if($student->user->type == "student")
                          <tr class="object align-middle" name="{{$student->name}}">
                            <td class="text-center align-middle">{{$student->name}}</td>
                            <td class="text-center align-middle">{{$student->user->email}}</td>
                            <td class="text-center align-middle">{{$student->gender}}</td>
                            <td class="text-center align-middle">{{$student->phone}}</td>
                            <td class="text-center align-middle">
                              @if($student->doubleS == "SIM")
                              <span class="fas fa-check-circle fa-lg text-success"></span>
                              @else
                              <span class="fas fa-times-circle fa-lg text-danger"></span>
                              @endif
                            </td>

                            <td class="text-center align-middle">
                              <button type="button" class="btn btn-outline-warning" role="button" data-toggle="modal" data-target="#editModalStudent" onclick="editStudent('{{$student->id}}','{{$student->name}}','{{$student->user->email}}','{{$student->gender}}','{{$student->phone}}')" title="Editar Aluno">
                                <i class="fas fa-edit"></i>
                              </button>
                              <button type="button" class="btn btn-outline-danger" role="button" data-toggle="modal" data-target="#deleteModalStudent" onclick="deleteStudent('{{$student->id}}','{{$student->name}}')" title="Excluir Aluno">
                                <i class="fa fa-trash"></i>
                              </button>
                            </td>
                          </tr>
                        @endif
                      @empty
                      <td class="text-center">Nenhum Aluno registrado!</td>
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
  <div class="modal fade" id="newModalStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Novo Aluno</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form action="{{URL::to('Admin/Aluno/Cadastrar')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-4">
                <small class="pull-right" style="color:red">* Campos Obrigatórios</small>
              </div>
            </div>
            <br>
            <div class="form-group">
              <label for="">Nome *</label>
              <input type="text" name="name" class="form-control" maxlength="80" value="" required>
            </div>
            <div class="form-group">
              <label for="">E-mail *</label>
              <input type="text" name="email" class="form-control" maxlength="80" value="" required>
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
              <input type="password" name="password" class="form-control" required>
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
  <div class="modal fade" id="editModalStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Editar Aluno</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <form action="{{URL::to('Admin/Aluno/Editar')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-8">
              </div>
            </div>
            <input type="hidden" name="id" id="studentId">
            <div class="form-group">
              <label for="">Nome</label>
              <input type="text" name="name" class="form-control" maxlength="80" value="" id="studentName" required>
            </div>

            <div class="form-group">
              <label for="">E-mail</label>
              <input type="text" name="email" class="form-control" maxlength="80" value="" id="studentEmail" required>
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
  <div class="modal fade" id="deleteModalStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form action="{{URL::to('Admin/Aluno/Excluir')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="deleteIdStudent" value="">
            <div class="text-center">
              <i class="fa fa-exclamation-circle fa-x6" aria-hidden="true"></i>
            </div>
            <h3 class="text-center"><strong style="color:red;">Atenção!</strong></h3>
            <p class="text-center">Caso deseje excluir o "ALUNO" clique no botão confirmar</p>
            <h4 class="text-center"><strong id="deleteNameStudent"></strong></h4>
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
