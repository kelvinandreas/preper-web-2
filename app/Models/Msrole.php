<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Msrole extends Model
{
    use HasFactory;

    protected $table = 'msrole';
    protected $primaryKey = 'RoleId';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'RoleId',
        'RoleName'
    ];
}

