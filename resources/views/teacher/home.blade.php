@extends('layouts.teacher')
@section('content')
<div style="width:100%">
  <div class="row" style="margin-left:1%;width:100%">
    <div class="col-md-6">
      <div class="input-group" style="width:50%;margin-left:110%">
        <div class="input-group-prepend">
          <a class="btn btn-outline-secondary" style="pointer-events: none;cursor: default;text-decoration: none;color: black;"><i class="fa fa-filter fa-1x"></i></a>
        </div>
        <select class="custom-select" id="valueHome" style="cursor:pointer" onchange="verifica(this.value)">
          <option value="1" selected><p>ESTÁGIOS DAS PETIÇÕES</p></option>
          <option value="2"><p>RANKING DE DUPLAS</p></option>
        </select>
      </div>
    </div>
  </div>
  <div id="option1" style="display:block">
    <ul class="nav nav-primary">
      <li class="nav-item">
        <h1 class="text-center" style="font-family:arial;font-weight:800;margin-left:140%">PETIÇÕES</h1>
      </li>
    </ul>
    <br><br>
    <ul>
      <li class="nav-item">
        <h4 class="text-center text-md-left" style="font-size:22px">stages:</h4>
      </li>
    </ul>
    <div class="row" style="margin-top:1.5%;margin-left:2%;width:110%">
      <div class="col-sm-12 col-md-3 col-lg-3">
        <div class="card bg-info text-white">
          <div class="card-body bg-primary">
            <div class="row">
              <div class="col-md-6">
                <i class="fa fa-th fa-5x" aria-hidden="true" style="margin-top:10px;"></i>
              </div>
              <div class="col-md-6">
                <h6>ALUNO</h6>
                <h1 class="display-4">{{$petitions->where('student_ok','false')->count()}}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-3 col-lg-3">
        <div class="card text-black bg-dark mb-3">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <i class="fa fa-bookmark fa-5x" aria-hidden="true" style="margin-top:10px;"></i>
              </div>
              <div class="col-md-6">
                <h6>PROFESSOR</h6>
                <h1 class="display-4" style="color:white">{{$petitions->where('student_ok','true')->where('teacher_ok','!=','true')->count()}}</h1>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-3 col-lg-3">
          <div class="card bg-info text-white">
            <div class="card-body bg-primary">
              <div class="row">
                <div class="col-md-6">
                  <i class="fa fa-th fa-5x" aria-hidden="true" style="margin-top:10px;"></i>
                </div>
                <div class="col-md-6">
                  <h6>DEFENSOR</h6>
                  <h1 class="display-4">{{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('defender_ok','!=','true')->count()}}</h1>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <div class="row" style="margin-left:15%;width:110%">
      <div class="col-sm-12 col-md-3 col-lg-3">
        <div class="card bg-success text-white">
          <div class="card-body bg-warning">
            <div class="row">
              <div class="col-md-6">
                <i class="fa fa-th fa-5x" aria-hidden="true" style="margin-top:10px;"></i>
              </div>
              <div class="col-md-6">
                <h7>PROFESSOR-RECUSADAS</h7>
                <h1 class="display-4">{{$petitions->where('teacher_ok','false')->count()}}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-3 col-lg-3">
        <div class="card bg-success text-white">
          <div class="card-body bg-danger">
            <div class="row">
              <div class="col-md-6">
                <i class="fa fa-th fa-5x" aria-hidden="true" style="margin-top:10px;"></i>
              </div>
              <div class="col-md-6">
                <h6>DEFENSOR-RECUSADAS</h6>
                <h1 class="display-4">{{$petitions->where('defender_ok','false')->count()}}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row" style="margin-left:26%;width:110%">
      <div class="col-sm-12 col-md-3 col-lg-3">
        <div class="card bg-success text-white">
          <div class="card-body bg-success">
            <div class="row">
              <div class="col-md-6">
                <i class="fa fa-th fa-5x" aria-hidden="true" style="margin-top:10px;"></i>
              </div>
              <div class="col-md-6">
                <h7>FINALIZADAS</h7>
                <h1 class="display-4">{{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('defender_ok','true')->count()}}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="option2" style="display:none;width:100%;margin-left:2%"><!--ranking de Duplas-->
    <ul class="nav nav-primary">
      <li class="nav-item">
        <h1 class="text-center" style="font-family:arial;font-weight:800;padding-left:40%">RANKING DE DUPLAS</h1>
      </li>
    </ul>
    <br><br>
    <table class="table table-condensed table-striped table-bordered">
      <thead class="table">
        <tr>
          <th style="font-size:18pt;width:20%" class="text-center">COLOCAÇÃO</th>
          <th style="font-size:18pt" class="text-center">ALUNO1</th>
          <th style="font-size:18pt" class="text-center">ALUNO2</th>
          <th style="font-size:18pt" class="text-center">N° DE PETIÇÕES</th>
          <th style="font-size:18pt" class="text-center">GRUPO</th>
        </tr>
      </thead>
      <tbody>
        <br>
        @forelse($doubleStudents as $doubleStudent)
            <tr>
              <td class="text-center">{{$count++}}</td>
              <td class="text-center">{{$humans->where('id',$doubleStudent->student_id)->first()->name}}</td>
              <td class="text-center">{{$humans->where('id',$doubleStudent->student2_id)->first()->name}}</td>
              <td class="text-center">{{$doubleStudent->qtdPetitions}}</td>
              <td class="text-center">{{$group->name}}</td>
            </tr>
        @empty
            <td>Não há duplas cadastradas</td>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
