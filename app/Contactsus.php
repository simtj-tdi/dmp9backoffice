<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactsus extends Model
{
    protected $guarded = [];

    public function format()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'content' => $this->content
        ];
    }
}
