@extends('template.admin')

@section('content')

<section class="content">
    <div class="box box-default">
            
        <div class="box-header with-border">
            @isset($msg)
            <div class="alert {{$alertType}}">   
                {{$msg}}
            </div>
            @endisset
            <h3 class="box-title">Buscar Usuário</h3>

            <div class="formulario">
                <div class="col-md-6">
                    <form action="{{route('searchusuariobycpf')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="cpfDaPessoa">CPF da pessoa:</label>
                        <input type="text" class="form-control text-black" id="cpfDaPessoa" name="cpfDaPessoa" value="" placeholder="Número do CPF" maxlength="11" pattern="([0-9]{11})" required="true" > 
                        <div id="carregando" class="hidden"></div>
                        <small id="cpf_ususario_Help" class="form-text text-muted hidden"></small>
                    </div> 
                    <button type="submit">Buscar</button>
                    </form>
                </div>                    
               
                
                @isset($pessoa)
                    <div class="col-md-12">
                        <br>
                        <table class="table table-hover tabela-usuarios">
                            <tbody>
                                <tr>
                                    <th>Nome do usuário</th>
                                    <th>Login</th>
                                    <th>Email</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tbody
                            
                            @foreach($pessoa->usuarios as $usuario)
                            <tr> 
                                <td>{{$pessoa->NOME}}</td>
                                <td>{{$usuario->LOGIN}}</td>
                                <td>{{$usuario->EMAIL}}</td>
                                
                                <td>
                                    <a href="{{route('gerenciar',['login' => $usuario->LOGIN])}}">
                                        Gerenciar
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="text-red link-delete">
                                        Excluir
                                    </a>
                                    <div class="delete-msg hidden">
                                        <div class="alert alert-danger">
                                            <h3>Deseja realmente excluir o usuário?</h3>
                                            <a href="{{route('deletarusuario',['login' => $usuario->LOGIN])}}" class="btn btn-primary">
                                                Sim
                                            </a>
                                            <a href="#" class="btn btn-primary cancel-delete">Não</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                        </table>
                        <h5></h5>
                    </div>
                @endisset
            </div>
        </div>
    </div>
</section>


@endsection
