<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
    'nomor_dokumen',
    'judul',
    'tujuan',
    'file',
    'status',
    'uploaded_by',
    ];

   public function user()
    {
        return $this->belongsTo(
        User::class, 'uploaded_by'
        );
    }
}

