
@extends('template.admin')
@section('content')

<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
        
        
        @isset($grupos)
                    <div class="col-md-12">
                        <br>
                        <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                            <tbody>
                                <tr>
                                    <th>Grupo</th>
                                    <th>Descrição</th>
                                    <th>Nivel de acesso</th>
                                </tr>
                            </tbody
                            
                            @foreach($grupos as $grupo)
                            <tr> 
                                <td>{{$grupo->CDGRUPO}}</td>
                                <td>{{$grupo->DCGRUPO}}</td>
                                <td>{{$grupo->NIVELACESSO}}</td>
                            </tr>
                            @endforeach
                            
                        </table>
                        <h5></h5>
                    </div>
                @endisset
        </div>
        
    </div>
</section>

@endsection
