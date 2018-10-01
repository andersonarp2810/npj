@extends('layouts.defender')
@section('content')
<div style="width:100%">
  <div style="width:65%;margin-left:3%">
    <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
      {{ csrf_field() }}
      <form action="{{ asset('process.php')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idPetition" value="{{$petition->id}}">
        <label>DESCRIÇÃO</label><br>
        <input class="form-control" type="text" name="description" value="{{$petition->description}}" disabled/>
        <input class="form-control" type="hidden" name="description" value="{{$petition->description}}"/>
        <label>CONTEÚDO</label>
        <textarea  class="ckeditor" maxlength="99999" name="conteudo" disabled>{{$petition->content}}</textarea>

        <input type="hidden" class="ckeditor" name="content" value="{{$petition->content}}"/>

        <br>
        <div class="row">
          <label for="">DOCUMENTAÇÃO:</label>
          @foreach($photos as $photo)
            @if($photo->photo != "" && $photo->photo != null)
            <div class="row" style="padding-top:4%">
              <img src="{{URL::asset('storage/'.'petition/'.$petition->id.'/'.$photo->photo)}}" class="img-responsive img-thumbnail" style="width:450px; height:250px; margin:0 auto">
              <a href="{{URL::asset('storage/'.'petition/'.$petition->id.'/'.$photo->photo)}}" download>Baixar Imagem</a>
            </div><br>
            @endif
          @endforeach
        </div>
        <br>
        <div class="row">
          <div class="modal-footer">
            <button type="button" class="btn btn-dark" onClick="location.href='{{URL::to('Defensor/Peticoes')}}'">VOLTAR</button>
            <button type="submit" class="btn btn-success" id="export">EMITIR</button>
          </div>
        </div>
      </form>
  </div>
</div>
@stop
