<?php


namespace App\Repositories;


interface OrderRepositoryInterface
{
    public function all();

    public function taxstateChange($request);
}
