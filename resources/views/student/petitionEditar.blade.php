@extends('layouts.student')
@section('component')
  <div class="container">
    <div class="row justify-content-center my-3">
      <div class="text-center">
      <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#comments" aria-expanded="false" aria-controls="collapseExample">
          Ver comentários
          <span class="fas fa-comments ml-2"></span>
        </button>
      </div>
    </div>

    <!-- pra mostrar quando a petição é salva -->
    <div class="row justify-content-center">
    @if ($errors->any())
    <div class="alert alert-danger col-lg-6">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    @if(Session::has('status'))
      <p class="alert alert-info">
      {{ Session::get('status') }}
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endif
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-10">
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
          <label for="">Descrição</label>
          <input class="form-control" name="description" value="{{$petition->description}}" />
        </div><br>
        <div class="row">
          <label>Conteúdo:</label><br>
          <textarea  class="ckeditor" maxlength="99999" name="content" required>{{$petition->content}}</textarea>
        </div>
        <br>

        <label class="row">Documentação:</label>
        <div class="row">
            <br>
            @foreach($photos as $photo)
              @if($photo->photo != "" || $photo->photo != null)
              <div class="col-3 mb-3">
                <div class="text-center">
                  <img id="myImg" src="{{URL::asset('storage/'.$photo->photo)}}" class="img-fluid img-thumbnail" style="width:200px; height:200px;" onclick="showImage(this)">
                  <br>
                  <button type="button" class="btn btn-sm btn-danger" onClick="location.href='{{URL::to('Aluno/Peticao/Edit/' . $petition->id . '/DeletePhoto/' . $photo->id )}}'">
                    <span class="fas fa-trash"></span>
                  </button>
                </div>
              </div>
              @endif
            @endforeach
        </div>
        <br>

        <div class="row">
          <input type="file" accept="image/*" name="images[]" multiple>
        </div>

        <br>
        <div class="row justify-content-center">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onClick="location.href='{{URL::to('Aluno/Peticoes')}}'">
              Cancelar
              <span class="fas fa-times ml-2"></span>
            </button>
            <button type="submit" name="botao" class="btn btn-primary" value="SALVAR">
              Salvar
              <span class="fas fa-save ml-2"></span>
            </button>
            <button type="submit" name="botao" class="btn btn-success" value="ENVIAR">
              Enviar
              <span class="fas fa-share ml-2"></span>
            </button>
          </div>
        </div>
      </form>
    </div>


  <div class="modal fade" id="comments" tabindex="-1" role="dialog" aria-labelledby="comments" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Comentários</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <div class="row">
              <div class="col-6">
                <div class="text-center">
                  <strong>Orientador</strong>
                </div>
                <ul>
                  @foreach($profComments as $comment)
                  <li>
                    {{$comment->human->name}}
                    <br>
                    <strong>Comentário:</strong>
                    <span>{{$comment->content}}</span>
                  </li>
                  @endforeach
                </ul>
                @if(count($profComments) < 1)
                <p class="text-center">Nenhum Comentário!</p>
                @endif
              </div>

              <div class="col-6">
                <div class="text-center">
                  <strong>Defensor</strong>
                </div>
                <ul>
                  @foreach($defComments as $comment)
                    <li>
                      {{$comment->human->name}}
                      <br>
                      <strong>Comentário:</strong>
                      {{$comment->content}}
                    </li>
                  @endforeach
                </ul>
                @if(count($defComments) < 1)
                <p class="text-center">Nenhum Comentário!</p>
                @endif
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div id="myModal" class="img-modal">
      <span id="close" class="img-close">&times;</span>
      <img class="img-modal-content" id="img-view">
    </div>

@endsection
