$(document).ready(function (){
    $(".select2-unidades").change(function(){
        
        var dcesc = $(".select2-search__field").val();
        var url2     = "/pesquisarunidades/"+dcesc;
        
        $.ajax({
            url: url2,
            dataType: 'json',
            beforeSend: function(){                
            },
            error: function (){
            },
            success: function(retorno){
                if(retorno === 1){
                }else{
                    $(".select2-unidades-results").html("<li>Teste</li");
                }
            }
        });
        
    });
    function pesquisarUnidadesByCdt(CDTPUNIDADE){        
        var url     = "/pesquisarunidades/"+CDTPUNIDADE;
        
        $.ajax({
            url: url,
            dataType: 'json',
            beforeSend: function(){
                $("#carregando").removeClass('hidden').addClass('show');
                $("#carregando").html("<i class='fa fa-refresh fa-spin'></i>Carregando...");
            },
            error: function (){
            },
            success: function(retorno){
                if(retorno === 1){
                }else{
                    var itens = "<option value='' disabled selected></option>";
                    
                    for(var i = 0; i < retorno.length; i++){
                        itens += "<option value="+retorno[i].CDESCMEC+">"+retorno[i].DCESC+"</option>";
                    }                    
                    $(".unidades").removeClass('hidden').addClass('show');
                    $(".select2-unidades").html(itens);
                    $("#carregando").addClass("hidden");
                }
            }
        });
    }
    
    $(".select2-unidades").select2({
        placeholder: "Unidades"
    });
    $(".select2-tdunidades").select2();
    $(".select2-acesso").select2();
    $(".select2-hidden-accessible").select2();
    
    $( "#datepicker" ).datepicker({
        format: "dd-mm-yyyy",
        startDate: 'd',
        language: 'pt-BR'
    });
    if($("#datepicker").val() == []){        
    }else{
        $("#datepicker").val(formatDate($("#datepicker").val()));
    }
    $('#login').mask('00000000000', {reverse: true});// Cadastrar Usuário
    $('#cpf').mask('00000000000', {reverse: true});// Register
    $("#cpfusuario").mask('00000000000', {reverse: true});// Gerenciar Usuário
    $("#cpfDaPessoa").mask('00000000000', {reverse: true});// Gerenciar Usuário
    
//    $("#login").keyup(function(){
//        var arrayCPF = $(this).val();
//        
//        if(arrayCPF.length == 11){
//            var cpf = $(this).val();
//            var url = "/searchpessoabycpf/"+cpf;
//            var url2 = "/searchusuariobycpf/"+cpf;
//            
//             $.ajax({
//                url: url2,
//                dataType: 'json',
//                beforeSend: function(){
//                    $("div#carregando").removeClass('hidden').addClass('show');
//                },
//                error: function (){
//                },
//                success: function(retorno){
//                    if(typeof  retorno[0] === 'undefined'){
//                        buscarPessoa();
//                    }else{
//                        $("#loginHelp").removeClass('hidden').addClass('show')
//                                .text('Já existe usuário para esse CPF')
//                                .removeClass('text-red').addClass('text-blue');
//                        $("div#carregando").removeClass('show').addClass('hidden');
//                    }
//                }
//            });
//            
//            function buscarPessoa(){
//                    $.ajax({
//                    url: url,
//                    dataType: 'json',
//                    beforeSend: function(){
//                        $("div#carregando").removeClass('hidden').addClass('show');
//                    },
//                    error: function (){
//                    },
//                    success: function(retorno){
//                        if(typeof  retorno[0] === 'undefined'){
//                            $("#login").removeClass('text-black').addClass('text-red');
//                            $("#loginHelp").removeClass('hidden').addClass('show')
//                                    .text('CPF não encontrado!')
//                                    .removeClass('text-blue').addClass('text-red');
//                            $("div#carregando").removeClass('show').addClass('hidden');
//                            $("#pessoa").val("");
//                        }else{
//                            $("#login").removeClass('text-red').addClass('text-black');
//                            $("#loginHelp").removeClass('hidden').addClass('show')
//                                    .text('CPF encontrado com êxito!')
//                                    .removeClass('text-red').addClass('text-blue');
//                            $("#pessoa").val(retorno[0].NOME);
//                            $("#identificador").val(retorno[0].IDENTIFICADOR);
//                            $("div#carregando").removeClass('show').addClass('hidden');
//                            $("#unidade").val(retorno[0].CDESCMEC).attr('selected','true');
//                            $("#unidade").select2();
//                        }
//                    }
//                });
//            }
//            
//        }
//        $("#loginHelp").removeClass('show').addClass('hidden');
//        $("#pessoa").val("");
//    });
    
    $("#cpfusuario").keyup(function(){
        var array = $(this).val();
        if(array.length == 11){  
        $("#loginHelp").removeClass('show').addClass('hidden');
        $("#pessoa").val("");        
        }
        
    });
    
    $("#cpfDaPessoa").keyup(function(){
        var array = $(this).val();
        if(array.length == 11){       
        $("#cpf_ususario_Help").removeClass('hidden').addClass('show')
                                .text('CPF preenchido corretamente!')
                                .removeClass('text-blue').removeClass('text-orange').addClass('text-green');
        $("#loginHelp").removeClass('show').addClass('hidden');
        }else if(array.length < 11){
            $("#cpf_ususario_Help").removeClass('hidden').addClass('show')
                                .text('CPF incompleto!')
                                .removeClass('text-blue').addClass('text-orange');
        }
    });
    
    $("#ativo").change(function(){
            if($(this).is(':checked')){ 
                $(this).val(1);
            }else{
                $(this).val(0);
            }
        });
        
    $('#todos').change(function() {
        if ($(this).is(':checked')) {
            $(".select2-hidden-accessible option").attr('selected','true');
            $(".select2-hidden-accessible").select2();
        }else if(!$(this).is(':checked')){
            $(".select2-hidden-accessible option").removeAttr('selected');
            $(".select2-hidden-accessible").select2();
        }
    });
    $("#enviar").click(function(e){
        
        $("#dtalteracao").val(dataAcesso());
        
        if($("#confirmacao_senha").val() == $("#senha").val() && $("#senha").val() != ""){
            $("#confirmacaoHelp").text("OK!").addClass("text-blue");
        }else if($("#senha").val() == ""){
            e.preventDefault();
            $("#confirmacaoHelp").text("Preencha o campo senha!").addClass("text-red");
        }else{
            e.preventDefault();
            $("#confirmacaoHelp").text("Senhas divergem!").removeClass("text-blue").addClass("text-red");
        }
        
        if($("#ativo").is(':checked')){ 
            $(this).val(1);
        }else{
            $(this).val(0);
        }
        
    });
    $("#salvar").click(function(e){
        
        $("#dtalteracao").val(dataAcesso());
        
        if($("#confirmacao_senha").val() == $("#senha").val() && $("#senha").val() == ""){
            
        }else if($("#confirmacao_senha").val() == $("#senha").val() && $("#senha").val() != ""){
            $("#confirmacaoHelp").text("OK!").addClass("text-blue");
        }else{
            e.preventDefault();
            $("#confirmacaoHelp").text("Senhas divergem!").removeClass("text-blue").addClass("text-red");
        }
        
        if($("#ativo").is(':checked')){ 
            $(this).val(1);
        }else{
            $(this).val(0);
        }
        
    });
    $("#datepicker").change(function(){
        
        var dataEHora = dataAcesso();

        var data_expiracao = $(this).val();
        data_expiracao = dataAcesso();
        $("#datepicker").val(data_expiracao);
        $("#dtacesso_incl").val(dataAcesso());
    });
    
    function dataAcesso(){
        var data = new Date();
        
        var day    = data.getDate();
        var year   = data.getFullYear();
        var month  = data.getMonth()+1;
        var hours  = data.getHours();          // 0-23
        var minutes    = data.getMinutes();        // 0-59
        var seconds    = data.getSeconds();        // 0-59
        var Milliseconds   = data.getMilliseconds();   // 0-999
        
        var mes  = ("0"+month).slice(-2, 10);
        var dia  = ("0"+day).slice(-2, 10);
        var hora = ("0"+hours).slice(-2, 10);
        var min  = ("0"+minutes).slice(-2, 10);
        var seg  = ("00"+seconds).slice(-2, 10);
        var mseg = ("0"+Milliseconds).slice(-3, 10);
        
        var dtacesso = dia+'-'+mes+'-'+year;
        return dtacesso;
    }
    
    function formatDate(data){
        var d = new Date(data);
        
        var day    = d.getDate();
        var year   = d.getFullYear();
        var month  = d.getMonth()+1;
        
        var mes  = ("0"+month).slice(-2, 10);
        var dia  = ("0"+day).slice(-2, 10);
        
        return dia+"-"+mes+"-"+year;
    }
    
}); 

$('.link-delete').click(function (){
    $(this).next().removeClass('hidden').addClass('show');
});
$('.cancel-delete').click(function (){
    $('.link-delete + .delete-msg').removeClass('show').addClass('hidden');
});