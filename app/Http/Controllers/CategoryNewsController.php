<?php

namespace App\Http\Controllers;
use App\Models\ArticleModel as ArticleModel;
use App\Models\CategoryModel as CategoryModel;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\View;
use DB;

class CategoryNewsController extends Controller
{
    private $pathControllerView = 'news.pages.category.';
    private $controllerName = 'categoryNews';
    private $model;
    private $params = [];

    public function __construct(){
        // $this->params['pagination']['totalItemPerPage'] = 10;
        // $this->model = new MainModel;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request){
        $articleModel = new ArticleModel();
        $categoryModel = new CategoryModel();
        $params['category_id'] = $request->category_id;

        $itemCategory = $categoryModel->getItem($params, ['task' => 'news-get-item']);
        if(empty($itemCategory)){
            return \redirect(\route('home'));
        }
        $itemsLatest = $articleModel->listItems(null, ['task' => 'news-list-items-latest']);
        $itemCategory['article'] = $articleModel->listItems(['category_id' => $itemCategory['id']], ['task' => 'news-list-items-in-category']);
        // echo '<pre>';
        // print_r($itemCategory);
        // echo '</pre>';

        return view($this->pathControllerView.'index', [
            'params' => $this->params,
            'itemsLatest' => $itemsLatest,
            'itemCategory' => $itemCategory
        ]);
    }
    
}

