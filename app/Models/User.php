<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract, JWTSubject
{
    use Authenticatable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_temporary_password',
        'is_admin',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'initials',
        'short_name',
    ];

    public function getInitialsAttribute()
    {
        $names = explode(' ', trim($this->name));

        if (count($names) === 1) {
            return strtoupper(substr($names[0], 0, 1));
        }

        $firstInitial = strtoupper(substr($names[0], 0, 1));
        $lastInitial = strtoupper(substr(end($names), 0, 1));

        return $firstInitial . $lastInitial;
    }

    public function getShortNameAttribute()
    {
        $names = explode(' ', trim($this->name));

        if (count($names) === 1) {
            return $names[0];
        }

        return $names[0] . ' ' . end($names);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'id' => $this->id,
        ];
    }
}
