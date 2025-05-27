<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scan extends Model
{
    use HasFactory;

    protected $primaryKey = 'scan_id';

    protected $fillable = [
        'user_id', 'scan_title', 'scan_type', 'scan_result', 'full_report',
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'user_id');
}
}
