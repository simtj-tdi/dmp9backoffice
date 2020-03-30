<?php

namespace App\Repositories;

use App\Question;
use App\Answer;

class QuestionRepository implements QuestionRepositoryInterface
{
    public function all($request)
    {
        $questions = question::orderBy('id', 'desc')
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

        $questions->getCollection()->map->format();;

        return $questions;
    }

    public function findById($id)
    {
        return question::where('id', $id)
            ->firstOrFail()
            ->format();
    }

    public function create($request)
    {
        auth()->user()->questions()->create($request);
    }

    public function update($request, $id)
    {
        $question = question::where('id', $id)->firstOrFail();
        $question->update($request->only('title', 'content'));
    }

    public function answer_update($request, $id)
    {
        $answer = answer::where('question_id', $id)->get();

        if (isset($answer[0])) {
            answer::where('question_id', $id)->update($request->only('content'));
        } else {
            auth()->user()->answers()->create($request->only('question_id','user_id', 'content'));
        }
    }

    public function destory($id)
    {
        question::where('id', $id)->delete();
    }

}
