<?php


namespace App\Repositories;


interface OptionRepositoryInterface
{
    public function all();

    public function stateChange($request);
}
