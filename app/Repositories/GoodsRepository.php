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

        $request_data['data_count'] = $request->data_count;
        $request_data['buy_price'] = $request->buy_price;
        $request_data['expiration_date'] = $request->expiration_date;

        if ($request->data_filess) {
            $request_data['data_files'] = $request->data_filess;
            $request_data['org_files'] = $request->org_files;
        }

        $goods = goods::where('id', $id)
            ->update($request_data);
        return $goods;
    }

    public function update1($request, $id)
    {
        $request_data['data_count'] = $request->data_count;
        $request_data['buy_price'] = $request->buy_price;
        $request_data['expiration_date'] = $request->expiration_date;

        $goods = goods::where('id', $id)
            ->update($request_data);
        return $goods;
    }

    public function update4($request, $id)
    {
        $request_data['data_files'] = $request->data_filess;
        $request_data['org_files'] = $request->org_files;

        $goods = goods::where('id', $id)
            ->update($request_data);
        return $goods;
    }
}
