<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepositoryInterface;
use App\Repositories\GoodsRepositoryInterface;
use App\Repositories\PlatformRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CartController extends Controller
{
    private $cartRepository;
    private $platformRepository;
    private $goodsRepository;
    private $route_name;

    public function __construct(CartRepositoryInterface $cartRepository,
                                PlatformRepositoryInterface $platformRepository,
                                GoodsRepositoryInterface $goodsRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->platformRepository = $platformRepository;
        $this->goodsRepository = $goodsRepository;

        $this->route_name = Route::currentRouteName();
    }
    public function index(Request $request)
    {
        $route_name = $this->route_name;

        $carts = $this->cartRepository->all($request);
        $platforms = $this->platformRepository->all();

        $sch = $request->sch;

        return view('carts.index', compact('carts', 'platforms', 'sch', 'route_name'));
    }

    public function edit($id)
    {
        $carts = $this->cartRepository->findById($id);

        return view('carts.edit', compact('carts'));
    }

    public function update(Request $request, $id)
    {
        if ($request->data_files) {
            $path = explode('/', $request->data_files->store('files'));

            $request['state'] = 4;
            $request['data_filess'] = $path[1];
        }

        $this->goodsRepository->update($request, $id);
        $this->cartRepository->updateState($request, $id);

        return redirect()->route('cart.index');
    }

    public function find_id(Request $request)
    {
        $request_data = json_decode($request->data);
        $cart_info = $this->cartRepository->findById($request_data->cart_id);

        $result['result'] = "success";
        $result['casrt_info'] = $cart_info;
        $response = response()->json($result, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

        return $response;
    }

    //결제대기중
    public function cart_state_1(Request $request)
    {
        $route_name = $this->route_name;

        $carts = $this->cartRepository->cart_state_1($request);
        $platforms = $this->platformRepository->all();

        $sch = $request->sch;

        return view('carts.index', compact('carts', 'platforms', 'sch', 'route_name'));
    }

    //결제완료
    public function cart_state_2(Request $request)
    {
        $route_name = $this->route_name;

        $carts = $this->cartRepository->cart_state_2($request);
        $platforms = $this->platformRepository->all();

        $sch = $request->sch;

        return view('carts.index', compact('carts', 'platforms', 'sch', 'route_name'));
    }

    //데이터추출중
    public function cart_state_3(Request $request)
    {
        $route_name = $this->route_name;

        $carts = $this->cartRepository->cart_state_3($request);
        $platforms = $this->platformRepository->all();

        $sch = $request->sch;

        return view('carts.index', compact('carts', 'platforms', 'sch', 'route_name'));
    }

    //데이터추출완료
    public function cart_state_4(Request $request)
    {
        $route_name = $this->route_name;

        $carts = $this->cartRepository->cart_state_4($request);
        $platforms = $this->platformRepository->all();

        $sch = $request->sch;

        return view('carts.index', compact('carts', 'platforms', 'sch', 'route_name'));
    }

    //업로드대기
    public function option_state_1(Request $request)
    {
        $route_name = $this->route_name;

        $carts = $this->cartRepository->option_state_1($request);
        $platforms = $this->platformRepository->all();

        $sch = $request->sch;

        return view('carts.uploade', compact('carts', 'platforms', 'sch', 'route_name'));
    }

    //업로드요청
    public function option_state_2(Request $request)
    {
        $route_name = $this->route_name;

        $carts = $this->cartRepository->option_state_2($request);
        $platforms = $this->platformRepository->all();

        $sch = $request->sch;

        return view('carts.uploade', compact('carts', 'platforms', 'sch', 'route_name'));
    }

    //업로드완료
    public function option_state_3(Request $request)
    {
        $route_name = $this->route_name;

        $carts = $this->cartRepository->option_state_3($request);
        $platforms = $this->platformRepository->all();

        $sch = $request->sch;

        return view('carts.uploade', compact('carts', 'platforms', 'sch', 'route_name'));
    }


}
