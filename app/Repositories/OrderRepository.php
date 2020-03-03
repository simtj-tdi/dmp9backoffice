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
        // TODO: Implement findById() method.
    }

    public function create($request)
    {
        // TODO: Implement create() method.
    }

    public function update($request, $id)
    {
        // TODO: Implement update() method.
    }

    public function destory($id)
    {
        // TODO: Implement destory() method.
    }

}
