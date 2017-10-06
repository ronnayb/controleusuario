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
            <h3 class="box-title">{{$title}}</h3>

            <div class="formulario" >
                <div class="col-md-6">
                <form action="{{route('verificarcpfpessoa')}}" method="post">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="cpfDaPessoa">CPF da pessoa:</label>
                            <input type="text" class="form-control text-black" id="cpfDaPessoa" name="cpfDaPessoa" value="" placeholder="Número do CPF" maxlength="11" pattern="([0-9]{11})" > 
                            <div id="carregando" class="hidden"></div>
                            <small id="cpf_ususario_Help" class="form-text text-muted hidden"></small>
                        </div>
                        <button type="submit">Busca por cpf</button>
                                    
                </form>
                <div>ou</div>
                <form action="{{route('verificarnomepessoa')}}" method="post">
                    {{ csrf_field() }}
                    
                        <div class="form-group">
                            <label for="nome">Nome da pessoa:</label>
                            <input type="text" class="form-control text-black" id="nome" name="nome" value="" placeholder="Nome da pessoa"> 
                            <div id="carregando" class="hidden"></div>
                            <small id="nome_ususario_Help" class="form-text text-muted hidden"></small>
                        </div>
                        <button type="submit">Busca por nome</button>
                                      
                </form>
                </div>
                @isset($pessoas)
                    <div class="col-md-12">
                        <h4>Resulado da busca que possuem CPF cadastrado.</h4>
                        <br>
                        {!! $pessoas->appends(request()->input())->links() !!}
                        <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                            <tbody>
                                <tr>
                                    <th>Nome do Servidor</th>
                                    <th>CPF</th>
                                </tr>
                            </tbody
                            
                            @foreach($pessoas as $pessoa)
                                    <tr> 
                                        <td>{{$pessoa->NOME}}</td>
                                        <td>
                                            <form action="{{route('verificarcpfpessoa')}}" method="post">
                                                {{ csrf_field() }}
                                                <input type="text" class="form-control text-black hidden" id="cpfDaPessoa" name="cpfDaPessoa" value="{{$pessoa->CPF}}">
                                                <button type="submit" class="btn btn-primary">{{$pessoa->CPF}}</button>
                                            </form>
                                        </td>
                                    </tr>
                            @endforeach
                            
                        </table>
                        {{ $pessoas->appends(request()->input())->links() }}
                        <h5></h5>
                    </div>
                @endisset
            </div>
        </div>
    </div>
</section>

@endsection
