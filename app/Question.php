<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'title', 'content',
    ];

    protected $guarded = [];

    public function format()
    {
        return [
            'question_id' => $this->id,
            'name' => $this->user->name,
            'title' => $this->title,
            'content' => $this->content,
            'email' => $this->user->email,
            'last_update' => $this->updated_at->diffForHumans(),
            'answers' => $this->answers,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
