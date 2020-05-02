<?php

namespace App\Http\Controllers;
use App\Models\ArticleModel as ArticleModel;
use App\Models\CategoryModel as CategoryModel;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\View;
use DB;

class ArticleNewsController extends Controller
{
    private $pathControllerView = 'news.pages.article.';
    private $controllerName = 'articleNews';
    private $model;
    private $params = [];

    public function __construct(){
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request){
        $articleModel = new ArticleModel();
        $params['article_id'] = $request->article_id;

        $itemArticle = $articleModel->getItem($params, ['task' => 'news-get-item']);
        if(empty($itemArticle)){
            return \redirect(\route('home'));
        }
        $itemsLatest = $articleModel->listItems(null, ['task' => 'news-list-items-latest']);
        $params['category_id'] = $itemArticle->category->id;
        $itemArticle['related_articles'] = $articleModel->listItems($params, ['task' => 'news-list-items-related-in-category']);

        // echo '<pre>';
        // print_r($itemArticle['related_articles']);
        // echo '</pre>';

        return view($this->pathControllerView.'index', [
            'params' => $this->params,
            'itemsLatest' => $itemsLatest,
            'itemArticle' => $itemArticle
        ]);
    }
    
}

