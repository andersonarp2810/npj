@extends('layouts.defender')
@section('component')
<div class="container-fluid">
  <div id="option1" style="display:block">
    <div class="text-center">
      <h1 class="h1 h1-responsive text-center">Status das Petições</h1>
    </div>
    <br>

    <div class="row justify-content-center mt-5">
      <div class="col-lg-4 col-md-4 col-12 mb-3">
        <div class="card">
          <div class="card-header bg-primary text-white">
            ALUNO
            <span class="fas fa-user fa-lg float-right my-1"></span>
          </div>
          <div class="card-body text-center text-primary">
            <h1 class="h1 h1-responsive">
              {{$petitions->where('defender_id',$defender->id)->where('student_ok','!=','true')->count()}}
            </h1>
          </div>
          <div class="card-footer bg-primary">
            <a href="" class="text-white">
              Detalhes
              <span class="fas fa-arrow-right mr-1"></span>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-12  ">
        <div class="card text-white">
          <div class="card-header bg-primary text-white">
            DEFENSOR
            <span class="fas fa-user-tie fa-lg float-right my-1"></span>
          </div>
          <div class="card-body text-center text-primary">
            <h1 class="h1 h1-responsive">
              {{$petitions->where('defender_id',$defender->id)->where('defender_ok','!=','true')->where('teacher_ok','true')->where('student_ok','true')->count()}}
            </h1>
          </div>
          <div class="card-footer bg-primary">
            <a href="" class="text-white">
              Detalhes
              <span class="fas fa-arrow-right mr-1"></span>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-12  ">
        <div class="card text-white">
          <div class="card-header bg-primary text-white">
            DISPONÍVEIS
            <span class="fas fa-user-tie fa-lg float-right my-1"></span>
          </div>
          <div class="card-body text-center text-primary">
            <h1 class="h1 h1-responsive">
              {{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('defender_ok','=','')->where('defender_id','=','')->count()}}
            </h1>
          </div>
          <div class="card-footer bg-primary">
            <a href="" class="text-white">
              Detalhes
              <span class="fas fa-arrow-right mr-1"></span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center mt-3">
      <div class="col-lg-4 col-md-6 mb-3">
        <div class="card text-white">
          <div class="card-header bg-danger text-white">
            RECUSADAS
            <span class="fas fa-user-graduate fa-lg float-right my-1"></span>
          </div>
          <div class="card-body text-center text-danger">
            <h1 class="h1 h1-responsive">
              {{$petitions->where('defender_id',$defender->id)->where('defender_ok','false')->count()}}
            </h1>
          </div>
          <div class="card-footer bg-danger">
            <a href="" class="text-white">
              Detalhes
              <span class="fas fa-arrow-right mr-1"></span>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 mb-3">
        <div class="card text-white">
          <div class="card-header bg-success text-white">
            FINALIZADAS
            <span class="fas fa-check fa-lg float-right my-1"></span>
          </div>
          <div class="card-body text-center text-success">
            <h1 class="h1 h1-responsive">
              {{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('defender_ok','true')->where('defender_id',$defender->id)->count()}}
            </h1>
          </div>
          <div class="card-footer bg-success">
            <a href="" class="text-white">
              Detalhes
              <span class="fas fa-arrow-right mr-1"></span>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection