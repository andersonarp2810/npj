@extends('layouts.teacher')
@section('component')
<div class="component">
  <div class="row justify-content-center">
    <div class="col-lg-10">
        <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
        <form action="{{URL::to('Professor/Peticao/Template')}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" name="idPetition" value="{{$petition->id}}">
          <h2>DESCRIÇÃO:</h2><br>
          <textarea  class="ckeditor" maxlength="99999" name="description" disabled>{{$petition->description}}</textarea>
          <div class="row">
            <label for="">Defensor</label>
            <select class="form-control" name="defender_id" disabled>
              <option value="{{$humans->find($petition->defender_id)->id}}">{{$humans->find($petition->defender_id)->name}}</option>
            </select>
            <label for="">Template</label>
            <select class="form-control" name="template_id" required>
              <option value="">Selecione o Template</option>
              @foreach($templates as $template)
                @if($template->status == 'active')
                  <option value="{{$template->id}}">{{$template->title}}</option>
                @endif
              @endforeach
            </select>
          </div>
          <div class="row">
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" onClick="location.href='{{URL::to('Professor/Peticoes')}}'">CANCELAR</button>
              <button type="submit" class="btn btn-primary">SALVAR</button>
            </div>
          </div>
        </form>
    </div>
  </div>
</div>
@endsection
