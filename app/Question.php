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
            'id' => $this->user->user_id,
            'name' => $this->name,
            'title' => $this->title,
            'content' => $this->content,
            'phone' => $this->phone,
            'email' => $this->email,
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
