@extends('layouts.student')
@section('component')
<div class="container">
  <div class="row justify-content-center my-3">
    <div class="col-lg-10">
      <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
      @if($petitions->where('visible','true')->where('student_ok','!=','true')->first())
      <div class="row" style="margin-left:70%">
        <div>
          @if($petition->visible != 'true')
          <button type="button" class="btn btn-dark" onclick="mudarPeticao()" title="Clique para trocar peticao"><i
              class="fa fa-refresh"></i></button>
          @else
          <button type="button" class="btn btn-dark" onclick="mudarPeticao()" disabled><i class="fa fa-refresh"></i></button>
          @endif
        </div>
        <div>
          <select class="form-control" onchange="location.href=this.value" id="idPetition" style="width:100%;">
            @if($petition->visible == 'true')
            <option value="{{$petition->id}}">Versão Atual {{$petition->version}}.0</option>
            @else
            <option value="{{$petition->id}}">Versão {{$petition->version}}.0</option>
            @endif
            @foreach($petitions as $p)
            @if($petition->id != $p->id)
            @if($p->visible == 'true')
            <option value="{{$p->id}}">Versão Atual {{$p->version}}.0</option>
            @else
            <option value="{{$p->id}}">Versão {{$p->version}}.0</option>
            @endif
            @endif
            @endforeach
          </select>
        </div>
      </div>
      @elseif($petitions->where('visible','true')->where('student_ok','true')->where('defender_ok','true')->first())
      <div class="row" style="margin-left:65%">
        <div>
          <button type="button" class="btn btn-dark" onclick="copiarPeticao()" title="Clique para copiar peticao">COPY</button>
        </div>
        <div>
          <select class="form-control" onchange="location.href=this.value" id="idPetition" style="width:100%;">
            @if($petition->visible == 'true')
            <option value="{{$petition->id}}">Versão Atual {{$petition->version}}.0</option>
            @else
            <option value="{{$petition->id}}">Versão {{$petition->version}}.0</option>
            @endif
            @foreach($petitions as $p)
            @if($petition->id != $p->id)
            @if($p->visible == 'true')
            <option value="{{$p->id}}">Versão Atual {{$p->version}}.0</option>
            @else
            <option value="{{$p->id}}">Versão {{$p->version}}.0</option>
            @endif
            @endif
            @endforeach
          </select>
        </div>
      </div>
      @endif
      <div class="row justify-content-center">
        <button class="btn btn-primary float-right" type="button" data-toggle="modal" data-target="#comments"
          aria-expanded="false" aria-controls="comments">
          Ver comentários
        </button>
      </div>
      <div class="row">
        <label for="">Template:</label>
        <select class="form-control" name="template_id" disabled>
          <option value="{{$temps->find($petition->template_id)->id}}">{{$temps->find($petition->template_id)->title}}</option>
        </select>
      </div>
      <br>
      <div class="row">
        <label for="">Descrição</label>
        <input class="form-control" name="description" value="{{$petition->description}}" disabled />
      </div>
      <br>
      <div class="row">
        <label for="">Conteúdo</label>
        <textarea class="ckeditor" maxlength="99999" name="content" disabled>{{$petition->content}}</textarea>
      </div>
      <br>
      @if($photos->count() != 0)
      <div class="row">
        <label for="">Documentação:</label>
        @foreach($photos as $photo)
        @if($photo->photo == "" || $photo->photo == null)
        <img src="{{URL::asset('storage/1')}}" class="img-responsive img-thumbnail" style="width:120px; height:120px; margin:0 auto">
        @else
        <img src="{{URL::asset('storage/'.$photo->photo)}}" class="img-responsive img-thumbnail" style="width:450px; height:250px; margin:0 auto">
        @endif
        @endforeach
      </div>
      <br>
      @endif
      <div class="row">
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" onClick="location.href='{{URL::to('Aluno/Peticoes')}}'">
            <span class="fas fa-arrow-left mr-2"></span>
            Voltar
          </button>
        </div>
      </div>
    </div>

    <div class="modal fade" id="comments" tabindex="-1" role="dialog" aria-labelledby="comments" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Comentários</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <ul>
              @forelse($comments as $comment)
              @if($comment->human->user->type == 'teacher')
              <li>
                <strong>
                  Orientador:
                </strong>
                {{$comment->human->name}}
                <br>
                <strong>Comentário:</strong>
                <span>{{$comment->content}}</span>
              </li>
              @endif

              @if($comment->human->user->type == 'defender')
              <li>
                <strong>
                  Defensor:
                </strong>
                {{$comment->human->name}}
                <br>
                <strong>Comentário:</strong>
                {{$comment->content}}
              </li>
              @endif
            </ul>
            @empty
            <h3 class="text-center">Nenhum Comentário!</h3>
            @endforelse
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>

    @endsection