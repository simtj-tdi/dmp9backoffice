<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = ['*','id'];

    CONST STATE_1 = 1;      // 요청중
    CONST STATE_2 = 2;      // 추출중
    CONST STATE_3 = 3;      // 승인요청
    CONST STATE_4 = 4;      // 결제완료

    public function format()
    {
        return [
            'cart_id' => $this->id,
            'user_id' => $this->user,
            'goods_id' => $this->goods,
            'order_id' => $this->order_id,
            'state' => $this->state,
            'buy_date' => $this->buy_date,
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
}
