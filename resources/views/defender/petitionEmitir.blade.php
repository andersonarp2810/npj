@extends('layouts.defender')
@section('component')
<div class="container">
  <div class="row justify-content-center mt-3">
    <div class="col-lg-10">
    <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
      {{ csrf_field() }}
      <form action="{{ asset('process.php')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idPetition" value="{{$petition->id}}">
        <div class="row">
          <label>Descrição:</label><br>
          <input class="form-control" type="text" name="description" value="{{$petition->description}}" disabled/>
          <input class="form-control" type="hidden" name="description" value="{{$petition->description}}"/>
        </div>
        <br>
        <div class="row">
          <label>Conteúdo:</label>
          <textarea  class="ckeditor" maxlength="99999" name="conteudo" disabled>{{$petition->content}}</textarea>
        </div>

        <input type="hidden" class="ckeditor" name="content" value="{{$petition->content}}"/>

        <br>
        <label for="">Documentação:</label>
        <div class="row">
          @foreach($photos as $photo)
            @if($photo->photo != "" && $photo->photo != null)
              <div class="col-3 mb-3">
                <img id="myImg" src="{{URL::asset('storage/'.$photo->photo)}}" class="img-fluid img-thumbnail" style="width:200px; height:200px;" onclick="showImage(this)">
              </div>
              <br>
              @endif
          @endforeach
        </div>
        <br>
        <div class="row">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onClick="location.href='{{URL::to('Defensor/Peticoes')}}'">
              <span class="fas fa-arrow-left mr-2"></span>
              Voltar
            </button>
            <button type="submit" class="btn btn-success" id="export">
              <span class="fas fa-file-download mr-2"></span>
              Emitir
            </button>
          </div>
        </div>
      </form>
  </div>
</div>
</div>
<div id="myModal" class="img-modal">
  <span id="close" class="img-close">&times;</span>
  <img class="img-modal-content" id="img-view">
</div>
@stop
