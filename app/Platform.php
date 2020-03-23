<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $guarded = [];

    public function format()
    {
        return [
            'platform_id' => $this->id,
            'name' => $this->name,
            'url' => $this->url
        ];
    }
}
