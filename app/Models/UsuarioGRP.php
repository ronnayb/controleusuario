<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioGRP extends Model
{
    protected $fillable = [
                            'LOGIN',
                            'CDGRUPO',
                            'esc_unidade_cdescmec',
                            'flativo',
                            'usuarioincl',
                            'datahoraincl',
                            'usuarioaltr',
                            'datahoraaltr'
                            ];
    
    protected $connection = 'sqlsrv';
    protected $table = 'seg_usuariogrp';
    public $incrementing = false;
    public $timestamps = false;
}
