<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    protected $table    = "uf_estado";
    protected $fillable = ['uf', 'estado'];
}