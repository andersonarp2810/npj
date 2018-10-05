<section class="d-lg-none d-block">
  <nav class="navbar navbar-expand fixed-bottom navbar-light bg-light">
    <span class="navbar-text text-dark d-none d-lg-block">
      Olá, <strong>{{$slot}}</strong> - Bem-vindo de volta
    </span>
    <ul class="navbar-nav mx-auto">

      <li class="nav-item mr-2">
        <a href="" class="nav-link">
          <span class="fas fa-user fa-lg"></span>
        </a>
      </li>
      <li class="nav-item mr-2">
        <a href="" class="nav-link">
          <span class="fas fa-user-friends fa-lg"></span>
        </a>
      </li>
      <li class="nav-item mr-2">
        <a href="" class="nav-link">
          <span class="fas fa-user-graduate fa-lg"></span>
        </a>
      </li>
      <li class="nav-item mr-2">
        <a href="" class="nav-link">
          <span class="fas fa-users fa-lg"></span>
        </a>
      </li>
      <li class="nav-item mr-2">
        <a href="" class="nav-link">
          <span class="fas fa-user-tie fa-lg"></span>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <button type="button" name="button" class="btn btn-sm btn-outline-danger" onClick="location.href='{{URL::to('Sair')}}'">
          SAIR
          <span class="fas fa-sign-out-alt"></span>
        </button>
      </li>
    </ul>
  </nav>

</section>