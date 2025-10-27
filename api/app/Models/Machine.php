<?php

namespace App\Models;

use App\Models\User;
use App\Policies\MachinePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

#[UsePolicy(MachinePolicy::class)]
class Machine extends Model
{

    protected $fillable = [
        'name',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function users(){
        return $this->belongsToMany(User::class)
            ->withPivot('access_level')
            ->withTimestamps();
    }

    // scope to get only machines accessible by a given user
    public function scopeAccessibleBy($query, User $user){
        return $query->whereHas('users', fn($q) => $q->where('user_id', $user->id));
    }
}
