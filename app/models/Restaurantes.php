<?php

namespace Models;

use \Illuminate\Database\Eloquent\Model;

class Restaurantes extends Model
{
    protected $table = "restaurante";
    protected $fillable = ['nombre', 'descripcion'];
    public $timestamps=false;
}
