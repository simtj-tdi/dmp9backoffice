<?php

namespace App\Http\Controllers;

use App\Mail\SendMailable;
use App\Repositories\UserRepositoryInterface;
use App\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

        $cnt = $users->total();

        return view('users.index', compact('users', 'sch_key','sch','sch1','sch2', 'route_name','cnt'));
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
        $info = $this->userRepository->findById($id);

        if (is_null($request->password)) {
            $request['password'] = $info['password'];
        } else {
            $request['password'] =  Hash::make($request->password);
        }

        $this->userRepository->update($request, $id);



        if ($request->tax_company_number) {

            $taxs = Tax::where('user_id', $info['id'])->get();

            $taxs_data['tax_company_number'] = $request['tax_company_number'];
            $taxs_data['tax_company_name'] = $request['tax_company_name'];
            $taxs_data['tax_name'] = $request['tax_name'];
            $taxs_data['tax_zipcode'] = $request['tax_zipcode'];
            $taxs_data['tax_addres_1'] = $request['tax_addres_1'];
            $taxs_data['tax_addres_2'] = $request['tax_addres_2'];
            $taxs_data['tax_img'] = $request['tax_img'];

            if ($request->tax_img) {
                $path = explode('/', $taxs_data['tax_img']->store('tax/'.$info['user_id']));
                $taxs_data['tax_img'] = $path[2];
            } else {
                $taxs_data['tax_img'] = $taxs[0]->tax_img;
            }

            Tax::where('user_id', $info['id'])->update($taxs_data);
        }


        return redirect()->route('users.index');
    }

    public function UserDeletes(Request $request)
    {
        $request_data = json_decode($request->data);


        $return_result = $this->userRepository->Deletes($request_data->ids);


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

        $cnt = $users->total();

        return view('users.index', compact('users', 'sch_key','sch','sch1','sch2', 'route_name', 'cnt'));
    }

    public function state_change(Request $request)
    {
        $request_data = json_decode($request->data);

        if ($request_data->states == "1") {
            $user_info = $this->userRepository->findById($request_data->user_id);

            Mail::to($user_info['email'])->send(new SendMailable($user_info));
        }

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
