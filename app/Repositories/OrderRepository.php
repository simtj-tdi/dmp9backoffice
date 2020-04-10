<?php

namespace App\Repositories;

use App\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function all($request)
    {

        $orders = order::where('state', 1)
            ->whereNotNull('payment_id')
            ->wherehas('carts', function ($query)  {
                $query->where('state','>=', 3);
            })
            ->when($request->sch_key,
                function ($q) use ($request) {
                    if ($request->sch) {
                        return $q->where($request->sch_key, 'LIKE', '%' . $request->sch . '%');
                    } else if ($request->sch1) {
                        return $q->where($request->sch_key, '>=', $request->sch1." 00:00:00")->where($request->sch_key, '<=', $request->sch2." 23:59:59");
                    }
                }
            )
            ->orderBy('id', 'desc')
            ->paginate(10);

        $orders->getCollection()->map->format();;

        return $orders;
    }

    public function taxstateChange($request)
    {
        return order::where('id', $request->order_id)->update(['tax_state'=>$request->tax_state]);
    }

}
