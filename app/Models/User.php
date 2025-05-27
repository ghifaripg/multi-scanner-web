<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // If your primary key is not 'id', you should explicitly define it
    protected $primaryKey = 'user_id';

    // If the primary key is auto-incrementing and not 'id'
    public $incrementing = true;

    // Define the key type
    protected $keyType = 'int';

    // Fields that can be mass assigned
    protected $fillable = [
        'email',
        'password',
    ];

    // Hidden fields for arrays (e.g., when returning JSON)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Enable automatic timestamps
    public $timestamps = true;

    // If your table name is not the plural of the model name
    protected $table = 'users';

    public function scans()
{
    return $this->hasMany(Scan::class, 'user_id', 'user_id');
}
}
