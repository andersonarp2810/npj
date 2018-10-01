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
  <!--<link href="{{URL::asset('assets/css/contents.css')}}" rel="stylesheet">-->
  <link href="{{URL::asset('css/estilo.css')}}" rel="stylesheet">
  <link href="{{URL::asset('css/fontawesome.css')}}" rel="stylesheet">

  <!-- Favicons -->
  <link rel="apple-touch-icon" href="{{URL::asset('assets/img/apple-touch-icon.png')}}">
  <link rel="icon" href="{{URL::asset('assets/img/favicon.png')}}">
</head>

<body>

  <!-- Preloader -->
  <div class="preloader">
    <div class="spinner-dots">
      <span class="dot3"></span>
    </div>
  </div>


  <!-- Sidebar -->
  <div class="sidenav" style="width:15%;height:110%">
    <header class="sidebar-header" style="background:white;border: 6px groove #ddd !important;">
      <span class="logo">
        <a href="{{URL::to('Defensor')}}"><h6 style="font-family:verdana;color:red">NPJ-Sistema</h6></a>
      </span>
    </header>

    <nav class="sidebar-navigation">
      <ul class="menu">

      <hr>
        <li class="menu-item">
          <a href="{{URL::to('Defensor')}}">
            <i class="fa fa-home"></i>&nbsp;<span class="title" style="font-size:20px">HOME</span>
          </a>
        </li>
      </hr>
      <hr>
        <li class="menu-item">
            <span class="title" style="font-size:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        </li>
      </hr>
      <hr>
      <li class="menu-item">
        <a class="menu-link"  href="{{URL::to('Defensor/Peticoes')}}">
          <span class="title" style="font-size:20px">PETIÇÕES</span>
        </a>
      </li>
      </hr>
      <hr>
        <li class="menu-item">
            <span class="title" style="font-size:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        </li>
      </hr>
      <br><br><br><br><br><br><br>
      <hr>
      <li class="menu-item">
        <a href="{{URL::to('Defensor/Preferencias')}}">
          <span class="title" style="font-size:12px"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;PREFERÊNCIAS</span>
        </a>
      </li>
      </hr>
      </ul>
    </nav>


  </div>
  <!-- END Sidebar -->


  <!-- Topbar -->
  <header class="topbar" style="margin-left:20%">
    <div class="topbar-left">
      <p>Olá, {{Auth::user()->email}} - Bem-vindo de volta</p>
    </div>

    <div class="topbar-right">
      <ul class="topbar-btns">

        <!-- Notifications -->
        <li class="dropdown d-none d-md-block">
          <button type="button" name="button" class="btn btn-outline-danger" onClick="location.href='{{URL::to('Sair')}}'">SAIR</button>
        </li>
        <!-- END Notifications -->

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
  <script src="{{ asset('assets/js/ckeditor.js')}}"></script>
  <script src="{{ asset('assets/js/dropzone.js')}}"></script>
  <script src="{{ asset('assets/js/jquery.mask.min.js')}}"></script>
  <script src="{{ asset('assets/js/jquery.maskmoney.min.js')}}"></script>
  <!-- Scripts Page -->
  <script type="text/javascript">

        var comment = document.getElementById("comment");
        var btnReprovar = document.getElementById("btnReprovar");

        var onBriefingInput = function (event) {
          btnReprovar.disabled = !event.target.value;
        }

        comment.addEventListener("input", onBriefingInput);
        comment.dispatchEvent(new Event('input'));



        function deleteStudent(id,nome) {
          document.getElementById('deleteIdStudent').value = id;
          document.getElementById('deleteNomeStudent').innerHTML = nome;
        }

        function editStudent(id,name,email,gender,age,phone,password){
          $('#studentId').val(id);
          $('#studentName').val(name);
          $('#studentEmail').val(email);
          $('#studentGender').val(gender);
          $('#studentAge').val(age);
          $('#studentPhone').val(phone);
          $('#studentPassword').val(password);
        }


        function deleteTeacher(id,nome) {
          document.getElementById('deleteIdTeacher').value = id;
          <!--document.getElementById('deleteNomeTeacher').innerHTML = nome;-->
        }

        function editTeacher(id,name,email,gender,age,phone,password){
          $('#teacherId').val(id);
          $('#teacherName').val(name);
          $('#teacherEmail').val(email);
          $('#teacherGender').val(gender);
          $('#teacherAge').val(age);
          $('#teacherPhone').val(phone);
          $('#teacherPassword').val(password);
        }

        function deleteDefender(id,nome) {
          document.getElementById('deleteIdDefender').value = id;
          document.getElementById('deleteNomeDefender').innerHTML = nome;
        }

        function editDefender(id,name,email,gender,age,phone,password){
          $('#defenderId').val(id);
          $('#defenderName').val(name);
          $('#defenderEmail').val(email);
          $('#defenderGender').val(gender);
          $('#defenderAge').val(age);
          $('#defenderPhone').val(phone);
          $('#defenderPassword').val(password);
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

        function editModaldoubleStudent(id,student_id,student2_id,group_id){
          $('#doubleStudentId').val(id);
          $('#doubleStudentStudent_id').val(student_id);
          $('#doubleStudentStudent2_id').val(student2_id);
          $('#doubleStudentGroup_id').val(group_id);
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

        function uploadFile(){
          $('#imgInp').click();
        }

        function readURL(input) {

          if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
              $('#image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
          }
        }

        $("#imgInp").change(function() {
          $("#divForUpload").hide();
          $("#divImage").show();
          readURL(this);
        });

      </script>
</body>
</html>
