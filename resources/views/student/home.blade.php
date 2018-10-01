@extends('layouts.student')
@section('content')
<div style="width:110%">
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
        <div class="card text-black bg-dark mb-3">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <i class="fa fa-bookmark fa-5x" aria-hidden="true" style="margin-top:10px;"></i>
              </div>
              <div class="col-md-6">
                <h6>ALUNO</h6>
                  <h1 class="display-4" style="color:white">{{$petitions->where('student_ok','false')->count()}}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-3 col-lg-3">
        <div class="card bg-success text-white">
          <div class="card-body bg-primary">
            <div class="row">
              <div class="col-md-6">
                <i class="fa fa-th fa-5x" style="margin-top:10px;"></i>
              </div>
              <div class="col-md-6">
                <h6>PROFESSOR</h6>
                  <h1 class="display-4">{{$petitions->where('student_ok','true')->where('teacher_ok','!=','true')->count()}}</h1>
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
                  <h1 class="display-4">{{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('defender_ok','!=','true')->count()}}
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
                <h6>PROFESSOR-RECUSADAS</h6>
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
@endsection
