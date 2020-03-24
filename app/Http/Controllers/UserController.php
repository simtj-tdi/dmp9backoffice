<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $users = $this->userRepository->all();

        return view('users.index', compact('users'));
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
}
