<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "messages";
    protected $fillable = ['from_user', 'to_user', 'content', 'read_at'];

    public function fromUser()
    {
        return $this->hasOne("App\Model\User", "id", "from_user")->withTrashed();
    }

    public function toUser()
    {
        return $this->hasOne("App\Model\User", "id", "to_user")->withTrashed();
    }

}
