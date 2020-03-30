<?php


namespace App\Repositories;


use App\Contactsus;

class ContactsusRepository implements ContactsusRepositoryInterface
{
    public function all($request)
    {
        $contactsus = Contactsus::orderBy('id','desc')
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

        $contactsus->getCollection()->map->format();;

        return $contactsus;
    }

    public function findById($id)
    {
        return Contactsus::where('id', $id)
            ->firstOrFail()
            ->format();
    }

    public function destory($id)
    {
        Contactsus::where('id', $id)->delete();
    }
}
