<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'title', 'content',
    ];

    protected $guarded = [];

    public function format()
    {
        return [
            'faq_id' => $this->id,
            'name' => $this->user->name,
            'title' => $this->title,
            'content' => $this->content,
            'email' => $this->user->email,
            'last_update' => $this->updated_at->diffForHumans()
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
