<?php


namespace App\Repositories;


interface OrderRepositoryInterface
{
    public function all($request);

    public function taxstateChange($request);
}
