<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function format()
    {
        return [
            'order_id' => $this->id,
            'user_id' => $this->user_id,
            'payment_id' => $this->payment_id,
            'order_no' => $this->order_no,
            'state' => $this->state,
            'types' => $this->types,
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
}
