@extends('layouts.teacher')
@section('component')
<div class="container">
  <div class="row justify-content-center my-5">
    <div class="col-lg-10">
      <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
      <form action="{{URL::to('Professor/Template/Cadastrar')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <label for="">TÍTULO</label>
        <input class="form-control" type="text" name="title" value="" required/>
        <br><br><br>
        <label for="">CONTEÚDO</label>
        <textarea class="ckeditor" maxlength="99999" name="content" required></textarea>
        <br><br>
        <div class="row">
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" onClick="location.href='{{URL::to('Professor/Templates')}}'">CANCELAR</button>
            <button type="submit" name="botao" class="btn btn-primary" value="SALVAR">SALVAR</button>
            <button type="submit" name="botao" class="btn btn-success" value="POSTAR">POSTAR</button>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
