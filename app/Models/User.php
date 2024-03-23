<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Make id to be not increment.
     */
    public $incrementing = false;

    /**
     * Set uuid field as primary key.
     */
    protected $primaryKey = 'uuid';

    /**
     * Set primary key type to string.
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'gender',
        'name',
        'location',
        'age'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => 'json',
        'location' => 'json'
    ];

    protected $appends = [
        'full_name'
    ];

    public function getFullNameAttribute()
    {
        $title = $this->name['title'] ?? '';
        $firstName = $this->name['first'] ?? '';
        $lastName = $this->name['last'] ?? '';
        $fullName = $title . '. ' . $firstName . ' ' . $lastName;
 
        return $fullName;
    }
}
