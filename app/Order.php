<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Parsedown;

class Order extends Model
{
    CONST STATE_1 = 1;      // 요청중
    CONST STATE_2 = 2;      // 추출중
    CONST STATE_3 = 3;      // 승인요청
    CONST STATE_4 = 4;      // 결제완료

    protected $guarded = ['*','id'];

    public function format()
    {
        return [
            'advertiser'=> $this->advertiser,
            'order_id' => $this->id,
            'user_id' => $this->user_id,
            'payment_id' => $this->payment_id,
            'order_no' => $this->order_no,
            'state' => $this->state,
            'data_types' => $this->data_types,
            'data_category' => $this->data_category,
            'data_content' => $this->data_content,
            'data_name' => $this->data_name,
            'data_count' => $this->data_count,
            'buy_price' => $this->buy_price,
            'buy_date' => $this->buy_date,
            'expiration_date' => $this->expiration_date,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getContentHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->data_content);
    }

    public function getMarkPriceAttribute()
    {
        return number_format($this->buy_price);
    }
}
