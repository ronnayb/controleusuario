@extends('template.admin')

@section('content')
 

<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <a href="{{route('buscarusuarios')}}">
                <h3 class="box-title"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</h3>    
            </a>
            <br><br>
            <h3 class="box-title">Gerenciar Usuário</h3>
            
            <div class="formulario" style="//overflow-y:scroll;">
                <form action="{{route('altera_usuario')}}" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-6">               
                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="{{$pessoa->NOME}}">
                        </div>
                        <div class="form-group">
                            <label for="cpfusuario">CPF do usuário:</label>
                            <input type="text" class="form-control text-black" id="cpfusuario" name="cpfusuario" value="{{$pessoa->CPF}}" placeholder="Número do CPF" maxlength="11" pattern="([0-9]{11})" required="true" > 
                            <div id="carregando" class="hidden"></div>
                            <small id="cpf_ususario_Help" class="form-text text-muted hidden"></small>
                            
                        </div>
                        <div class="form-group">
                            <label for="gerenciarLogin">Login:</label>
                            <input type="text" class="form-control text-black" id="gerenciarLogin" name="gerenciarLogin" value="{{$usuario->LOGIN}}" placeholder="Digite seu Login" required="true" > 
                            <div id="carregando" class="hidden"></div>
                            <small id="login_gerenciar_Help" class="form-text text-muted hidden"></small>
                        </div>
                        <div class="form-group">
                            <label for="senha">Alterar senha:</label>
                            <input type="password" class="form-control" id="senha" name="senha" value="" maxlength="8" size="8" placeholder="Senha">
                        </div>
                        <div class="form-group">
                            <label for="confirmacao_senha">Confirmação de senha:</label>
                            <input type="password" class="form-control" id="confirmacao_senha" name="confirmacao_senha" value="" maxlength="8" size="8" placeholder="Confirmar senha">
                            <small id="confirmacaoHelp" class="form-text text-muted">Números e Caracteres.</small>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="login">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{$usuario->EMAIL}}" placeholder="Entre com o email">
                            <small id="emailHelp" class="form-text text-muted">Ex: nome@dominio.com</small>
                        </div>
                        <div class="form-group unidades">
                            <label for="acesso" >Unidade:</label>
                            <select id="unidade" name="CDESCMEC" class="select2-unidades form-control select2" style="width: 100%;" data-placeholder="Selecione a unidades">
                                <!--onChange="window.location.href=this.value; changeSelect2();"-->
                                <option value="" disabled selected></option>
                                @foreach($unidades as $unidade)
                                    @if($unidade->CDESCMEC == $usuario->CDESCMEC)
                                        <option value="{{$unidade->CDESCMEC}}" selected="true"><h6>{{$unidade->DCESC}} </h6></option>
                                    @else
                                        <option value="{{$unidade->CDESCMEC}}"><h6>{{$unidade->DCESC}} </h6></option>
                                    @endif
                                    
                                @endforeach
                            </select>
                        </div>              

                        <div class="form-group">
                            <label>Data de expiração:</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                                <input class="form-control pull-right" name="data_expiracao" value="{{$usuario->DTEXPIRA}}" id="datepicker" type="text" required="true">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ativo" class="form-check-label">
                                <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="{{$usuario->FLATIVO}}"
                                @if($usuario->FLATIVO == 1)
                                     checked="true"
                                @endif
                                 > Ativo
                            </label>
                        </div>
                        
                        <input class="form-control pull-right hidden" name="identificador"  id="identificador" type="text" value="{{$pessoa->IDENTIFICADOR}}">
                        <input class="form-control pull-right hidden" name="alterasenha"  id="alterasenha" type="text" value="0">
                        <input class="form-control pull-right hidden" name="dtalteracao"  id="dtalteracao" type="text" value="">
                        <input class="form-control pull-right hidden" name="cpfusuario_altr"  id="cpfusuario_altr" type="text" value="{{ Auth::user()->cpf }}">
                        
                        
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Grupos de acesso permitido: </label>
                            <label for="todos" class="form-check-label">
                                <input type="checkbox" class="form-check-input" id="todos" name="todos" value="" > Seleciona todos
                            </label>
                            <select class="form-control select2 select2-hidden-accessible" name="grupos[]" multiple="" data-placeholder="Selecione os acessos" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                @php
                                    $existe = 0;
                                @endphp
                                @foreach($grupos as $grupo)
                                   <option id="{{$grupo->CDGRUPO}}" value="{{$grupo->CDGRUPO}}" 
                                    @foreach($pessoa->grupos as $grupo1)
                                        @if($grupo->CDGRUPO == $grupo1->CDGRUPO)
                                            selected
                                        @endif
                                    @endforeach
                                    ><h6>{{$grupo->CDGRUPO}} - {{ $grupo->DCGRUPO}} - ({{$grupo->NIVELACESSO}})</h6></option>
                                    
                                @endforeach
                            </select> 
                        </div>
                        <div class="form-group">
                            <button type="submit" id="salvar" class="btn btn-default" >Salvar</button> 
                            <a href="{{route('buscarusuarios')}}" class="btn btn-default">Cancelar</a>
                        </div>
                        <h5></h5>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
