<?php


namespace App\Repositories;


interface CartRepositoryInterface
{
    public function updateState($request, $id);
}
