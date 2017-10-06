<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'mod_servidor';
    protected $primaryKey = 'IDENTIFICADOR';
    public $incrementing = false;
    public $timestamps = false;
}
