<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $appends = ['new_date'];

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

    public function getNewDateAttribute()
    {
        $REG_DATE = strtotime($this->updated_at);
        $REG_TIME = time();
        $TIME = 60*60*24;

        if ( ($REG_TIME-$REG_DATE) < $TIME ) {
            $new="1";
        }else{
            $new="";
        }

        return $new;
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
