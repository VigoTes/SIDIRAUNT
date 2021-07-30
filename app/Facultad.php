<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    protected $table = "facultad";
    protected $primaryKey = "codFacultad";
    public $timestamps = false; 


    protected $fillable = [
       'nombre'
    ];
}
