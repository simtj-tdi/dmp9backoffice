<?php

namespace App\Repositories;

use App\Faq;

class FaqRepository implements FaqRepositoryInterface
{
    public function all($request)
    {
        $faqs = faq::orderBy('id','desc')
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

        $faqs->getCollection()->map->format();;

        return $faqs;
    }

    public function findById($id)
    {
        return faq::where('id', $id)
            ->firstOrFail()
            ->format();
    }

    public function create($request)
    {
        auth()->user()->faqs()->create($request);
    }

    public function update($request, $id)
    {
        $faq = faq::where('id', $id)->firstOrFail();
        $faq->update($request->only('title', 'content'));
    }

    public function destory($id)
    {
        faq::where('id', $id)->delete();
    }

}
