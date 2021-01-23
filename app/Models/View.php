<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $table = 'views';
    public $timestamps = true;

    protected $fillable = ['name','view_count'];


    public function viewable()
    {
        return $this->morphTo();
    }

}