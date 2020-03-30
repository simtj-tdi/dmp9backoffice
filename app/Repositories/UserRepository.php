<?php


namespace App\Repositories;

use App\User;

class UserRepository implements UserRepositoryInterface
{
    public function all($request)
    {
        $users = user::orderBy('id','desc')
            ->where('role', '!=', 'admin')
            ->when($request->sch_key,
                function ($q) use ($request) {
                    if ($request->sch) {
                        return $q->where($request->sch_key, 'LIKE', '%' . $request->sch . '%');
                    } else if ($request->sch1) {
                        return $q->where($request->sch_key, '>=', $request->sch1." 00:00:00")->where($request->sch_key, '<=', $request->sch2." 23:59:59");
                    }
                }
            )
            ->paginate(5);

        $users->getCollection()->map->format();;

        return $users;
    }

    public function findById($id)
    {
        return user::where('id', $id)
            ->firstOrFail()
            ->format();
    }

    public function update($request, $id)
    {
        $user = user::where('id', $id)->firstOrFail();

        if ($request['approved']) {
            $request['approved_at'] = now();
        }

        $user->update($request->toArray());
    }

    public function destory($id)
    {
        user::where('id', $id)->delete();
    }


}
