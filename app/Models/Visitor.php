<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table = 'visitors';
    public $timestamps = true;

    protected $fillable = ['visitor_count'];

}