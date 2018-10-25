
  @extends('layouts.base')
  
  @section('content')

  <!-- Sidebar -->
  @sidebar([
  'url' => "Defensor",
    'items' => [
        [
            'item' => 'Petições', 'itemUrl' => '/Defensor/Peticoes', 'icon' => 'file-alt'
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
