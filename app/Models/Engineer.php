<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Engineer extends Authenticatable
{

    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

}
