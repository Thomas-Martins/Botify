<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class BotConnection extends Model
{
    use HasUuids;

    // Définir les champs que vous souhaitez pouvoir assigner massivement
    protected $fillable = [
        'guild_id', 'user_id', 'guild_name', 'guild_icon',
    ];

    protected $hidden = [
        'access_token'
    ];
}
