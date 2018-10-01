@extends('layouts.student')
@section('content')
<div style="width:100%">
  <div style="width:60%;position:relative;float:left">
    <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
      @if($petitions->where('visible','true')->where('student_ok','!=','true')->first())
        <div class="row" style="margin-left:70%">
          <div>
            @if($petition->visible != 'true')
            <button type="button" class="btn btn-dark" onclick="mudarPeticao()" title="Clique para trocar peticao"><i class="fa fa-refresh"></i></button>
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

      <div class="row">
        <label for="">TEMPLATE:</label>
        <select class="form-control" name="template_id" disabled>
          <option value="{{$temps->find($petition->template_id)->id}}">{{$temps->find($petition->template_id)->title}}</option>
        </select>
      </div>
      <br>
      <div class="row">
        <label for="">DESCRIÇÃO</label>
        <input class="form-control" name="description" value="{{$petition->description}}" disabled/>
      </div>
      <br>
      <div class="row">
        <label for="">CONTEÚDO</label>
        <textarea  class="ckeditor" maxlength="99999" name="content" disabled>{{$petition->content}}</textarea>
      </div>
      <br>
      @if($photos->count() != 0)
      <div class="row">
        <label for="">DOCUMENTAÇÃO:</label>
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
          <button type="button" class="btn btn-dark" onClick="location.href='{{URL::to('Aluno/Peticoes')}}'">VOLTAR</button>
        </div>
      </div>
  </div>

  <div style="width:30%;height: 20%;padding-left: 10%;position:relative;float:left">
    <h4 style="margin-left:10px">COMENTÁRIOS:</h4><br>
    <p>
      <button class="btn btn-outline-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        MOSTRAR
      </button>
    </p>
    <div class="collapse" id="collapseExample">
        @forelse($comments as $comment)
          @if($comment->human->user->type == 'teacher')
          <div class="card text-white bg-primary mb-3" style="max-width: 18rem;border-radius: 10px;border: 1px solid #000;">
            <div class="card-header" style="margin-left:15px">&nbsp;&nbsp;PROFESSOR:<br>{{$comment->human->name}}</div>
              <textarea rows="12" maxlength="99999" style="resize:none;" disabled>{{$comment->content}}</textarea>
          </div>
          @endif

          @if($comment->human->user->type == 'defender')
            <div class="card text-white bg-warning mb-3" style="max-width: 18rem;border-radius: 10px;border: 1px solid #000;">
              <div class="card-header" style="margin-left:15px">&nbsp;&nbsp;DEFENSOR:<br>{{$comment->human->name}}</div>
                <textarea rows="12" maxlength="99999" style="resize:none;" disabled>{{$comment->content}}</textarea>
            </div>
          @endif
        @empty
          <h3 class="text-center">Nenhum Comentário!</h3>
        @endforelse
    </div>
  </div>
</div>
@stop
