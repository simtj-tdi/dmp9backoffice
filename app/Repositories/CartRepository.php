<?php


namespace App\Repositories;


use App\Cart;
use App\Option;

class cartrepository implements cartrepositoryinterface
{
    public function all($request)
    {
        $carts = cart::orderby('id','desc')
            ->wherehas('goods', function ($query) use ($request) {
                $query->where('data_name','LIKE','%'.$request->sch.'%');
            })
            ->paginate(10);

        $carts->getcollection()->map->format();

        return $carts;
    }

    public function cart_state_1($request)
    {
        $cart_state = cart::STATE_1;

        $carts = cart::when($cart_state,
                function ($q) use ($cart_state) {
                    return $q->where('state', $cart_state);
                }
            )
            ->wherehas('goods', function ($query) use ($request) {
                $query->where('data_name','LIKE','%'.$request->sch.'%');
            })
            ->orderby('id','desc')
            ->paginate(5);

        $carts->getcollection()->map->format();

        return $carts;
    }

    public function cart_state_2($request)
    {
        $cart_state = cart::STATE_2;

        $carts = cart::when($cart_state,
                function ($q) use ($cart_state) {
                    return $q->where('state', $cart_state);
                }
            )
            ->wherehas('goods', function ($query) use ($request) {
                $query->where('data_name','LIKE','%'.$request->sch.'%');
            })
            ->orderby('id','desc')
            ->paginate(5);

        $carts->getcollection()->map->format();

        return $carts;
    }

    public function cart_state_3($request)
    {
        $cart_state = cart::STATE_3;

        $carts = cart::when($cart_state,
                function ($q) use ($cart_state) {
                    return $q->where('state', $cart_state);
                }
            )
            ->wherehas('goods', function ($query) use ($request) {
                $query->where('data_name','LIKE','%'.$request->sch.'%');
            })
            ->orderby('id','desc')
            ->paginate(5);

        $carts->getcollection()->map->format();

        return $carts;
    }

    public function cart_state_4($request)
    {
        $cart_state = cart::STATE_4;

        $carts = cart::when($cart_state,
                function ($q) use ($cart_state) {
                    return $q->where('state', $cart_state);
                }
            )
            ->wherehas('goods', function ($query) use ($request) {
                $query->where('data_name','LIKE','%'.$request->sch.'%');
            })
            ->doesnthave('options')
            ->orderby('id','desc')
            ->paginate(5);

        $carts->getcollection()->map->format();

        return $carts;
    }

    public function option_state_1($request)
    {
        $option_state = option::STATE_1;

        $carts = cart::wherehas('options', function ($query) use ($option_state) {
                $query->where('state', $option_state);
            })
            ->wherehas('goods', function ($query) use ($request) {
                $query->where('data_name','LIKE','%'.$request->sch.'%');
            })
            ->orderby('id','desc')
            ->paginate(5);

        $carts->getcollection()->map->format();

        return $carts;
    }

    public function option_state_2($request)
    {
        $option_state = option::STATE_2;

        $carts = cart::wherehas('options', function ($query) use ($option_state) {
                $query->where('state', $option_state);
            })
            ->wherehas('goods', function ($query) use ($request) {
                $query->where('data_name','LIKE','%'.$request->sch.'%');
            })
            ->orderby('id','desc')
            ->paginate(5);

        $carts->getcollection()->map->format();

        return $carts;
    }

    public function option_state_3($request)
    {

        $option_state = option::STATE_3;

        $carts = cart::wherehas('options', function ($query) use ($option_state) {
                $query->where('state', $option_state);
            })
            ->wherehas('goods', function ($query) use ($request) {
                $query->where('data_name','LIKE','%'.$request->sch.'%');
            })
            ->orderby('id','desc')
            ->paginate(5);

        $carts->getcollection()->map->format();

        return $carts;
    }

    public function updatestate($request, $id)
    {
        cart::where('goods_id', $id)->update($request->only('state'));
    }
    public function findbyid($id)
    {
        return cart::where('id', $id)
            ->firstorfail()
            ->format();
    }
}
