<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'type',
        'new_client',
    ];
    protected $casts = [
        'new_client' => 'boolean',
    ];
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
