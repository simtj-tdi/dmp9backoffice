<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Parsedown;

class Order extends Model
{
    CONST STATE_1 = 0;      // 결제전
    CONST STATE_2 = 1;      // 결제완료

    CONST TAX_STATE_1 = 1;  // 계산서 요청가능 (미발행)
    CONST TAX_STATE_2 = 2;  // 계산서 요청신청 (확인중)
    CONST TAX_STATE_3 = 3;  // 계산서 신청완료 (발행)

    protected $guarded = ['*','id'];

    public function format()
    {
        return [
            'order_id' => $this->id,
            'user_id' => $this->user,
            'payment_id' => $this->payment_returns,
            'order_no' => $this->order_no,
            'order_name' => $this->order_name,
            'goods_info' => $this->goods_info,
            'state' => $this->state,
            'tax_state' => $this->tax_state,
            'total_count' => $this->total_count,
            'total_price' => $this->total_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment_returns()
    {
        return $this->belongsTo(Payment_return::class, 'payment_id');
    }

    public function getContentHtmlAttribute()
    {
        return Parsedown::instance()->text($this->data_content);
    }

    public function getMarkPriceAttribute()
    {
        return number_format($this->buy_price);
    }
}
