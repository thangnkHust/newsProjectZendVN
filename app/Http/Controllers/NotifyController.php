<?php

namespace App\Http\Controllers;
use App\Models\ArticleModel;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\View;
use DB;

class NotifyController extends Controller
{
    private $pathControllerView = 'news.pages.notify.';
    private $controllerName = 'notify';
    private $model;
    private $params = [];

    public function __construct(){
        $this->params['pagination']['totalItemPerPage'] = 10;
        $this->model = new ArticleModel;
        view()->share('controllerName', $this->controllerName);
    }

    public function noPermission(Request $request){
        $articleModel = new ArticleModel();
        $itemsLatest = $articleModel->listItems(null, ['task' => 'news-list-items-latest']);

        return view($this->pathControllerView.'no-permission', [
            'itemsLatest' => $itemsLatest
        ]);
    }
    
}

