<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Trmentoringschedule extends Model
{
    use HasFactory;

    protected $table = 'trmentoringschedule';
    protected $primaryKey = 'TrMentoringScheduleId';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'TrMentoringScheduleId',
        'MeetingTime',
        'MeetingLink',
        'SubjectId',
        'SpecificTopic',
        'MenteeUserId',
        'MentorUserId',
        'UniqueCode'
    ];

    public static function boot()
     {
         parent::boot();

         self::creating(function ($model) {
             $model->{$model->getKeyName()} = (string) Uuid::uuid4();
         });
     }

    public function mentee()
    {
        return $this->belongsTo(User::class, 'MenteeUserId', 'UserId');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'MentorUserId', 'UserId');
    }
}
