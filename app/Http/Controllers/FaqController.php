<?php

namespace App\Http\Controllers;

use App\Repositories\FaqRepositoryInterface;
use Illuminate\Http\Request;

class FaqController extends Controller
{

    private $faqRepository;

    public function __construct(FaqRepositoryInterface $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    public function index()
    {
        $faqs = $this->faqRepository->all();

        return view('faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('faqs.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $this->faqRepository->create($validatedData);

        return redirect()->route('faqs.index');
    }

    public function show($id)
    {
        $faq = $this->faqRepository->findById($id);

        return view('faqs.show', compact('faq'));
    }

    public function edit($id)
    {
        $faq = $this->faqRepository->findById($id);

        return view('faqs.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $this->faqRepository->update($request, $id);

        return redirect()->route('faqs.index');
    }

    public function destroy($id)
    {
        $this->faqRepository->destory($id);

        return redirect()->route('faqs.index');
    }
}
