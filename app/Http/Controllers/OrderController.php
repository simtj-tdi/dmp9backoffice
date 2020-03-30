<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class OrderController extends Controller
{
    private $orderRepository;
    private $route_name;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;

        $this->route_name = Route::currentRouteName();
    }

    public function index(Request $request)
    {
        $route_name = $this->route_name;

        $orders = $this->orderRepository->all($request);

        $sch_key = $request->sch_key;
        $sch = $request->sch;
        $sch1 = $request->sch1;
        $sch2 = $request->sch2;

        return view('orders.index', compact('orders', 'sch_key','sch','sch1','sch2', 'route_name'));
    }

    public function taxstateChange(Request $request)
    {
        $request_data = json_decode($request->data);
        $return_result = $this->orderRepository->taxstateChange($request_data);

        if (!$return_result) {
            $result['result'] = "error";
            $result['error_message'] = "등록되어 있는 계산서가 없습니다.";
            $response = response()->json($result, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        } else {
            $result['result'] = "success";
            $response = response()->json($result, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        }

        return $response;

    }

}
