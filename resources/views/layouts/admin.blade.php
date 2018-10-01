<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
  <meta name="keywords" content="blank, starter">



  <title>NPJ &mdash; Bem-vindo</title>

  <!-- Styles -->
  <link href="{{URL::asset('assets/css/core.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('assets/css/app.css')}}" rel="stylesheet">
  <link href="{{URL::asset('assets/css/style.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('assets/css/fonts.css')}}" rel="stylesheet">
  <link href="{{URL::asset('assets/css/bootstrap.css')}}" rel="stylesheet">
  <link href="{{URL::asset('css/estilo.css')}}" rel="stylesheet">
  <link href="{{URL::asset('css/fontawesome.css')}}" rel="stylesheet">

  <!-- Favicons -->
  <link rel="apple-touch-icon" href="{{URL::asset('assets/img/apple-touch-icon.png')}}">
  <link rel="icon" href="{{URL::asset('assets/img/favicon.png')}}">
</head>

<body>

  <!-- Sidebar -->
  <div class="sidenav" style="width:15%;height:110%">
    <header class="sidebar-header">
      <span class="logo">
        <a href="{{URL::to('Admin')}}"><h6 class="text-center" style="color:red">NPJ-SISTEMA</h6></a>
      </span>
    </header>

    <nav class="sidebar-navigation">
      <ul class="menu">
        <hr>
          <li class="menu-item active">
            <a href="{{URL::to('Admin')}}">
              <i class="fa fa-home"></i>&nbsp;<span class="title" style="font-size:20px">HOME</span>
            </a>
          </li>
        </hr>

        <hr>
        <li class="menu-item">
          <a href="{{URL::to('Admin/Alunos')}}">
            <span class="title" style="font-size:20px">ALUNOS</span>
          </a>
        </li>
        <li class="menu-item" style="margin-left:5%">
          <a href="{{URL::to('Admin/Duplas')}}">
            <span class="title" style="font-size:15px">DUPLAS</span>
          </a>
        </li>
      </hr>
        <hr>

        <li class="menu-item">
          <a href="{{URL::to('Admin/Professores')}}">
            <span class="title" style="font-size:20px">PROFESSORES</span>
          </a>
        </li>
        <li class="menu-item" style="margin-left:5%">
          <a href="{{URL::to('Admin/Grupos')}}">
            <span class="title" style="font-size:15px">GRUPOS</span>
          </a>
        </li>
      </hr>
      <hr>
        <li class="menu-item">
          <a href="{{URL::to('Admin/Defensores')}}">
            <span class="title" style="font-size:20px">DEFENSORES</span>
          </a>
        </li>
      </hr>
      <hr>
        <li class="menu-item">
          <a href="{{URL::to('Admin/Preferencias')}}">
            <span class="title" style="font-size:12px"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;PREFERÊNCIAS</span>
          </a>
        </li>
      </hr>
      </ul>
    </nav>
  </div>
  <!-- END Sidebar -->


  <!-- Topbar -->
  <header class="topbar" style="margin-left:15%">
    <div class="topbar-left">
      <p>Olá, {{Auth::user()->email}} - Bem-vindo de volta</p>
    </div>

    <div class="topbar-right">
      <ul class="topbar-btns">
        <li class="dropdown d-none d-md-block">
          <button type="button" name="button" class="btn btn-outline-danger" onClick="location.href='{{URL::to('Sair')}}'">SAIR</button>
        </li>
      </ul>

    </div>
  </header>
  <!-- END Topbar -->


  <!-- Main container -->
  <main style="margin-left:15%">
    <div class="main-content">


      @yield('content')


    </div><!--/.main-content -->


    <!-- Footer -->
    <footer class="site-footer" style="margin-top:2%">
      <div class="row">
        <div class="col-md-6">
          <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
            <li class="nav-item">
              <p class="text-center text-md-left">Copyright © 2018 Soares n.g.</a></p>
            </li>
          </ul>
        </div>
      </div>
    </footer>
    <!-- END Footer -->

  </main>
  <!-- END Main container -->


  <!-- Scripts -->
  <script src="{{ asset('assets/js/core.min.js')}}"></script>
  <script src="{{ asset('assets/js/app.min.js')}}"></script>
  <script src="{{ asset('assets/js/script.min.js')}}"></script>
  <script src="{{ asset('assets/js/dropzone.js')}}"></script>
  <script src="{{ asset('assets/js/jquery.mask.min.js')}}"></script>
  <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{ asset('assets/js/jquery.mask.min.js')}}"></script>
  <script src="{{ asset('assets/js/jquery.maskmoney.min.js')}}"></script>
  <!-- Scripts Page -->
  <script type="text/javascript">

        $(".input-number_tel").mask("00");
        $(".input-phone").mask("(00) 9 0000-0000");

        //funcao da PAGINA home
        function verifica(value){
          if(value == 1){
            document.getElementById('option1').style.display = "block";
            document.getElementById('option2').style.display = "none";
            document.getElementById('option3').style.display = "none";
          }else if(value == 2){
            document.getElementById('option1').style.display = "none";
            document.getElementById('option2').style.display = "block";
            document.getElementById('option3').style.display = "none";
          }else if(value == 3){
            document.getElementById('option1').style.display = "none";
            document.getElementById('option2').style.display = "none";
            document.getElementById('option3').style.display = "block";
          }
        }


        //validacao Duplas
        function verify(e){
          var r = $("#r").val();
          console.log(r);
          if(e == r){
            document.getElementById('r').style.display = "none";
          }
        }
        //validacao Duplas
        function verifyEdit(t){
          var r = $("#rr").val();

          if(t == r){
            document.getElementById('rr').style.display = "none";
          }
        }



        function deleteStudent(id,nome) {
          document.getElementById('deleteIdStudent').value = id;
          document.getElementById('deleteNomeStudent').innerHTML = nome;
        }

        function editStudent(id,name,email,gender,phone,password){
          $('#studentId').val(id);
          $('#studentName').val(name);
          $('#studentEmail').val(email);
          $('#studentGender').val(gender);
          $('#studentPhone').val(phone);
          $('#studentPassword').val(password);
        }


        function deletedoubleStudent(id){
          document.getElementById('deleteIdDoubleStudent').value = id;
        }

        function editModaldoubleStudent(id,student1,student2,group){
          $('#doubleStudentId').val(id);
          $('#doubleStudentStudent_id').val(student);
          $('#doubleStudentStudent2_id').val(student2);
          $('#doubleStudentGroup_id').val(group);
        }

        function deleteTeacher(id,nome) {
          document.getElementById('deleteIdTeacher').value = id;
          <!--document.getElementById('deleteNomeTeacher').innerHTML = nome;-->
        }

        function editTeacher(id,name,email,gender,phone,password){
          $('#teacherId').val(id);
          $('#teacherName').val(name);
          $('#teacherEmail').val(email);
          $('#teacherGender').val(gender);
          $('#teacherPhone').val(phone);
          $('#teacherPassword').val(password);
        }

        function deleteDefender(id,nome) {
          document.getElementById('deleteIdDefender').value = id;
          document.getElementById('deleteNomeDefender').innerHTML = nome;
        }

        function editDefender(id,name,email,gender,phone){
          $('#defenderId').val(id);
          $('#defenderName').val(name);
          $('#defenderEmail').val(email);
          $('#defenderGender').val(gender);
          $('#defenderPhone').val(phone);
        }


        function deleteGroup(id,nome) {
          document.getElementById('deleteIdGroup').value = id;
          document.getElementById('deleteNameGroup').innerHTML = nome;
        }

        function editModalGroup(id,name,teacher_id){
          $('#groupName').val(name);
          $('#groupId').val(id);
          $('#groupTeacher_id').val(teacher_id);
        }

        function deletedoubleStudent(id){
          document.getElementById('deleteIdDoubleStudent').value = id;
        }

        //coloca p/ aparecer os nomes
        function editModaldoubleStudent(id,student1,student2,group){
          $('#doubleStudentId').val(id);
          $('#doubleStudent1').val(student1);
          $('#doubleStudent2').val(student2);
          $('#doubleStudentGroup').val(group);
        }


        function filtroDeBusca(nome){
          var objs = document.getElementsByClassName("object");

          $('.object').show();

          if (nome != "") {
            for (var i = 0; i < objs.length; i++) {
              if (objs[i].getAttribute('name').toLowerCase().search(nome.toLowerCase())) {
                objs[i].style.display = "none";
              }
            }
          }

        }

      </script>
</body>
</html>
