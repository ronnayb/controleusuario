<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Usuario;
use App\Models\Grupo;
use App\Models\UsuarioGRP;
use App\Models\Pessoa;
use App\Models\Unidade;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
//    private $dataFormat = 'Y-m-d h:m:s'; //Desenvolvimento
    private $dataFormat = 'd-m-Y'; //Produção
    
    public function __construct() {
        
    }

    public function index(){
        $title = "Home";
        return view('home',  compact('title'));
    }
    public function unidades(){
        $unidades = \DB::connection('sqlsrv')->table('dbo.esc_unidade')
                        ->where('FLATIVA','=',1)
                        ->get();
        dd($unidades);
    }
    public function tpunidades(){
        $unidades = \DB::connection('sqlsrv')->table('dbo.esc_tpunidade')
                        ->get();
        dd($unidades);
    }
    public function grupos(){
        $grupos = Grupo::all();
        return view('grupos',  compact('title','grupos'));
    }
    public function pessoa(){
        $pessoa = Pessoa::
                        where('NOME','like','%Ari Aparecido%')
//                        where('CPF','=','01047358301')
//                        where('CPF','=','79273270115')
                        ->with('usuarios')
                        ->with('servidor')
                        ->first();
        
        dd($pessoa);
        $date1 = \Carbon\Carbon::createFromFormat('Y-m-d', '1999-01-01');        
        $dataExpiracao = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($pessoa->usuarios[0]->DTEXPIRA)));
        $datahoje = \Carbon\Carbon::now();
        $value = $datahoje->between($datahoje, $dataExpiracao);
        
    }
    public function searchPessoaByCpf($cpf){
        $pessoa = \DB::connection('sqlsrv')->table('dbo.ger_pessoa')
                        ->join('dbo.mod_servidor','dbo.ger_pessoa.IDENTIFICADOR','=','dbo.mod_servidor.IDENTIFICADOR')
                        ->join('dbo.esc_unidade','dbo.mod_servidor.CDESCMEC','=','dbo.esc_unidade.CDESCMEC')
                          ->select('dbo.ger_pessoa.NOME as NOME',
                                'dbo.ger_pessoa.CPF as CPF',
                                'dbo.ger_pessoa.IDENTIFICADOR as IDENTIFICADOR',
                                'dbo.esc_unidade.CDESCMEC as CDESCMEC',
                                'dbo.esc_unidade.DCESC as DCESC')
                        ->where('cpf','=',$cpf)
                        ->get();
        return $pessoa;
    }
    
    public function searchUsuarioByCpf(Request $request){
        $msg = "";
        $alertType = "";
        $dataForm = $request->except('_token');
        $pessoa = Pessoa::where('cpf','=',$dataForm['cpfDaPessoa'])
                ->with('usuarios')
                ->first();
        
        if(count($pessoa) == 0){
            $msg = "CPF ".$dataForm['cpfDaPessoa']." não existe em nossa base de dados.";
            $alertType = "alert-danger";
            return view('buscarUsuarios',  compact('title','msg','alertType'));
        }else if(count($pessoa->usuarios) == 0){
            $msg = "Não existe Usuário para essa pessoa";
            $alertType = "alert-warning";
            return view('buscarUsuarios',  compact('title','msg','alertType'));
        }
        else{
            $msg = "Usuário ".$pessoa->NOME." encontrado com sucesso.";
            $alertType = "alert-success";
            $pessoa = $pessoa;
            return view('buscarUsuarios',  compact('title','msg','alertType','pessoa'));
        }
    }
    
    public function servidor(){
        $servidor = \App\Models\Servidor::limit(6)
                        ->get();
        dd($servidor);
    }
    public function buscarUsuarios(){
        $title = "Buscar Usuários";
        $alertType = "";
        return view('buscarUsuarios',  compact('title','msg','alertType'));
    }
    public function buscarPessoa(){
        $title = "Buscar Pessoa";
        return view('buscarPessoa',  compact('title','msg','alertType'));
    }
    public function verificarCpfPessoa(Request $request){
        $dataForm = $request->except('_token');
        $title = "";
        $msg = "";
        $alertType = "";
        $pessoa = Pessoa::where('CPF','=',$dataForm['cpfDaPessoa'])
                ->with('usuarios')
                ->with('servidor')
                ->first();
        
        foreach($pessoa->servidor as $serv){
            $dataBloqueio;
            $datahoje = \Carbon\Carbon::now()->isPast();
            if($serv->DTRESCISAO != null ){
                $dataBloqueio = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($serv->DTRESCISAO)));
                $msg = "Servidor do CPF (".$dataForm['cpfDaPessoa'].") foi Recindido.";
            }else if($serv->DTAFASTAMENTO != null){
                $dataBloqueio = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($serv->DTAFASTAMENTO)));
                $msg = "Servidor do CPF (".$dataForm['cpfDaPessoa'].") foi afastado.";
            }else{
                $dataBloqueio = \Carbon\Carbon::now()->subDay(-1);
            }
            
            if($dataBloqueio->isPast()){
//              
            }else{
//                echo "Matricula: ".$serv->MATRICULA." liberada!<br>";       
                if(count($pessoa) == 0){
                    $title = "Buscar Pessoa";
                    $alertType = "alert-danger";
                    $msg = "Não há pessoa registrada com o CPF ".$dataForm['cpfDaPessoa'].")";
                    return view('buscarPessoa',  compact('unidades','grupos','title','msg','alertType'));
                }else if(count($pessoa->usuarios) == 0){
                    $title = "Cadastrar";
                    $msg = "";
                    $unidades = \DB::connection('sqlsrv')->table('dbo.esc_unidade')
                                ->where('FLATIVA','=',1)
                                ->get();

                    $grupos = Grupo::all();
                    return view('cadastrar',  compact('unidades','pessoa','grupos','title','msg'));
                }else{
                    $title = "Buscar Pessoa";
                    $alertType = "alert-warning";
                    $msg = "Já existe Usuário para esse CPF ".$dataForm['cpfDaPessoa'].".";
                    return view('buscarPessoa',  compact('unidades','grupos','title','msg','alertType'));
                }
                
            } 
        }
        $title = "Buscar Pessoa";
        $alertType = "alert-danger";
        return view('buscarPessoa',  compact('unidades','grupos','title','msg','alertType'));
    }
    public function verificarNomePessoa(Request $request){
        $dataForm = $request->except('_token');
        $title = "";
        $alertType = "";
        
        $pessoas = Pessoa::where('NOME','LIKE',"%".$dataForm['nome']."%")
                ->where('CPF','<>',"")
                ->with('servidor')
//                ->get();
                ->paginate(20);
//        dd($pessoas);
        if(count($pessoas) == 0){
            $title = "Buscar Pessoa";
            $alertType = "alert-danger";
            $msg = "Não há pessoa registrada com o nome ".$dataForm['nome'];
            return view('buscarPessoa',  compact('unidades','grupos','title','msg','alertType'));
        
        }else{
            $title = "Buscar Pessoa";
            return view('buscarPessoa',  compact('unidades','grupos','title','msg','alertType','pessoas'));
        }
    }

    public function getUserByCPF($cpf){
        $usuario = \DB::connection('sqlsrv')->table('dbo.ger_pessoa')
                        ->join('dbo.seg_usuario','dbo.ger_pessoa.IDENTIFICADOR','=','dbo.seg_usuario.IDENTIFICADOR')
                        ->join('dbo.esc_unidade','dbo.seg_usuario.CDESCMEC','=','dbo.esc_unidade.CDESCMEC')
                        ->join('dbo.esc_tpunidade','dbo.esc_unidade.CDTPUNIDADE','=','dbo.esc_tpunidade.CDTPUNIDADE') 
                        ->select('dbo.seg_usuario.IDENTIFICADOR as IDENTIFICADOR',
                                'dbo.ger_pessoa.NOME as NOME',
                                'dbo.ger_pessoa.CPF as CPF',
                                'dbo.seg_usuario.LOGIN as LOGIN',
                                'dbo.seg_usuario.DTEXPIRA as DTEXPIRA',
                                'dbo.seg_usuario.EMAIL as EMAIL',
                                'dbo.esc_unidade.DCESC as DCESC')
                        ->where('CPF','=',$cpf)
                        ->get();
        return $usuario;
    }
    public function usuario(){
        $usuario    = Usuario::where('FLATIVO','=','1')
                        ->with('grupos')
                        ->where('LOGIN','=','01047358301')
                        ->get();
        
        $password = 123456;
        
        if(strtoupper(md5($password)) == $usuario[0]->SENHA){
            echo "Válida";
        }else{
            echo "Inválida";
        }
        dd($usuario);
    }
    public function usuario_grp($login){
        
        $usuario = UsuarioGRP::where('FLATIVO','=','1')
                        ->where('LOGIN','=',$login)
                        ->get();
        
        return $usuario;
    }
    public function acesso(){
        $acesso = \DB::connection('sqlsrv')->table('dbo.seg_acessousr')
                ->where('LOGIN','=','04424039927')
                        ->get();
        dd($acesso);
    }
    public function segProgramas(){
        $acesso = \DB::connection('sqlsrv')->table('dbo.seg_programas')
                ->where("CDPROGRAMA", "autorizarreqmaterial")
                        ->get();
        dd($acesso);
    }
    public function cadastrar(){
        $title = "Cadastro";
        $msg = "";
        
        $unidades = \DB::connection('sqlsrv')->table('dbo.esc_unidade')
                        ->where('FLATIVA','=',1)
                        ->get();
        $grupos = Grupo::all();
        
        return view('cadastrar',  compact('unidades','grupos','title','msg'));
    }
    public function gerenciarUsuario($login){
        $title = "Acessos do Usuário";
//        
        $usuario = Usuario::where('LOGIN','=',$login)
                ->first();
        
        $pessoa = Pessoa::where('IDENTIFICADOR','=',$usuario->IDENTIFICADOR)
                ->with('usuarios')
                ->with('unidades')
                ->first();
        
        $pessoa->grupos = UsuarioGRP::select('LOGIN','CDGRUPO')
                        ->where('LOGIN','=',$login)
                        ->get();
//        dd($pessoa->unidades);
        $unidades = Unidade::where('FLATIVA','=',1)
                        ->get();
        $grupos = Grupo::get();
        
        return view('gerenciar',  compact('unidades','grupos','title','pessoa','usuario'));
    }
    
    public function pesquisarUnidades($dcesc){
        $unidades = \DB::connection('sqlsrv')->table('dbo.esc_unidade')
                        ->select('CDTPUNIDADE','CDESCMEC','DCESC','FLATIVA')
                        ->where('FLATIVA','=',1)
                        ->where('CDTPUNIDADE','=',$dcesc)
                        ->orderBy('DCESC')
                        ->get();
        return $unidades;
    }
    public function store(Request $request)
    {
        $dataForm = $request->except('_token');
        $quantidade_grupos = count($dataForm['grupos']);
        
        
        $usuario = Usuario::create([
                            'LOGIN' => $dataForm['login'],
                            'loginad' => $dataForm['login'],
                            'CDESCMEC' => $dataForm['CDESCMEC'],
                            'IDENTIFICADOR' => $dataForm['identificador'],
                            'SENHA' => strtoupper(md5($dataForm['senha'])),
                            'DTEXPIRA' => date($this->dataFormat, strtotime($dataForm['data_expiracao'])),
                            'DTALTERACAO' => date($this->dataFormat, strtotime($dataForm['dtacesso_incl'])),
                            'ALTERASENHA' => $dataForm['alterasenha'],
                            'EMAIL' => $dataForm['email'],
                            'FLATIVO' => $dataForm['ativo'],
                            'cpfusuario_incl' => $dataForm['cpfusuario_altr'],
                            'dtacesso_incl' =>date($this->dataFormat, strtotime($dataForm['dtacesso_incl'])),
                            'cpfusuario_altr' => $dataForm['cpfusuario_altr'],
                            'dtacesso_altr' =>date($this->dataFormat, strtotime($dataForm['dtacesso_incl']))
        ]);
        $usuario->save();
        foreach($dataForm['grupos'] as $grupo){
            
            $usuario->grupos()->attach($grupo,
                                    [
                                        'esc_unidade_cdescmec' => $dataForm['CDESCMEC'],
                                        'flativo' => $dataForm['ativo'],
                                        'usuarioincl' => $dataForm['cpfusuario_altr'],
                                        'datahoraincl' => date($this->dataFormat, strtotime($dataForm['dtacesso_incl'])),
                                        'usuarioaltr' => $dataForm['cpfusuario_altr'],
                                        'datahoraaltr' => date($this->dataFormat, strtotime($dataForm['dtacesso_incl']))
                                    ]
                    );
        }
        $title = "Buscar Pessoa";
        $msg = "Usuário: ".$dataForm['login']." cadastrado com sucesso!";
        $alertType = "alert-success";
        $unidades = \DB::connection('sqlsrv')->table('dbo.esc_unidade')
                        ->where('FLATIVA','=',1)->get();
        $grupos = \DB::connection('sqlsrv')->table('dbo.seg_grupo')->get();
        
        return view('buscarPessoa',  compact('unidades','grupos','title','msg','alertType'));
    }
    public function alterarUsuario(Request $request)
    {
        $dataForm = $request->except('_token');
        
        $loginUsuario =  $dataForm['gerenciarLogin'];
        $grupos = $dataForm['grupos'];
        $pessoa = Pessoa::find($dataForm['identificador']);
        $pessoa->NOME = $dataForm['nome'];
        $pessoa->save();
        
        $usuario = Usuario::find($loginUsuario);
        $usuario->loginad = $dataForm['cpfusuario'];
        $usuario->LOGIN = $dataForm['gerenciarLogin'];
        $usuario->EMAIL = $dataForm['email'];
//        $usuario->DTEXPIRA = date('Y-m-d h:m:s', strtotime($dataForm['data_expiracao']));
        $usuario->DTEXPIRA = date($this->dataFormat, strtotime($dataForm['data_expiracao']));
        $usuario->FLATIVO = $dataForm['ativo'];
        $usuario->dtacesso_altr = date($this->dataFormat, strtotime($dataForm['dtalteracao']));
        if($dataForm['senha'] != null){
            $usuario->SENHA = strtoupper(md5($dataForm['senha']));
        }
        $usuario->save();
                
        $pivotData = array_fill(0, count($grupos), [
                                    'esc_unidade_cdescmec' => $dataForm['CDESCMEC'],
                                    'flativo' => $dataForm['ativo'],
                                    'usuarioincl' => $dataForm['cpfusuario_altr'],
                                    'datahoraincl' => date($this->dataFormat, strtotime($dataForm['dtalteracao'])),
                                    'usuarioaltr' => $dataForm['cpfusuario_altr'],
                                    'datahoraaltr' => date($this->dataFormat, strtotime($dataForm['dtalteracao']))
            
                                ]);
        $syncData  = array_combine($grupos, $pivotData);
        $usuario->grupos()->sync($syncData);
        
        $msg = "Usuário de LOGIN ".$usuario->LOGIN." alterado com sucesso.";
        $alertType = "alert-success";
        return view('buscarUsuarios',  compact('title','msg','alertType'));
    }
    public function deletarUsuario($login){
        $usuario = Usuario::find($login);
        $usuario->grupos()->detach();
        $usuario->delete();
        $alertType = "";
        $msg = "Usuário do login: ".$login." foi deletado!";
        return view('buscarUsuarios',  compact('title','msg','alertType'));
    }
    public function edit(){
        $alertType = "";
        return view('auth.edit',compact('alertType'));
    }
    public function editUser(Request $request)
    {
        $dataForm = $request->except('_token');
        $alertType = "";
        if($dataForm['password'] == ''){
            return view('auth.edit',compact('alertType'));
        }else if($dataForm['password'] != $dataForm['password_confirmation']){
            $msg = "As senhas divergem!";
            $alertType = "alert-danger";
            return view('auth.edit',compact('msg','alertType'));
        }else{
            $usuario = \App\User::where('cpf','=',$dataForm['cpf'])->first();
            $usuario->name = $dataForm['name'];
            $usuario->email = $dataForm['email'];
            $usuario->cpf = $dataForm['cpf'];
            $usuario->password = bcrypt($dataForm['password']);
            $usuario->save();

            $msg = "Usuário alterado com sucesso!";
            return view('home',compact('msg'));
        }
    }
    
}
