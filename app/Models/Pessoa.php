<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'ger_pessoa';
    protected $primaryKey = 'IDENTIFICADOR';
    public $incrementing = false;
    public $timestamps = false;
    
    public function usuarios(){
        return $this->hasMany(Usuario::class,'IDENTIFICADOR');
    }
    public function unidades(){
        return $this->belongsToMany(Unidade::class, 'mod_servidor','IDENTIFICADOR','CDESCMEC')
                ->withPivot('DTRESCISAO','MATRICULA','DTAFASTAMENTO');
    }
    public function Servidor(){
        return $this->hasMany(Servidor::class,'IDENTIFICADOR');
    }
}
