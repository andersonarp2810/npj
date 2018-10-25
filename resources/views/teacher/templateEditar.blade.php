@extends('layouts.teacher')
@section('component')
<div class="container">
  <div class="row justify-content-center my-5">
    <div class="col-lg-10">
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
              <button type="button" class="btn btn-secondary" onClick="location.href='{{URL::to('Professor/Templates')}}'">
                <i class="fas fa-arrow-left"></i>
                Voltar</button>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </div>
    </div>
  </div>
</div>
@endsection
