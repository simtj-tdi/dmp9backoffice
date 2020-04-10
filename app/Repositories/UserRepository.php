<?php


namespace App\Repositories;

use App\User;

class userrepository implements userrepositoryinterface
{
    public function all($request)
    {
        $users = user::orderby('id','desc')
            ->where('role', '!=', 'admin')
            ->when($request->sch_key,
                function ($q) use ($request) {
                    if ($request->sch) {
                        return $q->where($request->sch_key, 'like', '%' . $request->sch . '%');
                    } else if ($request->sch1) {
                        return $q->where($request->sch_key, '>=', $request->sch1." 00:00:00")->where($request->sch_key, '<=', $request->sch2." 23:59:59");
                    }
                }
            )
            ->paginate(5);

        $users->getcollection()->map->format();;

        return $users;
    }

    public function findbyid($id)
    {
        return user::where('id', $id)
            ->firstorfail()
            ->format();
    }

    public function update($request, $id)
    {
        $user = user::where('id', $id)->firstorfail();

        if ($request['approved']) {
            $request['approved_at'] = now();
        }

        $user->update($request->toarray());
    }

    public function destory($id)
    {
        user::where('id', $id)->delete();
    }

    public function noncertification($request)
    {
        $users = user::orderby('id','desc')
            ->where('role', '!=', 'admin')
            ->where('approved', '==', '0')
            ->when($request->sch_key,
                function ($q) use ($request) {
                    if ($request->sch) {
                        return $q->where($request->sch_key, 'like', '%' . $request->sch . '%');
                    } else if ($request->sch1) {
                        return $q->where($request->sch_key, '>=', $request->sch1." 00:00:00")->where($request->sch_key, '<=', $request->sch2." 23:59:59");
                    }
                }
            )
            ->paginate(5);

        $users->getcollection()->map->format();

        return $users;
    }

    public function StateChange($request)
    {

        return user::where('id', $request->user_id)->update(['approved'=> $request->states]);
    }

}
