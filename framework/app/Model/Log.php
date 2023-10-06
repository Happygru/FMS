<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Log extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'method', 'url', 'action', 'ipaddress'
    ];

    public static function activity($request, $action)
    {
        // obtain authenticated user's id
        $userId = Auth::id();
        
        // create log
        static::create([
            'user_id' => $userId,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'action' => $action,
            'ipaddress' => $_SERVER['REMOTE_ADDR']
        ]);
    }
}