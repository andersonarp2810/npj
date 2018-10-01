@extends('layouts.teacher')
@section('content')
<div style="width:100%">
  <div style="width:65%;float:left">
    <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
      {{ csrf_field() }}
      <input type="hidden" name="idTemplate" value="{{$template->id}}">
      <label for="">TÍTULO</label><br>
      <input class="form-control" type="text" name="title" value="{{$template->title}}" disabled/>
      <label for="">CONTEÚDO</label><br>
      <textarea  class="ckeditor" maxlength="99999" name="content" disabled>{{$template->content}}</textarea>
      <div class="row">
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" onClick="location.href='{{URL::to('Professor/Templates')}}'">VOLTAR</button>
        </div>
      </div>
  </div>
</div>
@stop
