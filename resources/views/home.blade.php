
@extends('template.admin')
@section('content')

<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            @isset($msg)
            <div class="alert alert-success">   
                {{$msg}}
            </div>
            @endisset
            <div class="panel-heading">
                <h3 class="box-title">Sistema de Segurança</h3>
            </div>
            <div class="panel-heading">
                <h3>Dados do Usuário</h3>
                <b>Nome:</b> {{ Auth::user()->name }}<br>
                <b>Email</b>: {{ Auth::user()->email }}<br>
                <b>CPF:</b> {{ Auth::user()->cpf }}
            </div>
        </div>
    </div>
</section>

@endsection
