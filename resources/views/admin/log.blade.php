@extends('layouts.admin')
@section('component')
<div class="card">
    <h4 class="card-title">Gerenciar Grupos</h4>
    <div class="card-body">
        <div class="col-lg-12">
        <div class="card">
            <div class="row">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif
            @if(Session::has('status'))
                <p class="alert alert-info" style="width:20%;">{{ Session::get('status') }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
            </div>
            <div class="row">
                <div class="col-md-3">
                    <span class="text-center">
                    <div class="input-group">
                        <input type="search" name="" class="form-control" value="" placeholder="Buscar por nome..." onkeyup="filtroDeBusca(this.value, 0)">
                        <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                        </span>
                    </div>
                    </span>
                </div>
                <div class="col-md-3">
                    <span class="text-center">
                    <div class="input-group">
                        <input type="search" name="" class="form-control" value="" placeholder="Buscar por tipo de usuário..." onkeyup="filtroDeBusca(this.value, 1)">
                        <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                        </span>
                    </div>
                    </span>
                </div>
                <div class="col-md-3">
                    <span class="text-center">
                    <div class="input-group">
                        <input type="search" name="" class="form-control" value="" placeholder="Buscar por URL..." onkeyup="filtroDeBusca(this.value, 2)">
                        <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                        </span>
                    </div>
                    </span>
                </div>
                <div class="col-md-3">
                    <span class="text-center">
                    <div class="input-group">
                        <input type="search" name="" class="form-control" value="" placeholder="Buscar por data..." onkeyup="filtroDeBusca(this.value, 3)">
                        <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                        </span>
                    </div>
                    </span>
                </div>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                    <th style="font-size:18pt" class="text-center">NOME</th>
                    <th style="font-size:18pt" class="text-center">TIPO</th>
                    <th style="font-size:18pt" class="text-center">URL</th>
                    <th style="font-size:18pt" class="text-center">PARÂMETROS</th>
                    <th style="font-size:18pt" class="text-center">DATA E HORA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr class="object" name="{{($log->user->type == 'guest' ? 'Não autenticado' : $log->user->human->name) . '/' . $log->user->type . '/' . $log->route . '/' . $log->created_at}}">
                        <td style="font-size:10pt" class="text-center">{{$log->user->type == 'guest' ? 'Não autenticado' : $log->user->human->name}}</td>
                        <td style="font-size:10pt" class="text-center">{{$log->user->type}}</td>
                        <td style="font-size:10pt" class="text-center">{{$log->route}}</td>
                        <td style="font-size:10pt" class="text-center">{{$log->request}}</td>
                        <td style="font-size:10pt" class="text-center">{{$log->created_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection