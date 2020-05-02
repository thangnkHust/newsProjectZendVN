<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    private $pathControllerView = 'admin.dashboard.';
    private $controllerName = 'dashboard';

    public function __construct(){
        view()->share('controllerName', $this->controllerName);
    }

    public function index(){
        return view($this->pathControllerView.'index', [
            // 'controllerName' => $this->controllerName
        ]);
    }
    
}
