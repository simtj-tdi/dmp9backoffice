<?php


namespace App\Repositories;


interface UserRepositoryInterface
{
    public function all($request);

    public function findById($id);

    public function update($request, $id);

    public function destory($id);

    public function NonCertification($request);
}
