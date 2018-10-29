<div id="mySidenav" class="sidenav d-none d-lg-block gradient">
  <div class="sidenav-header text-center" >   
    <a style="padding: 0;" class="mt-3" href="{{URL::to($url .'/')}}"> 
      <img src="{{URL::asset('assets/img/logo-NPJ-white.png')}}" alt="" height="60px">
   </a>
  </div>

  

  @foreach ($items as $i)
    <a href="{{ $i['itemUrl'] }}">
      <span class="<?php echo('fas fa-'.$i['icon'].' mr-2') ?>"></span>
      {{ $i['item'] }}
    </a>
  @endforeach
  
  <div class="sidenav-footer">
    <a href="{{URL::to($url .'/Preferencias')}}">
      <span class="fas fa-cog fa-lg mr-2"></span>
      Preferências
    </a>
  </div>
</div>