@extends('layouts.student')
@section('content')
  <div style="width:100%">
    <div style="width:85%;margin-left: 2%">
      <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
      <form action="{{URL::to('Aluno/Peticao/Cadastrar')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="template_id" value="{{$template->id}}"/>
        <label for="">PETIÇÃO</label>
        <input class="form-control" type="text" value="{{$template->title}}" disabled/>
        <br>
        <label for="">DESCRIÇÃO</label>
        <input class="form-control" type="text" name="description" value="" required/>
        <br>
        <label for="">CONTEÚDO</label>
        <textarea  class="ckeditor" maxlength="99999" name="content" required>{{$template->content}}</textarea>
        <br>
        <div class="row">
          <div class="col-md-6">
            <label>Documentação</label>
            <input type="file" name="images[]" class="form-control" multiple>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" onClick="location.href='{{URL::to('Aluno/Peticoes')}}'">CANCELAR</button>
            <button type="submit" name="botao" class="btn btn-primary" value="SALVAR">SALVAR</button>
            <button type="submit" name="botao" class="btn btn-success" value="ENVIAR">ENVIAR</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@stop
