<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // If you want to allow mass assignment on certain fields
    protected $fillable = [
        'scan_id',
        'user_id',
        'comment',
        'created_at',
    ];

    public $timestamps = false;

    // Relationships
    public function scan()
    {
        return $this->belongsTo(Scan::class, 'scan_id', 'scan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
