<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'esc_unidade';
    protected $primaryKey = 'CDESCMEC';
    public $incrementing = false;
    public $timestamps = false;
}
