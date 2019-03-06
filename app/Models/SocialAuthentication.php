<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAuthentication extends Model {
    protected $fillable = ['provider', 'provider_id', 'access_token', 'user_id', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
