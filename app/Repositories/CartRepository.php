<?php


namespace App\Repositories;


use App\Cart;

class CartRepository implements CartRepositoryInterface
{
    public function updateState($request, $id)
    {
        cart::where('goods_id', $id)->update($request->only('state'));
    }

}
