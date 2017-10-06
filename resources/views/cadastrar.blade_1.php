@extends('template.admin')

@section('content')
 

<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Cadastrar Usuário</h3>
            @if($msg != "")
            <div class="alert alert-success">
                {{$msg}}
            </div>
            @endif
            <div class="formulario" style="//overflow-y:scroll;">
                <form action="{{route('salvar')}}" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-6">                
<!--                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="">
                        </div>-->
                        <div class="form-group">
                            <label for="login">Login:</label>
                            <input type="text" class="form-control text-black" id="login" name="login" value="" placeholder="Número do CPF" maxlength="11" pattern="([0-9]{11})" required="true" >
                            
                            <div id="carregando" class="hidden">
                                <i class="fa fa-refresh fa-spin"></i> Buscando informações do CPF..
                              </div>
                            <small id="loginHelp" class="form-text text-muted hidden"></small>
                            
                        </div>
                        <div class="form-group">
                            <label for="login">Senha:</label>
                            <input type="password" class="form-control" id="senha" name="senha" value="" maxlength="8" size="8" placeholder="Senha" required="true">
                        </div>
                        <div class="form-group">
                            <label for="login">Confirmação de senha:</label>
                            <input type="password" class="form-control" id="confirmacao_senha" name="confirmacao_senha" value="" maxlength="8" size="8" placeholder="Confirmar senha" required="true">
                            <small id="confirmacaoHelp" class="form-text text-muted">Números e Caracteres.</small>
                        </div>
                        <div class="form-group">
                            <label for="login">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="" placeholder="Entre com o email">
                            <small id="emailHelp" class="form-text text-muted">Ex: nome@dominio.com</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        
                        <div id="carregando"></div>
                        <div class="form-group unidades">
                            <label for="acesso" >Unidade:</label>
                            <select id="unidade" name="CDESCMEC" class="select2-unidades form-control select2" style="width: 100%;" data-placeholder="Selecione a unidades">
                                <!--onChange="window.location.href=this.value; changeSelect2();"-->
                                <option value="" disabled selected></option>
                                @foreach($unidades as $unidade)
                                    <option value="{{$unidade->CDESCMEC}}"><h6>{{$unidade->DCESC}} </h6></option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="login">Pessoa:</label>
                            <input type="text" class="form-control" id="pessoa" name="pessoa" value="" required="true">
                        </div>                

                        <div class="form-group">
                            <label for="ativo" class="form-check-label">
                                <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1" checked="true"> Ativo
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Grupos de acesso permitido: </label>
                            <label for="todos" class="form-check-label">
                                <input type="checkbox" class="form-check-input" id="todos" name="todos" value="" > Seleciona todos
                            </label>
                            <select class="form-control select2 select2-hidden-accessible" name="grupos[]" multiple="" data-placeholder="Selecione os acessos" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                @foreach($grupos as $grupo)
                                <option value="{{$grupo->CDGRUPO}}"><h6>{{$grupo->CDGRUPO}} - {{ $grupo->DCGRUPO}} - ({{$grupo->NIVELACESSO}})</h6></option>
                                @endforeach
                            </select>   
                        </div>

                        <div class="form-group">
                            <label>Data de expiração:</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                                <input class="form-control pull-right" name="data_expiracao"  id="datepicker" type="text" required="true">
                            </div>
                        </div>
                        
                        
                        <input class="form-control pull-right hidden" name="identificador"  id="identificador" type="text" value="">
                        <input class="form-control pull-right hidden" name="alterasenha"  id="alterasenha" type="text" value="0">
                        <input class="form-control pull-right hidden" name="cpfusuario_incl"  id="cpfusuario_incl" type="text" value="{{ Auth::user()->cpf }}">
                        <input class="form-control pull-right hidden" name="dtacesso_incl"  id="dtacesso_incl" type="text">
                        <input class="form-control pull-right hidden" name="cpfusuario_altr"  id="cpfusuario_altr" type="text">
                        <input class="form-control pull-right hidden" name="cpfusuario_altr"  id="cpfusuario_altr" type="text" value="{{ Auth::user()->cpf }}">
                        
                        <div class="form-group">
                            <button type="submit" id="enviar" class="btn btn-default" >Enviar</button>
                        </div>
                        <h5></h5>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
