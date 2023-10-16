<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AddonModel extends Model
{
    protected $table = 'addon'; 
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'description',
        'price',
        'image',
        'deleted'
    ];
}