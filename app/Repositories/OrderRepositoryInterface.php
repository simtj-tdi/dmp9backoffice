<?php


namespace App\Repositories;


interface OrderRepositoryInterface
{
    public function all();

    public function findById($id);

    public function create($request);

    public function update($request, $id);

    public function destory($id);
}
