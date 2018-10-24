@extends('layouts.base')

@section('content')

<!-- Sidebar -->
@sidebar([
  'url' => "Aluno",
    'items' => [
        [
            'item' => 'Petições', 'itemUrl' => '/Aluno/Peticoes', 'icon' => 'user'
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
            Copyright © 2018 NExTi.
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
  
  <script type="text/javascript">


        function mudarPeticao(){
          var id = $("#idPetition").val();
          console.log(id);

          $.post("{{URL::to('Aluno/Peticao/MudarPeticao')}}",{ 'id': id, '_token': $('meta[name=csrf-token]').attr('content') },function(response){
            if(response != null){
              location.reload();
            }
          });
        }

        function copiarPeticao(){
          var id = $("#idPetition").val();
          console.log(id);

          $.post("{{URL::to('Aluno/Peticao/CopiarPeticao')}}",{ 'id': id, '_token': $('meta[name=csrf-token]').attr('content') },function(response){
            if(response != null){
              location.reload();
            }
          });
        }


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


        function editPetition(id,description,content,template_id,defender_id,doubleStudent_id){
          $('#petitionId').val(id);
          $('#petitionDescription').val(description);
          $('#petitionContent').val(content);
          $('#petitionTemplate_id').val(template_id);
          $('#petitionDefender_id').val(defender_id);
          $('#petitionDoubleStudent_id').val(doubleStudent_id);
        }


        function deleteTeacher(id,nome) {
          document.getElementById('deleteIdTeacher').value = id;
          document.getElementById('deleteNomeTeacher').innerHTML = nome;
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

        function deletePetition(id,description){
          document.getElementById('deleteIdPetition').value = id;
          document.getElementById('deleteDescriptionPetition').innerHTML = description;
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

        function escolherTemplate(idTemplate){

          $("#step0").hide().fadeOut();
          $("#formCadastro").show().fadeIn();
          $("#btnCadastrar").show();
        }



//

    </script>
</body>
</html>
