<?php


namespace App\Repositories;

use App\Option;

class OptionRepository implements OptionRepositoryInterface
{
    public function all()
    {
        $option = option::orderBy('id', 'desc')
            ->get()
            ->map->format();

        return $option;
    }

    public function stateChange($request)
    {
        return option::where('id', $request->option_id)->update(['state'=> $request->states]);
    }

    public function DeleteOption($request)
    {
        return option::where('id', $request->option_id)->delete();
    }
}
