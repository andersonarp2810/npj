@extends('layouts.teacher')
@section('content')
<div style="width:100%">
  <div style="width:65%;float:left">
    <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
    <form action="{{URL::to('Professor/Template/Editar')}}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input type="hidden" name="idTemplate" value="{{$template->id}}">
      <label for="">TÍTULO</label>
      <input class="form-control" type="text" name="title" value="{{$template->title}}" required/>
      <br><br>
      <label for="">CONTEÚDO</label>
      <textarea  class="ckeditor" maxlength="99999" name="content" required>{{$template->content}}</textarea>
      <div class="row">
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" onClick="location.href='{{URL::to('Professor/Templates')}}'">VOLTAR</button>
          <button type="submit" class="btn btn-primary">SALVAR</button>
        </div>
      </div>
  </div>
</div>
@stop
