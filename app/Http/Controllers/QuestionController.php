<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepositoryInterface;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    private $questionRepository;

    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function index()
    {
        $questions = $this->questionRepository->all();

        return view('questions.index', compact('questions'));
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
}
