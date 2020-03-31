<?php


namespace App\Repositories;


interface CartRepositoryInterface
{
    public function all($request);

    public function cart_state_1($request);

    public function cart_state_2($request);

    public function cart_state_3($request);

    public function cart_state_4($request);

    public function cart_state_5($request);

    public function option_state_1($request);

    public function option_state_2($request);

    public function option_state_3($request);

    public function update($request, $id);

    public function findById($id);
}
