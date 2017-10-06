<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/','Controller@index')->name('home');
    Route::get('/unidades', 'Controller@unidades')->name('unidades');
    Route::get('/tpunidades', 'Controller@tpunidades')->name('tpunidades');
    Route::get('/grupos', 'Controller@grupos')->name('grupos');
    Route::get('/pessoa', 'Controller@pessoa')->name('pessoa');
    
    Route::get('/searchpessoabycpf/{cpf}', 'Controller@searchPessoaByCpf')->name('searchpessoabycpf');
    Route::post('/searchusuariobycpf', 'Controller@searchUsuarioByCpf')->name('searchusuariobycpf');
    
    Route::get('/servidor', 'Controller@servidor')->name('servidor');
    
    Route::get('/cadastrar', 'Controller@cadastrar')->name('cadastrar');
    Route::get('/gerenciar/{login}', 'Controller@gerenciarUsuario')->name('gerenciar');
    Route::get('/buscarUsuarios', 'Controller@buscarUsuarios')->name('buscarusuarios');
    Route::get('/buscarPessoa', 'Controller@buscarPessoa')->name('buscarpessoa');
    Route::post('/verificarCpfPessoa', 'Controller@verificarCpfPessoa')->name('verificarcpfpessoa');
    Route::any('/verificarNomePessoa', 'Controller@verificarNomePessoa')->name('verificarnomepessoa');
    Route::get('/deletarUsuario/{login}', 'Controller@deletarUsuario')->name('deletarusuario');
    Route::get('/getUserByCPF/{cpf}', 'Controller@getUserByCPF')->name('getuserbycpf');
    Route::get('/grupos', 'Controller@grupos')->name('grupos');
    
    Route::get('/usuario', 'Controller@usuario')->name('usuario');
    Route::get('/usuario_grp/{login}', 'Controller@usuario_grp')->name('usuario_grp');
    Route::get('/acesso', 'Controller@acesso')->name('acesso');
    Route::get('/segprogramas', 'Controller@segProgramas')->name('segprogramas');
    Route::get('/pesquisarunidades/{dcesc}', 'Controller@pesquisarUnidades')->name('pesquisarunidades');

    Route::post('/salvar', 'Controller@store')->name('salvar');
    Route::post('/alteraUsuario', 'Controller@alterarUsuario')->name('altera_usuario');
    
    Route::get('/edit','Controller@edit')->name('edit');
    Route::post('/edituser','Controller@editUser')->name('edituser');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
