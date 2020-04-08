<?php


namespace App\Repositories;


interface GoodsRepositoryInterface
{
    public function all();

    public function findById($id);

    public function update($request, $id);

    public function update1($request, $id);

    public function update4($request, $id);

}
