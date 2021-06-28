<?php

namespace Models;

use \Illuminate\Database\Eloquent\Model;

class Comida extends Model
{
    protected $table = "comida";
    protected $fillable = ['nombre'];
    public $timestamps=false;
}
