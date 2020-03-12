<?php

namespace App\Http\Controllers;

use App\Goods;
use App\Repositories\CartRepositoryInterface;
use App\Repositories\GoodsRepositoryInterface;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    private $cartRepository;
    private $goodsRepository;

    public function __construct(CartRepositoryInterface $cartRepository,
                                GoodsRepositoryInterface $goodsRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->goodsRepository = $goodsRepository;
    }

    public function index()
    {
        $goods = $this->goodsRepository->all();

        return view('goods.index', compact('goods'));
    }


    public function edit($id)
    {
        $goods = $this->goodsRepository->findById($id);

        return view('goods.edit', compact('goods'));
    }

    public function update(Request $request, $id)
    {
        $this->goodsRepository->update($request, $id);
        $this->cartRepository->updateState($request, $id);

        return redirect()->route('goods.index');
    }

}
