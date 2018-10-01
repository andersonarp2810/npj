@extends('layouts.student')
@section('content')
  <div style="width:100%">
    <div style="width:60%;position:relative;float:left">
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
          <label for="">DESCRIÇÃO</label>
          <input class="form-control" name="description" value="{{$petition->description}}" />
        </div><br>
        <div class="row">
          <h2>CONTEÚDO:</h2><br>
          <textarea  class="ckeditor" maxlength="99999" name="content" required>{{$petition->content}}</textarea>
        </div>
        <br>
        @if($IsPhotos == 'true')
        <div class="row">
            <label for="">DOCUMENTAÇÃO:</label>
            @foreach($photos as $photo)
              @if($photo->photo != "" || $photo->photo != null)
                <img src="{{URL::asset('storage/'.$photo->photo)}}" class="img-responsive img-thumbnail" style="width:450px; height:250px; margin:0 auto">
              @endif
            @endforeach
        </div>
        <br>
        @elseif($IsPhotos == 'false')
        <div class="row">
          <label for="">DOCUMENTAÇÃO:</label>
          <input type="file" name="images[]" class="form-control" multiple>
        </div>
        <br>
        @endif
        <div class="row">
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" onClick="location.href='{{URL::to('Aluno/Peticoes')}}'">CANCELAR</button>
            <button type="submit" name="botao" class="btn btn-primary" value="SALVAR">SALVAR</button>
            <button type="submit" name="botao" class="btn btn-success" value="ENVIAR">ENVIAR</button>
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
        @if($comment->human->user->type == 'teacher')
        <div class="card text-white bg-primary mb-3" style="max-width: 18rem;border-radius: 10px;border: 1px solid #000;">
          <div class="card-header" style="margin-left:15px">&nbsp;&nbsp;PROFESSOR:&nbsp;{{$comment->human->name}}</div>
          <!--<div class="card-body">-->
            <textarea rows="12" maxlength="99999" style="resize:none;" disabled>{{$comment->content}}</textarea>
          <!--</div>-->
        </div>
        @endif
          <div class="card text-white bg-warning mb-3" style="max-width: 18rem;border-radius: 10px;border: 1px solid #000;">
            @if($comment->human->user->type == 'defender')
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
