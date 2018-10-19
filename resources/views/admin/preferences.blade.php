@extends('layouts.admin')
@section('component')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card my-5">
            <div class="card-header">
              <h4>Preferências</h4>
            </div>
            <div class="card-body">
              <form action="{{URL::to('Admin/Preferencias/Editar')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="idUser" value="{{$user->id}}">
                <input type="hidden" name="idHuman" value="{{$human->id}}">
                <div class="form-group">
                  <label for="">Nome *</label>
                  <input type="text" name="name" class="form-control" maxlength="60" value="{{$human->name}}" required>
                </div>
                <div class="form-group">
                  <label for="">E-mail *</label>
                  <input type="text" name="email" class="form-control" maxlength="60" value="{{$user->email}}" required>
                </div>
                <div class="row">
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label for="">Sexo</label>
                      <select class="form-control" name="gender" required>
                        <option value="{{$human->gender}}" selected>{{$human->gender}}</option>
                        @if($human->gender == 'Masculino')
                        <option value="Feminino">Feminino</option>
                        @else@if($human->gender == 'Feminino')
                        <option value="Masculino">Masculino</option>
                        @endif
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-9">
                    <div class="form-group">
                      <label for="">Telefone</label>
                      <input type="tel" name="phone" class="form-control input-phone" value="{{$human->phone}}">
                    </div>
                  </div>
                  
                </div>
                <div class="form-group">
                  <label for="">Senha *</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <hr>
                <div class="row justify-content-center">
                    <button type="submit" name="botao" class="btn btn-primary">SALVAR</button>
                </div>
              </form>
            </div>
      </div>
    </div>
  </div>
</div>
@endsection
