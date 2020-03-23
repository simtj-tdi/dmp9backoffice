<?php


namespace App\Repositories;


use App\Platform;

class PlatformRepository implements PlatformRepositoryInterface
{
    public function all()
    {
        $platforms = platform::orderBy('id', 'asc')
            ->get()
            ->map->format();

        return $platforms;
    }
}
