<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'facebook_user_id',
        'group_id',
        'group_cover',
        'group_profile',
        'group_name',
        'group_access_token'
    ];

    public function facebookUser()
    {
        return $this->belongsTo(FacebookUser::class);
    }
}
