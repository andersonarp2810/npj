@extends('layouts.defender')
@section('content')
<div style="width:100%">
  <div style="width:60%;position:relative;float:left">
    <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
    <form action="{{URL::to('Defensor/Comentario/Cadastrar')}}" method="post" enctype="multipart/form-data">
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
          @if($photo->photo != "" && $photo->photo != null)
            <img src="{{URL::asset('storage/'.'petition/'.$petition->id.'/'.$photo->photo)}}" class="img-responsive img-thumbnail" style="width:450px; height:250px; margin:0 auto">
          @endif
        @endforeach
      </div>
      <br>
      <div class="row">
        <textarea  cols="130" rows="10" maxlength="99999" name="comment" id ="comment" style="resize:none" placeholder="Preencha caso necessite de CORREÇÂO!!" ></textarea>
      </div>
      <div class="row">
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" onClick="location.href='{{URL::to('Defensor/Peticoes')}}'">CANCELAR</button>
          <button type="submit" name="botao" class="btn btn-danger"  id="btnReprovar" value="REPROVAR">REPROVAR</button>
          <button type="submit" name="botao" class="btn btn-success" value="APROVAR">APROVAR</button>
        </div>
      </div>
    </form>
  </div>

  <div style="width:30%;padding-left: 10%;position:relative;float:left">
    <h2 style="margin-left:10px">COMENTÁRIOS:</h2><br>
    <p>
      <button class="btn btn-outline-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        MOSTRAR
      </button>
    </p>
    <div class="collapse" id="collapseExample">
    @forelse($comments as $comment)
      @if($comment->human->user->type == 'defender')
        <div class="card text-white bg-warning mb-3" style="max-width: 18rem;border-radius: 10px;border: 1px solid #000;">
          <div class="card-header" style="margin-left:15px">&nbsp;&nbsp;DEFENSOR:&nbsp;{{$comment->human->name}}</div>
            <textarea rows="12" maxlength="99999" style="resize:none;" disabled>{{$comment->content}}</textarea>
        </div>
      @endif
    @empty
      <h3 class="text-center">Nenhum Comentário!</h3>
    @endforelse
  </div>
  </div>
</div>
@stop
