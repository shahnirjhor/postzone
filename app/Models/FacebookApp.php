<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookApp extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_name',
        'api_id',
        'api_secret',
        'numeric_id',
        'user_access_token',
        'status',
        'developer_access',
        'facebook_id',
        'secret_code',
        'user_id',
        'use_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function facebookUsers()
    {
        return $this->hasMany(FacebookApp::class);
    }
}
