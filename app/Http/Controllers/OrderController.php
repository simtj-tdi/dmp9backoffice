<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->all();

        return view('orders.index', compact('orders'));
    }

    public function edit($id)
    {
        $order = $this->orderRepository->findById($id);
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $this->orderRepository->update($request, $id);

        return redirect()->route('orders.index');
    }

}
