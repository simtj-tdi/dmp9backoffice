<?php


namespace App\Repositories;


use App\Cart;
use App\Option;

class cartrepository implements cartrepositoryinterface
{
    public function all($request)
    {
        $carts = cart::orderby('id','desc')
            ->when($request->sch_key == "buy_date",
                function ($q) use ($request) {
                    return $q->where($request->sch_key, '>=', $request->sch1." 00:00:00")->where($request->sch_key, '<=', $request->sch2." 23:59:59");
                }
            )
            ->wherehas('goods', function ($query) use ($request) {
                if ($request->sch_key) {
                    $query->where($request->sch_key,'LIKE','%'.$request->sch.'%');
                }
            })

            ->paginate(10);



        $carts->getcollection()->map->format();

        return $carts;
    }

    public function cart_state_1($request)
    {
        $cart_state = cart::STATE_1;

        $carts = cart::when($cart_state,
                function ($q) use ($cart_state, $request) {
                    if ($request->sch1) {
                        return $q->where('state', $cart_state)->where($request->sch_key, '>=', $request->sch1." 00:00:00")->where($request->sch_key, '<=', $request->sch2." 23:59:59");
                    } else {
                        return $q->where('state', $cart_state);
                    }
                }
            )
            ->wherehas('goods', function ($query) use ($request) {
                if ($request->sch_key) {
                    $query->where($request->sch_key,'LIKE','%'.$request->sch.'%');
                }
            })
            ->orderby('id','desc')
            ->paginate(10);

        $carts->getcollection()->map->format();

        return $carts;
    }

    public function cart_state_2($request)
    {
        $cart_state = cart::STATE_2;

        $carts = cart::when($cart_state,
                function ($q) use ($cart_state, $request) {
                    if ($request->sch1) {
                        return $q->where('state', $cart_state)->where($request->sch_key, '>=', $request->sch1." 00:00:00")->where($request->sch_key, '<=', $request->sch2." 23:59:59");
                    } else {
                        return $q->where('state', $cart_state);
                    }
                }
            )
            ->wherehas('goods', function ($query) use ($request) {
                if ($request->sch_key) {
                    $query->where($request->sch_key,'LIKE','%'.$request->sch.'%');
                }
            })
            ->orderby('id','desc')
            ->paginate(10);

        $carts->getcollection()->map->format();

        return $carts;
    }

    public function cart_state_3($request)
    {
        $cart_state = cart::STATE_3;

        $carts = cart::when($cart_state,
                function ($q) use ($cart_state, $request) {
                    if ($request->sch1) {
                        return $q->where('state', $cart_state)->where($request->sch_key, '>=', $request->sch1." 00:00:00")->where($request->sch_key, '<=', $request->sch2." 23:59:59");
                    } else {
                        return $q->where('state', $cart_state);
                    }
                }
            )
            ->wherehas('goods', function ($query) use ($request) {
                if ($request->sch_key) {
                    $query->where($request->sch_key,'LIKE','%'.$request->sch.'%');
                }
            })
            ->orderby('id','desc')
            ->paginate(10);

        $carts->getcollection()->map->format();

        return $carts;
    }

    public function cart_state_4($request)
    {
        $cart_state = cart::STATE_4;

        $carts = cart::when($cart_state,
                function ($q) use ($cart_state, $request) {
                    if ($request->sch1) {
                        return $q->where('state', $cart_state)->where($request->sch_key, '>=', $request->sch1." 00:00:00")->where($request->sch_key, '<=', $request->sch2." 23:59:59");
                    } else {
                        return $q->where('state', $cart_state);
                    }
                }
            )
            ->wherehas('goods', function ($query) use ($request) {
                if ($request->sch_key) {
                    $query->where($request->sch_key,'LIKE','%'.$request->sch.'%');
                }
            })
            ->doesnthave('options')
            ->orderby('id','desc')
            ->paginate(10);

        $carts->getcollection()->map->format();

        return $carts;
    }

    public function cart_state_5($request)
    {
        $cart_state = cart::STATE_5;

        $carts = cart::when($cart_state,
            function ($q) use ($cart_state, $request) {
                if ($request->sch1) {
                    return $q->where('state', $cart_state)->where($request->sch_key, '>=', $request->sch1." 00:00:00")->where($request->sch_key, '<=', $request->sch2." 23:59:59");
                } else {
                    return $q->where('state', $cart_state);
                }
            }
        )
            ->wherehas('goods', function ($query) use ($request) {
                if ($request->sch_key) {
                    $query->where($request->sch_key,'LIKE','%'.$request->sch.'%');
                }
            })
            ->doesnthave('options')
            ->orderby('id','desc')
            ->paginate(10);

        $carts->getcollection()->map->format();

        return $carts;
    }

    public function option_state_1($request)
    {
        $option_state = option::STATE_1;

        $carts = option::where('state', $option_state)
            ->wherehas('cart', function ($query) use ($request) {
                if ($request->sch_key == "buy_date") {
                    $query->where($request->sch_key, '>=', $request->sch1." 00:00:00")->where($request->sch_key, '<=', $request->sch2." 23:59:59");
                } else {
                    $query->wherehas('goods', function ($query) use ($request) {
                        if ($request->sch_key) {
                            $query->where($request->sch_key,'LIKE','%'.$request->sch.'%');
                        }
                    });
                }
            })
            ->orderby('id','desc')
            ->paginate(10);
        $carts->getcollection()->map->format();

        return $carts;
    }

    public function option_state_2($request)
    {
        $option_state = option::STATE_2;

        $carts = option::where('state', $option_state)
            ->wherehas('cart', function ($query) use ($request) {
                if ($request->sch_key == "buy_date") {
                    $query->where($request->sch_key, '>=', $request->sch1." 00:00:00")->where($request->sch_key, '<=', $request->sch2." 23:59:59");
                } else {
                    $query->wherehas('goods', function ($query) use ($request) {
                        if ($request->sch_key) {
                            $query->where($request->sch_key,'LIKE','%'.$request->sch.'%');
                        }
                    });
                }
            })
            ->orderby('id','desc')
            ->paginate(10);
        $carts->getcollection()->map->format();

        return $carts;
    }

    public function option_state_3($request)
    {
        $option_state = option::STATE_3;

        $carts = option::where('state', $option_state)
            ->wherehas('cart', function ($query) use ($request) {
                if ($request->sch_key == "buy_date") {
                    $query->where($request->sch_key, '>=', $request->sch1." 00:00:00")->where($request->sch_key, '<=', $request->sch2." 23:59:59");
                } else {
                    $query->wherehas('goods', function ($query) use ($request) {
                        if ($request->sch_key) {
                            $query->where($request->sch_key,'LIKE','%'.$request->sch.'%');
                        }
                    });
                }
            })
            ->orderby('id','desc')
            ->paginate(10);
        $carts->getcollection()->map->format();

        return $carts;
    }

    public function update($request, $id)
    {
        cart::where('goods_id', $id)->update($request->only('state', 'memo'));
    }

    public function findbyid($id)
    {
        return cart::where('id', $id)
            ->get()->map->format();
    }
}
