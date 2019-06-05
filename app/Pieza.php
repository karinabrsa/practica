<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AjaxpiezaController;

class Pieza extends Model
{
    //
    protected $table = 'piezas';
    protected $fillable=['nombre'];
}
