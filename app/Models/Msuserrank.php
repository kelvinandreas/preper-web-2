<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Msuserrank extends Model
{
    use HasFactory;

    protected $table = 'msuserrank';
    protected $primaryKey = 'UserRankId';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'UserRankId',
        'UserRankName'
    ];
}
