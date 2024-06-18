<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'UserName', 'email', 'password', 'UserPhoneNumber', 'UserPoint', 'RoleId', 'SubjectId', 'UserRankId', 'IsValid'
    ];

    protected $hidden = ['password'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::uuid4();
        });
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
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
