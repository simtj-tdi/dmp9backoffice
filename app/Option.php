<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $appends = ['new_date'];
    protected $guarded = [];

    CONST STATE_1 = 1;      // 업로드 요청
    CONST STATE_2 = 2;      // 업로드 요청
    CONST STATE_3 = 3;      // 업로드 완료

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
