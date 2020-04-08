<?php


namespace App\Http\Controllers;


use App\Repositories\OptionRepositoryInterface;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    private $optionRepository;

    public function __construct(OptionRepositoryInterface $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function index()
    {
       $options = $this->optionRepository->all();

       return view('option.index', compact('options'));
    }

    public function stateChange(Request $request)
    {
        $request_data = json_decode($request->data);
        $return_result = $this->optionRepository->stateChange($request_data);

        if (!$return_result) {
            $result['result'] = "error";
            $result['error_message'] = "등록되어 있는 데이터가 없습니다.";
            $response = response()->json($result, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        } else {
            $result['result'] = "success";
            $response = response()->json($result, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        }

        return $response;
    }

}
