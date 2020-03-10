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

    public function findById($id)
    {
        return order::where('id', $id)
            ->firstOrFail()
            ->format();
    }

    public function create($request)
    {
        auth()->user()->faqs()->create($request);
    }

    public function update($request, $id)
    {
        $order = order::where('id', $id)->firstOrFail();
        $order->update($request->only('state', 'data_count', 'buy_price', 'expiration_date'));
    }

    public function destory($id)
    {
        order::where('id', $id)->delete();
    }

}
