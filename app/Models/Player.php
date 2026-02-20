<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends User
{
    protected $table = 'users';

    public function notes(): HasMany
    {
        return $this->hasMany(PlayerNote::class, 'player_id');
    }
}
