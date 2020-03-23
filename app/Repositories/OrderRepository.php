<?php

namespace App\Repositories;

use App\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function all()
    {
        $orders = order::orderBy('id', 'desc')
            ->paginate(5);

        $orders->getCollection()->map->format();;

        return $orders;
    }

    public function taxstateChange($request)
    {
        return order::where('id', $request->order_id)->update(['tax_state'=>$request->tax_state]);
    }


}
