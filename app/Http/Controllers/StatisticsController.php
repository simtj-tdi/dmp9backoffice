<?php


namespace App\Http\Controllers;


use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class StatisticsController extends Controller
{
    private $orderRepository;
    private $route_name;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;

        $this->route_name = Route::currentRouteName();
    }

    public function SalesChart(Request $request)
    {
        $route_name = $this->route_name;

        $orders = $this->orderRepository->all($request);


        $sch_key = $request->sch_key;
        $sch = $request->sch;
        $sch1 = $request->sch1 ? $request->sch1 : date("Y-m-d", strtotime("-7 days"));
        $sch2 = $request->sch2 ? $request->sch2 : date("Y-m-d");

        $date_range = $this->date_range($sch1, $sch2, "+1 day", "Y-m-d");

        $total_price = $orders->sum(function($item)  {
            return $item->total_price;
        });

        $total_count = $orders->sum(function($item)  {
            return $item->total_count;
        });

        $data = array_map(function ($item) use ($orders) {
            $value = $orders->sum(function($order_item) use ($item)  {
                if ($item == date("Y-m-d", strtotime($order_item->created_at))) {
                    return $order_item->total_price;
                }
            });

            return ['device' => "dev1", 'date'=> $item, 'value'=>$value];
        }, $date_range);

        $data_table = array_map(function ($item) use ($orders) {
            $price_value = $orders->sum(function($order_item) use ($item)  {
                if ($item == date("Y-m-d", strtotime($order_item->created_at))) {
                    return $order_item->total_price;
                }
            });
            $price_count = $orders->sum(function($order_item) use ($item)  {
                if ($item == date("Y-m-d", strtotime($order_item->created_at))) {
                    return $order_item->total_count;
                }
            });
            return ['date'=> $item, 'price_value'=>$price_value, 'price_count'=>$price_count];
        }, $date_range);

        return view('statistics.sales', compact('data', 'sch_key','sch','sch1','sch2', 'route_name', 'total_price','total_count', 'data_table','orders'));
    }

    public function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y' )
    {
        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while( $current <= $last ) {
            //$dates[] = date($output_format, $current);
            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

}
