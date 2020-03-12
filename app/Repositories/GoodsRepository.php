<?php


namespace App\Repositories;


use App\Goods;

class GoodsRepository implements GoodsRepositoryInterface
{
    public function all()
    {
        $goods = goods::orderBy('id', 'desc')
            ->paginate(5);

        $goods->getCollection()->map->format();;

        return $goods;
    }

    public function findById($id)
    {
        return goods::where('id', $id)
            ->firstOrFail()
            ->format();
    }

    public function update($request, $id)
    {
        $goods = goods::where('id', $id)
            ->firstOrFail();
        $goods->update($request->only('data_count', 'buy_price', 'expiration_date'));
    }

}
