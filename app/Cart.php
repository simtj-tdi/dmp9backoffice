<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = ['*','id'];

    CONST STATE_1 = 1;      // 확인중
    CONST STATE_2 = 2;      // 결제 대기중
    CONST STATE_3 = 3;      // 결제 완료
    CONST STATE_4 = 4;      // 데이터 추출중
    CONST STATE_5 = 5;      // 데이터 완료

    public function format()
    {
        return [
            'cart_id' => $this->id,
            'user_id' => $this->user,
            'goods_id' => $this->goods,
            'order_id' => $this->order_id,
            'state' => $this->state,
            'buy_date' => $this->buy_date,
            'memo' => $this->memo,
            'options_id' => $this->options,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class)->orderBy('id','desc');
    }

    public function getMarkPriceAttribute()
    {
        return number_format($this->goods->buy_price);
    }
}
