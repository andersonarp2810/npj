<section class="d-lg-none d-block">
  <nav class="navbar navbar-expand fixed-bottom navbar-light bg-light">
    <span class="navbar-text text-dark d-none d-lg-block">
      Olá, <strong>{{$slot}}</strong> - Bem-vindo de volta
    </span>
    <ul class="navbar-nav mx-auto">

      <li class="nav-item ">
        <a href="{{URL::to('Admin/Alunos')}}" class="nav-link text-center">
          <span class="fas fa-user fa-lg"></span>
          <small>Alunos</small>
        </a>
      </li>
      <li class="nav-item ">
        <a href="{{URL::to('Admin/Duplas')}}" class="nav-link text-center">
          <span class="fas fa-user-friends fa-lg"></span>
          <small>Duplas</small>
        </a>
      </li>
      <li class="nav-item ">
        <a href="{{URL::to('Admin/Professores')}}" class="nav-link text-center">
          <span class="fas fa-user-graduate fa-lg"></span>
          <small>Professores</small>
        </a>
      </li>
      <li class="nav-item ">
        <a href="{{URL::to('Admin/Grupos')}}" class="nav-link">
          <span class="fas fa-users fa-lg"></span>
          <small>Grupos</small>
        </a>
      </li>
      <li class="nav-item ">
        <a href="{{URL::to('Admin/Defensores')}}" class="nav-link text-center">
          <span class="fas fa-user-tie fa-lg"></span>
          <small>Defensores</small>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a href="{{URL::to('Sair')}}" class="text-danger" onClick="location.href='{{URL::to('Sair')}}'">          
          <span class="fas fa-sign-out-alt fa-lg"></span>
          <small>Sair</small>
        </a>
      </li>
    </ul>
  </nav>

</section>