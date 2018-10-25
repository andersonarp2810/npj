@extends('layouts.student')
@section('component')
  <div class="container">
    <div class="row justify-content-center my-3">
      <div class="text-center">
      <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#comments" aria-expanded="false" aria-controls="collapseExample">
          Ver comentários
        </button>
      </div>
    </div>

    <!-- pra mostrar quando a petição é salva -->
    <div class="row">
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    @if(Session::has('status'))
      <p class="alert alert-info" style="width:20%;">{{ Session::get('status') }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endif
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-10">
      <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
      <form action="{{URL::to('Aluno/Peticao/Editar')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$petition->id}}">
        <div class="row">
          <label for="">Template</label>
          <select class="form-control" name="template_id" disabled>
            <option value="{{$templates->find($petition->template_id)->id}}">{{$templates->find($petition->template_id)->title}}</option>
          </select>
        </div>
        <br>
        <div class="row">
          <label for="">Descrição</label>
          <input class="form-control" name="description" value="{{$petition->description}}" />
        </div><br>
        <div class="row">
          <label>Conteúdo:</label><br>
          <textarea  class="ckeditor" maxlength="99999" name="content" required>{{$petition->content}}</textarea>
        </div>
        <br>
        
        <label class="row">Documentação:</label>
        <div class="row">
            <br>
            @foreach($photos as $photo)
              @if($photo->photo != "" || $photo->photo != null)
              <div class="col-3 mb-3">
                <div class="text-center">
                  <img id="myImg" src="{{URL::asset('storage/'.$photo->photo)}}" class="img-fluid img-thumbnail" style="width:200px; height:200px;" onclick="showImage(this)">
                  <br>                
                  <button type="button" class="btn btn-sm btn-danger" onClick="location.href='{{URL::to('Aluno/Peticao/Edit/' . $petition->id . '/DeletePhoto/' . $photo->id )}}'">
                    <span class="fas fa-trash"></span>
                  </button>                
                </div>
              </div>
              @endif
            @endforeach
        </div>
        <br>
        
        <div class="row">          
          <input type="file" name="images[]" multiple>          
        </div>

        <br>
        <div class="row justify-content-center">
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" onClick="location.href='{{URL::to('Aluno/Peticoes')}}'">Cancelar</button>
            <button type="submit" name="botao" class="btn btn-primary" value="SALVAR">Salvar</button>
            <button type="submit" name="botao" class="btn btn-success" value="ENVIAR">Enviar</button>
          </div>
        </div>
      </form>
    </div>


  <div class="modal fade" id="comments" tabindex="-1" role="dialog" aria-labelledby="comments" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Comentários</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <ul>
              @forelse($comments as $comment)
              @if($comment->human->user->type == 'teacher')
              <li>
                <strong>
                  Orientador:
                </strong>
                {{$comment->human->name}}
                <br>
                <strong>Comentário:</strong>
                <span>{{$comment->content}}</span>
              </li>
              @endif

              @if($comment->human->user->type == 'defender')
              <li>
                <strong>
                  Defensor:
                </strong>
                {{$comment->human->name}}
                <br>
                <strong>Comentário:</strong>
                {{$comment->content}}
              </li>
              @endif
            </ul>
            @empty
            <h3 class="text-center">Nenhum Comentário!</h3>
            @endforelse
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>

  </div>
  
  <div id="myModal" class="img-modal">
      <span id="close" class="img-close">&times;</span>
      <img class="img-modal-content" id="img-view">
    </div>

    <script>
      // Get the modal
      var modal = document.getElementById('myModal');

      // Get the image and insert it inside the modal - use its "alt" text as a caption
      function showImage(el) {  
        console.log(el);
        modal.style.display = "block";
        var modalImg = document.getElementById("img-view");
        modalImg.src = el.src;
      }

      // Get the <span> element that closes the modal
      var span = document.getElementsByClassName("close")[0];

      // When the user clicks on <span> (x), close the modal
      document.getElementById("close").onclick = function () {
        modal.style.display = "none";
      }
    </script>
@endsection
