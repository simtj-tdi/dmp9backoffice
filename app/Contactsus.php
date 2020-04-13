<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactsus extends Model
{
    protected $appends = ['new_date'];

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
}
