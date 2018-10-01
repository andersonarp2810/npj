@extends('layouts.admin')
@section('content')
<div class="card" style="margin-left:3%;width:60%;margin-left:25%;margin-top:5%">
  <h4 class="card-title">Preferências</h4>
        <div class="card-body">
          <form action="{{URL::to('Admin/Preferencias/Editar')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="idUser" value="{{$user->id}}">
            <input type="hidden" name="idHuman" value="{{$human->id}}">
            <div class="form-group">
              <label for="">Nome *</label>
              <input type="text" name="name" class="form-control" maxlength="80" value="{{$human->name}}" required>
            </div>
            <div class="form-group">
              <label for="">E-mail *</label>
              <input type="text" name="email" class="form-control" maxlength="80" value="{{$user->email}}" required>
            </div>
            <div class="row" style="margin-left:2px">
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
              <div class="form-group">
                <label for="">Telefone</label>
                <input type="tel" name="phone" class="form-control input-phone" value="{{$human->phone}}">
              </div>
            </div>
            <div class="form-group">
              <label for="">Senha *</label>
                <input type="text" name="password" class="form-control">
            </div>
            <div class="row">
              <div class="modal-footer">
                <button type="submit" name="botao" class="btn btn-primary">SALVAR</button>
              </div>
            </div>
          </form>
        </div>
</div>
