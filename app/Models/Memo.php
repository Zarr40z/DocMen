<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    protected $fillable = [

        'sender_id',
        'receiver_id',
        'target_role',
        'send_to_all',
        'title',
        'message',
        'file',

    ];
    public function sender()
    {
        return $this->belongsTo(
            User::class,
            'sender_id'
        );
    }

    public function receiver()
    {
        return $this->belongsTo(
            User::class,
            'receiver_id'
        );
    }
}