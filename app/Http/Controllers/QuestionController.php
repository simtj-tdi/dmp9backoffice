<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class QuestionController extends Controller
{
    private $questionRepository;

    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;

        $this->route_name = Route::currentRouteName();
    }

    public function index(Request $request)
    {

        $route_name = $this->route_name;

        $questions = $this->questionRepository->all($request);

        $sch_key = $request->sch_key;
        $sch = $request->sch;
        $sch1 = $request->sch1;
        $sch2 = $request->sch2;

        $cnt = $questions->total();

        return view('questions.index', compact('questions','sch_key','sch','sch1','sch2', 'route_name', 'cnt'));
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $this->questionRepository->create($validatedData);

        return redirect()->route('questions.index');
    }

    public function show($id)
    {
        $question = $this->questionRepository->findById($id);

        return view('questions.show', compact('question'));
    }

    public function edit($id)
    {
        $question = $this->questionRepository->findById($id);

        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $this->questionRepository->answer_update($request, $id);

        return redirect()->route('questions.index');
    }

    public function destroy($id)
    {
        $this->questionRepository->destory($id);

        return redirect()->route('questions.index');
    }

    public function find_id(Request $request)
    {
        $request_data = json_decode($request->data);
        $question_info = $this->questionRepository->findById($request_data->question_id);

        $result['result'] = "success";
        $result['question_info'] = $question_info;
        $response = response()->json($result, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

        return $response;
    }
}
