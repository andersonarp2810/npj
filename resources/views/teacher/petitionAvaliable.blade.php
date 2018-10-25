@extends('layouts.teacher')
@section('component')

<div class="container">
  <div class="row justify-content-center my-5">
    <div class="col-lg-10 my-5">
        <div class="row justify-content-center">
            <button class="btn btn-outline-primary float-right" type="button" data-toggle="modal" data-target="#comments"
              aria-expanded="false" aria-controls="comments">
              Ver comentários
            </button>
          </div>
      <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
      <form action="{{URL::to('Professor/Comentario/Cadastrar')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="idPetition" value="{{$petition->id}}">
        <div class="row">
          <label for="">TEMPLATE</label>
          <input class="form-control" type="text" name="template_id" value="{{$template->title}}" disabled/>
        </div>
        <br>
        <div class="row">
          <label for="">DESCRIÇÃO</label>
          <input class="form-control" type="text" name="description" value="{{$petition->description}}" disabled/>
        </div>
        <br>
        <div class="row">
          <label for="">CONTEÚDO</label>
          <textarea  class="ckeditor" maxlength="99999" name="content" disabled>{{$petition->content}}</textarea>
        </div>
        <br>
  
        <div class="row">
          <label for="">DOCUMENTAÇÃO:</label>
            @foreach($photos as $photo)
              @if($photo->photo == "" || $photo->photo == null)
                 <img src="{{URL::asset('storage/1')}}" class="img-responsive img-thumbnail" style="width:120px; height:120px; margin:0 auto">
              @else
                  <img src="{{URL::asset('storage/'.$photo->photo)}}" class="img-responsive img-thumbnail" style="max-width:450px; max-height:250px; margin:0 auto">
                  <a href="{{URL::asset('storage/'.$photo->photo)}}" target="_blank">{{URL::asset('storage/'.$photo->photo)}}</a>
              @endif
            @endforeach
        </div>
        <br>
        <textarea  cols="100" rows="10" maxlength="99999" name="comment" id="comment" placeholder="Preencha caso necessite de CORREÇÂO!!" ></textarea>
        <div class="row">
          <div class="modal-footer">
            <button type="button" class="btn btn-dark" onClick="location.href='{{URL::to('Professor/Peticoes')}}'">CANCELAR</button>
            <button type="submit" name="botao" class="btn btn-danger"  id="btnReprovar" value="REPROVAR">REPROVAR</button>
            <button type="submit" name="botao" class="btn btn-success" value="APROVAR">APROVAR</button>
  
          </div>
        </div>
      </form>
    </div>
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
              @if($comment->human->user->type == 'teacher' && $petition->teacher_ok != 'true')
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
              <h5 class="text-center">Nenhum Comentário!</h5>
            @endforelse
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
