<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $guarded = ['*','id'];

    public function format()
    {
        return [
            'goods_id' => $this->id,
            'advertiser' => $this->advertiser,
            'data_types' => $this->data_types,
            'data_target' => $this->data_target,
            'data_name' => $this->data_name,
            'data_category' => $this->data_category,
            'data_content' => $this->data_content,
            'data_count' => $this->data_count,
            'buy_price' => $this->buy_price,
            'expiration_date' => $this->expiration_date,
            'cart' => $this->cart,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'id');
    }

    public function getMarkPriceAttribute()
    {
        return number_format($this->buy_price);
    }
}
