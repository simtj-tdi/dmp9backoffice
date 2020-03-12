<?php


namespace App\Repositories;


interface GoodsRepositoryInterface
{
    public function all();

    public function findById($id);

    public function update($request, $id);

}
