<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;



class ReligiousBenefits extends Model 
{

    use Sluggable, SearchableTrait;

    protected $table = 'religiousBenefits';
    public $timestamps = true;

    protected $fillable = ['name' , 'category_id' , 'content' ,  'publish_date' , 'status' ,'view_count','keywords','description'];


    public function sluggable(): array
    {
        return [
            'slug'=> [
                'source'=>'name'
            ]
            ];
    }
    
    protected $searchable = [
        
        'columns' => [
            'religiousBenefits.name'    => 10,
            'religiousBenefits.content' => 10,
            
        ]
    ];

    
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    

}