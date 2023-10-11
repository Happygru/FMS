<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AddonModel extends Model
{
    protected $table = 'addon';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'amount',
        'addtototal',
        'notes'
    ];
}