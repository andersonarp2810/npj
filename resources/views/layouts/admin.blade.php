@extends('layouts.base')

@section('content')
<!-- Sidebar -->
@include('admin.sidebar')
<!-- END Sidebar -->


<!-- Topbar -->
<div id="main">
<header>  

  <nav class="navbar navbar-light bg-light">
    <span class="navbar-text">
    Olá, {{Auth::user()->email}} - Bem-vindo de volta
    </span>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <button type="button" name="button" class="btn btn-outline-danger" onClick="location.href='{{URL::to('Sair')}}'">SAIR</button>
      </li>
    </ul>
  </nav>
  
</header>
<!-- END Topbar -->


<!-- Main container -->
<main>
  <div>
    @yield('component')
  </div>
</main>
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

<!-- END Main container -->
</div>
  
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
@endsection
