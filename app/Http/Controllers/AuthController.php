<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\AuthLoginRequest as MainRequest;
use App\Models\UserModel as UserModel;
// use Illuminate\Support\Facades\View;
use DB;

class AuthController extends Controller
{
    private $pathControllerView = 'news.pages.auth.';
    private $controllerName = 'auth';
    private $model;
    private $params = [];

    public function __construct(){
        view()->share('controllerName', $this->controllerName);
    }

    public function login(Request $request){
        return view($this->pathControllerView.'login');
    }

    public function postlogin(MainRequest $request){
        if($request->method() === 'POST'){
            $params = $request->all();
            $userModel = new UserModel();
            $userInfo = $userModel->getItem($params, ['task' => 'auth-login']);
            if(!$userInfo){
                return \redirect()->route($this->controllerName . '/login')->with('notify', 'Tai khoan hoac mat khau khong chinh xac');
            }
            if($userInfo['status'] == 'inactive'){
                return \redirect()->route($this->controllerName . '/login')->with('notify', 'Tai khoan cua ban da ngung hoat dong');
            }
            $request->session()->put('userInfo', $userInfo);
            return \redirect()->route('home');
        }
        // return view($this->pathControllerView.'postlogin');
    }
    
    public function logout(Request $request){
        if($request->session()->has('userInfo')){
            $request->session()->pull('userInfo');
        }
        return \redirect()->route('home');
    }
}

