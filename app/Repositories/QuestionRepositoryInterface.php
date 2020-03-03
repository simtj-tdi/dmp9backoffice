<?php


namespace App\Repositories;


interface QuestionRepositoryInterface
{
    public function all();

    public function findById($id);

    public function create($request);

    public function update($request, $id);

    public function answer_update($request, $id);

    public function destory($id);
}
