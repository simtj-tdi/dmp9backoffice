<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'question_id', 'user_id', 'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
