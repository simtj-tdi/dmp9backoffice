<?php

namespace App\Http\Controllers;

use App\Repositories\ContactsusRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ContactsusController extends Controller
{
    private $contactsusRepository;

    public function __construct(ContactsusRepositoryInterface $contactsusRepository)
    {
        $this->contactsusRepository = $contactsusRepository;

        $this->route_name = Route::currentRouteName();
    }

    public function index(Request $request)
    {
        $route_name = $this->route_name;

        $contactsus = $this->contactsusRepository->all($request);

        $sch = $request->sch;

        return view('contactsus.index', compact('contactsus', 'sch', 'route_name'));
    }

    public function destroy($id)
    {
        $this->contactsusRepository->destory($id);

        return redirect()->route('contactsus.index');
    }

    public function find_id(Request $request)
    {
        $request_data = json_decode($request->data);
        $contactsus_info = $this->contactsusRepository->findById($request_data->contactsu_id);

        $result['result'] = "success";
        $result['contactsus'] = $contactsus_info;


        $response = response()->json($result, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

        return $response;
    }
}
