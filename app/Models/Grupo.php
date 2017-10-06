<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = [
                            'CDGRUPO',
                            'DCGRUPO',
                            'NIVELACESSO',
                            'flativo',
                            'HABILITAGRUPO',
                            'SEG_grupo_fladministrador',
                            'SEG_sistemas_cdsistema'
                            ];


    protected $connection = 'sqlsrv';
    protected $table = 'seg_grupo';
    protected $primaryKey = 'CDGRUPO';
    public $incrementing = false;
    public $timestamps = false;
    public function usuarios()
    {
        return $this->belongsToMany('App\Models\Usuario','seg_usuariogrp','LOGIN','LOGIN')
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
