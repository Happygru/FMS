<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContactsModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'phone', 'account_id', 'job'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public function corporate() {
        return $this->belongsTo('App\Model\CorporatesModel', 'account_id');
    }
}