@extends('layouts.base')

@section('content')

<!-- Sidebar -->
@sidebar([
    'url' => "Admin",
    'items' => [
        [
            'item' => 'Alunos', 'itemUrl' => '/Admin/Alunos', 'icon' => 'user'
        ], 
        [
            'item' => 'Duplas', 'itemUrl' => '/Admin/Duplas', 'icon' => 'user-friends'
        ],
        [
            'item' => 'Professores', 'itemUrl' => '/Admin/Professores', 'icon' => 'user-graduate'
        ],
        [
            'item' => 'Grupos', 'itemUrl' => '/Admin/Grupos', 'icon' => 'users'
        ],
        [
            'item' => 'Defensores', 'itemUrl' => '/Admin/Defensores', 'icon' => 'user-tie'
        ],
    ]
])
@endsidebar

<!-- END Sidebar -->


<div id="main">
<!-- Topbar -->
@component('components.topbar')  
  {{Auth::user()->email}}  
@endcomponent


<!-- END Topbar -->

<!-- Main container -->
<main>
  <div>
    @yield('component')
  </div>
</main>
  <!-- Footer -->
  <footer class="mt-3">    
    <nav class="navbar bottom navbar-light bg-light">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          Copyright © 2018 NexTI.
        </li>
      </ul>
    </nav>
  </footer>
  <!-- END Footer -->
  @component('components.bottombar')  
    {{Auth::user()->email}}  
  @endcomponent

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
        function verify(select, mudado){
          //select == opção selecionada e mudado == se for na select da esquerda ou da direita
          if(mudado == 1){
            var options = $(".segundos");
          } else if(mudado == 2){
            var options = $(".primeiros");
          }
          console.log(select);
          console.log(options);
          for (let index = 0; index < options.length; index++) {
            console.log(options[index].value + " - " + select);
            options[index].style.display = "block";
            if(options[index].value == select){
              options[index].style.display = "none";
            }
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


        function filtroDeBusca(nome, filtro){
          //filtro => 0 = nome, 1 = tipo de usuário, 2 = rota, 3 = data
          var objs = document.getElementsByClassName("object");

          $('.object').show();

          if (nome != "") {
            for (var i = 0; i < objs.length; i++) {
              if (objs[i].getAttribute('name').toLowerCase().split("/")[filtro].search(nome.toLowerCase())) {
                objs[i].style.display = "none";
              }
            }
          }

        }

      </script>
@endsection
