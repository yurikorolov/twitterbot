<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'consumer_key',
        'consumer_secret',
        'access_token',
        'access_secret',
        'timezone',
        'bot_power',
        'chat_power',
        'archive_power',
        'schedule_power',
        'onfollow_power',
        'stop_registration',
        'logo'
    ];
}
