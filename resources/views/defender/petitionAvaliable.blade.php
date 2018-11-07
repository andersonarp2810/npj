@extends('layouts.defender')
@section('component')
<div class="container">
  <div class="row justify-content-center mt-3">
    <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#comments" aria-expanded="false" aria-controls="collapseExample">
      Ver comentários
      <span class="fas fa-comments ml-2"></span>
    </button>
  </div>
  <div class="row justify-content-center mt-3">
    <div class="col-lg-10">
    <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
    <form action="{{URL::to('Defensor/Comentario/Cadastrar')}}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input type="hidden" name="idPetition" value="{{$petition->id}}">
      <div class="row">
        <label for="">Template:</label>
        <input class="form-control" type="text" name="template_id" value="{{$template->title}}" disabled/>
      </div>
      <br>

      <div class="row">
        <label for="">Descrição:</label>
        <input class="form-control" type="text" name="description" value="{{$petition->description}}" disabled/>
      </div>
      <br>

      <div class="row">
        <label for="">Conteúdo:</label>
        <textarea  class="ckeditor" maxlength="99999" name="content" disabled>{{$petition->content}}</textarea>
      </div>
      <br>

      <label for="">Documentação:</label>
      <div class="row align-items-center">
        @foreach($photos as $photo)
          @if($photo->photo != "" && $photo->photo != null)
          <div class="col-3 mb-3">
              @if(explode('/', File::mimeType('storage/'.$photo->photo))[0] == 'image')
              <img id="myImg" src="{{URL::asset('storage/'.$photo->photo)}}" class="img-fluid img-thumbnail" style="width:200px; height:200px;" onclick="showImage(this)">
              @else
              <a target="_blank" href="{{URL::asset('storage/'.$photo->photo)}}">Abrir {{explode('/', $photo->photo)[2]}} em nova guia</a>
              @endif
          </div>
          @endif
        @endforeach
      </div>

      <br>
      <div class="row">
        <label>Comentários</label>
        <textarea  cols="130" rows="10" maxlength="99999" name="comment" id ="comment" placeholder="Preencha caso necessite de correção!" ></textarea>
      </div>

      <div class="row justify-content-center mt-3">
        <div class="text-center">
          <button type="button" class="btn btn-secondary" onClick="location.href='{{URL::to('Defensor/Peticoes')}}'">
            Cancelar
            <span class="fas fa-times ml-2"></span>
          </button>
          <button type="submit" name="botao" class="btn btn-danger"  id="btnReprovar" value="REPROVAR">
            Reprovar
            <span class="fas fa-thumbs-down ml-2"></span>
          </button>
          <button type="submit" name="botao" class="btn btn-success" value="APROVAR">
            Aprovar
            <span class="fas fa-thumbs-up ml-2"></span>
          </button>
        </div>
      </div>
    </form>
  </div>

</div>
</div>

<div class="modal fade" id="comments" tabindex="-1" role="dialog" aria-labelledby="comments" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Comentários</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
          <div class="col-6">
            <div class="text-center">
              <strong>Orientador</strong>
            </div>
            <ul>
              @foreach($profComments as $comment)
              <li>
                {{$comment->human->name}}
                <br>
                <strong>Comentário:</strong>
                <span>{{$comment->content}}</span>
              </li>
              @endforeach
            </ul>
            @if(count($profComments) < 1)
            <p class="text-center">Nenhum Comentário!</p>
            @endif
          </div>

          <div class="col-6">
            <div class="text-center">
              <strong>Defensor</strong>
            </div>
            <ul>
              @foreach($defComments as $comment)
                <li>
                  {{$comment->human->name}}
                  <br>
                  <strong>Comentário:</strong>
                  {{$comment->content}}
                </li>
              @endforeach
            </ul>
            @if(count($defComments) < 1)
            <p class="text-center">Nenhum Comentário!</p>
            @endif
          </div>
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

</div>
@stop
