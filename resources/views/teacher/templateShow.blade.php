@extends('layouts.teacher')
@section('component')
<div class="container">
  <div class="row justify-content-center my-5">
    <div class="col-lg-10">
        <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
        {{ csrf_field() }}
        <input type="hidden" name="idTemplate" value="{{$template->id}}">
        
        <label for="">Título:</label><br>
        <input class="form-control mb-3" type="text" name="title" value="{{$template->title}}" disabled/>
        
        <label for="">Conteúdo:</label><br>
        <textarea  class="ckeditor" maxlength="99999" name="content" disabled>{{$template->content}}</textarea>
        <div class="row">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onClick="location.href='{{URL::to('Professor/Templates')}}'">
              <span class="fas fa-arrow-left mr-2"></span>
              Voltar
            </button>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
