<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DocumentLog extends Model
{
    protected $fillable = [
        'document_id',
        'user_id',
        'activity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}