<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
     protected $fillable = [
                            'LOGIN',
                            'loginad',
                            'CDESCMEC',
                            'IDENTIFICADOR',
                            'SENHA',
                            'DTEXPIRA',
                            'DTALTERACAO',
                            'ALTERASENHA',
                            'EMAIL',
                            'FLATIVO',
                            'cpfusuario_incl',
                            'dtacesso_incl',
                            'cpfusuario_altr',
                            'dtacesso_altr'
         ];
    
    protected $connection = 'sqlsrv';
    protected $table = 'seg_usuario';
    protected $primaryKey = 'LOGIN';
    public $incrementing = false;
    public $timestamps = false;
    
    public function grupos()
    {
        return $this->belongsToMany('App\Models\Grupo','seg_usuariogrp','LOGIN','CDGRUPO')
                        ->withPivot(
                                'esc_unidade_cdescmec',
                                'flativo',
                                'usuarioincl',
                                'datahoraincl',
                                'usuarioaltr',
                                'datahoraaltr'
                                );
    }
}
