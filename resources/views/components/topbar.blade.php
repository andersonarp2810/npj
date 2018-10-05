<header>  

  <nav class="navbar navbar-light bg-light">
    <span class="navbar-text">
    Olá, {{$user}} - Bem-vindo de volta
    </span>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <button type="button" name="button" class="btn btn-outline-danger" onClick="location.href='{{URL::to('Sair')}}'">SAIR</button>
      </li>
    </ul>
  </nav>
  
</header>