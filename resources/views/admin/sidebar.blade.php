<div id="mySidenav" class="sidenav d-none d-lg-block gradient">
  <div class="sidenav-header">    
      <img src="{{URL::asset('assets/img/fap.png')}}" alt="" height="50px">
      <!-- <img src="" alt="logo" style="height: 50"/> -->    
  </div>

  <a href="{{URL::to('Admin/Alunos')}}">
    <span class="fas fa-utensils mr-2"></span>
    Alunos
  </a>

  <a href="{{URL::to('Admin/Duplas')}}">
    <span class="fas fa-utensils mr-2"></span>
    Duplas
  </a>

  <a href="{{URL::to('Admin/Professores')}}">
    <span class="fas fa-list mr-2"></span>
    Professores
  </a>

  <a href="{{URL::to('Admin/Grupos')}}">
    <span class="fas fa-table mr-2"></span>
    Grupos
  </a>

  <a href="{{URL::to('Admin/Defensores')}}">
    <span class="fas fa-list mr-2"></span>
    Defensores
  </a>
  
  <div class="sidenav-footer">
    <a href="{{URL::to('Admin/Preferencias')}}">
      <span class="fas fa-cog fa-lg mr-2"></span>
      Preferências
    </a>
  </div>
</div>