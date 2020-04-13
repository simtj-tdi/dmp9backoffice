<?php

namespace App\Http\Controllers;

use App\Repositories\FaqRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class FaqController extends Controller
{

    private $faqRepository;

    public function __construct(FaqRepositoryInterface $faqRepository)
    {
        $this->faqRepository = $faqRepository;

        $this->route_name = Route::currentRouteName();
    }

    public function index(Request $request)
    {
        $route_name = $this->route_name;

        $faqs = $this->faqRepository->all($request);

        $sch_key = $request->sch_key;
        $sch = $request->sch;
        $sch1 = $request->sch1;
        $sch2 = $request->sch2;

        $cnt = $faqs->total();

        return view('faqs.index', compact('faqs','sch_key','sch','sch1','sch2', 'route_name', 'cnt'));
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

    public function find_id(Request $request)
    {
        $request_data = json_decode($request->data);
        $faq_info = $this->faqRepository->findById($request_data->faq_id);

        $result['result'] = "success";
        $result['faq_info'] = $faq_info;


        $response = response()->json($result, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

        return $response;
    }
}
