<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','approved', 'approved_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function format()
    {
        return [
            'user_id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'content' => $this->content,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'approved' => $this->approved,
            'tax' => $this->taxes,
            'approved_at' => $this->approved_at,
            'last_update' => $this->updated_at->diffForHumans()
        ];
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }

    public function taxes()
    {
        return $this->hasMany(Tax::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('id','desc');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('id','desc');
    }
}
