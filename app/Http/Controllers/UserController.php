<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;

        $this->route_name = Route::currentRouteName();
    }

    public function index(Request $request)
    {
        $route_name = $this->route_name;

        $users = $this->userRepository->all($request);

        $sch_key = $request->sch_key;
        $sch = $request->sch;
        $sch1 = $request->sch1;
        $sch2 = $request->sch2;
        return view('users.index', compact('users', 'sch_key','sch','sch1','sch2', 'route_name'));
    }

    public function show($id)
    {
        $users = $this->userRepository->findById($id);

        return view('users.show', compact('users'));
    }

    public function edit($id)
    {
        $users = $this->userRepository->findById($id);

        return view('users.edit', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $this->userRepository->update($request, $id);

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $this->userRepository->destory($id);

        return redirect()->route('users.index');
    }

    public function find_id(Request $request)
    {
        $request_data = json_decode($request->data);
        $user_info = $this->userRepository->findById($request_data->user_id);

        $result['result'] = "success";
        $result['user_info'] = $user_info;
        $response = response()->json($result, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

        return $response;
    }

    public function NonCertification(Request $request)
    {
        $route_name = $this->route_name;

        $users = $this->userRepository->NonCertification($request);

        $sch_key = $request->sch_key;
        $sch = $request->sch;
        $sch1 = $request->sch1;
        $sch2 = $request->sch2;

        return view('users.index', compact('users', 'sch_key','sch','sch1','sch2', 'route_name'));
    }

    public function state_change(Request $request)
    {
        $request_data = json_decode($request->data);
        $return_result = $this->userRepository->StateChange($request_data);

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
