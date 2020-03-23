<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $guarded = [];

    CONST STATE_1 = 1;      // 요청중
    CONST STATE_2 = 2;      // 업로드중
    CONST STATE_3 = 3;      // 업로드완료

    public function format()
    {
        return [
            'option_id' => $this->id,
            'user' => $this->user,
            'cart' => $this->cart->goods,
            'platform' => $this->platform,
            'sns_id' => $this->sns_id,
            'sns_password' => $this->sns_password,
            'state' => $this->state
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

}
