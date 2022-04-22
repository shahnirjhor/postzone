<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'facebook_user_id',
        'page_id',
        'page_cover',
        'page_profile',
        'page_name',
        'username',
        'page_access_token',
        'page_email',
        'msg_manager',
        'bot_enabled',
        'started_button_enabled',
        'welcome_message',
        'persistent_enabled',
        'enable_mark_seen',
        'enbale_type_on'
    ];

    public function facebookUser()
    {
        return $this->belongsTo(FacebookUser::class);
    }
}
