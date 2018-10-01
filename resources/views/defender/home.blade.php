@extends('layouts.defender')
@section('content')
<div style="width:120%">
  <div class="row" style="margin-left:1%">
    <div class="col-md-6">
      <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
        <li class="nav-item">
          <h1 class="text-center text-md-left" style="font-family:arial;font-weight:800"><u>PETIÇÕES</u></h1>
        </li>
      </ul>
      <br><br>
      <ul>
        <li class="nav-item">
          <h4 class="text-center text-md-left" style="font-size:22px">stages:</h4>
        </li>
      </ul>
    </div>
  </div>

  <div class="row" style="margin-top:0.5%;margin-left:5%">
    <div class="col-sm-12 col-md-3 col-lg-3">
      <div class="card bg-success text-white">
        <div class="card-body bg-primary">
          <div class="row">
            <div class="col-md-6">
              <i class="fa fa-th fa-5x" aria-hidden="true" style="margin-top:10px;"></i>
            </div>
            <div class="col-md-6">
              <h6 style="font-size:10pt">ALUNO</h6>
              <h1 class="display-4" >{{$petitions->where('defender_id',$defender->id)->where('student_ok','!=','true')->count()}}</h1>
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
              <h6 style="font-size:10pt">DEFENSOR</h6>
              <h1 class="display-4" style="color:white">{{$petitions->where('defender_id',$defender->id)->where('defender_ok','!=','true')->where('teacher_ok','true')->where('student_ok','true')->count()}}</h1>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-12 col-md-3 col-lg-3">
      <div class="card bg-success text-white">
        <div class="card-body bg-warning">
          <div class="row">
            <div class="col-md-6">
              <i class="fa fa-th fa-5x" aria-hidden="true" style="margin-top:10px;"></i>
            </div>
            <div class="col-md-6">
              <h6>DISPONÍVEIS</h6>
              <h1 class="display-4" >{{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('defender_ok','=','')->where('defender_id','=','')->count()}}</h1>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div><!--final row-->

  <div class="row" style="margin-left:5%">
    <div class="col-sm-12 col-md-3 col-lg-3">
      <div class="card bg-success text-white">
        <div class="card-body bg-danger">
          <div class="row">
            <div class="col-md-6">
              <i class="fa fa-th fa-5x" aria-hidden="true" style="margin-top:10px;"></i>
            </div>
            <div class="col-md-6">
              <h6 style="font-size:10pt">RECUSADAS</h6>
              <h1 class="display-4">{{$petitions->where('defender_id',$defender->id)->where('defender_ok','false')->count()}}</h1>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-12 col-md-3 col-lg-3">
      <div class="card bg-success text-white">
        <div class="card-body bg-success">
          <div class="row">
            <div class="col-md-6">
              <i class="fa fa-th fa-5x" aria-hidden="true" style="margin-top:10px;"></i>
            </div>
            <div class="col-md-6">
              <h6 style="font-size:9pt">FINALIZADAS</h6>
                <h1 class="display-4">{{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('defender_ok','true')->where('defender_id',$defender->id)->count()}}</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
