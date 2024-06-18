<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'UserName',
        'email',
        'password',
        'UserPhoneNumber',
        'UserPoint',
        'RoleId',
        'SubjectId',
        'UserRankId',
        'IsValid'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Boot function from Laravel.
     */
    public static function boot()
    {
        parent::boot();

        // Automatically generate a UUID for the ID if not already set
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Uuid::uuid4();
            }
        });
    }

    public function role()
    {
        return $this->belongsTo(Msrole::class, 'RoleId', 'RoleId');
    }

    public function subject()
    {
        return $this->belongsTo(Mssubject::class, 'SubjectId', 'SubjectId');
    }

    public function rank()
    {
        return $this->belongsTo(Msuserrank::class, 'UserRankId', 'UserRankId');
    }
}
