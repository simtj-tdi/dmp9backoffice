<?php


namespace App\Repositories;

use App\User;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        $users = user::orderBy('id','desc')
            ->where('role', '=', 'user')
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

        $user->update($request->only( 'name', 'email', 'password','approved', 'approved_at'));
    }

    public function destory($id)
    {
        user::where('id', $id)->delete();
    }


}
