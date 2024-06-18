<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trmentoringschedule extends Model
{
    use HasFactory;

    protected $table = 'trmentoringschedule';
    protected $primaryKey = 'TrMentoringScheduleId';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'TrMentoringScheduleId',
        'MentoringSession',
        'MenteeUserId',
        'MentorUserId',
        'UniqueCode'
    ];

    public function mentee()
    {
        return $this->belongsTo(User::class, 'MenteeUserId', 'UserId');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'MentorUserId', 'UserId');
    }
}
