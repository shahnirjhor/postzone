<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'config_id',
        'access_token',
        'name',
        'email',
        'facebook_id',
        'need_to_delete'
    ];

    public function facebookApp()
    {
        return $this->belongsTo(FacebookApp::class);
    }

    public function facebookPages()
    {
        return $this->hasMany(FacebookPage::class);
    }

    public function facebookGroups()
    {
        return $this->hasMany(FacebookGroup::class);
    }
}
