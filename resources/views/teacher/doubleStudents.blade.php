@extends('layouts.teacher')
@section('content')
<div class="card" style="margin-left:2%">
  <h4 class="card-title">Visualizar Duplas</h4>

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
                <input type="search" name="" class="form-control" value="" placeholder="Buscar por nome do Estudante 1..." onkeyup="filtroDeBusca(this.value)">
                <span class="input-group-addon">
                  <i class="fa fa-search"></i>
                </span>
              </div>
            </span>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th style="font-size:18pt" class="text-center">ESTUDANTE 1</th>
                  <th style="font-size:18pt" class="text-center">ESTUDANTE 2</th>
                  <th style="font-size:18pt" class="text-center">GRUPO</th>
                  <th style="font-size:18pt" class="text-center">N° PETIÇÕES</th>
                  <!--<th class="text-center">Ações</th>-->
                </tr>
              </thead>
              <tbody>
                @forelse($doubleStudents as $doubleStudent)
                    <tr class="object" name="{{$humans->find($doubleStudent->student_id)->name}}">
                      <td style="font-size:10pt" class="text-center">{{$humans->find($doubleStudent->student_id)->name}}</td>
                      <td style="font-size:10pt" class="text-center">{{$humans->find($doubleStudent->student2_id)->name}}</td>
                      <td style="font-size:10pt" class="text-center">{{$doubleStudent->group->name}}</td>
                      <td style="font-size:10pt" class="text-center">{{$petitions->where('visible','true')->where('doubleStudent_id',$doubleStudent->id)->count()}}</td>
                    </tr>
                @empty
                <td class="text-center">Nenhuma Dupla registrada!</td>
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
