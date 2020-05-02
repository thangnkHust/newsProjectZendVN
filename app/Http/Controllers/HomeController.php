<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SliderModel as SliderModel;
use App\Models\CategoryModel as CategoryModel;
use App\Models\ArticleModel as ArticleModel;
// use Illuminate\Support\Facades\View;
use DB;

class HomeController extends Controller
{
    private $pathControllerView = 'news.pages.home.';
    private $controllerName = 'home';
    private $model;
    private $params = [];

    public function __construct(){
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request){

        $sliderModel = new SliderModel();
        $articleModel = new ArticleModel();
        $categoryModel = new CategoryModel();

        $itemsSlider = $sliderModel->listItems(null, ['task' => 'news-list-items']);
        $itemsCategory = $categoryModel->listItems(null, ['task' => 'news-list-items-is-home']);
        $itemsFeature = $articleModel->listItems(null, ['task' => 'news-list-items-feature']);
        $itemsLatest = $articleModel->listItems(null, ['task' => 'news-list-items-latest']);

        foreach($itemsCategory as $key => $value){
            $itemsCategory[$key]['article'] = $articleModel->listItems(['category_id' => $value['id']], ['task' => 'news-list-items-in-category']);
        }

        //=== Dung Eloquent 1 - n lien ket lay du lieu ===//
        // foreach($itemsCategory as $key => $value){
        //     $itemsCategory[$key]['article'] = $value->article->take(4);
        // }


        return view($this->pathControllerView.'index', [
            'params' => $this->params,
            'itemsSlider' => $itemsSlider,
            'itemsCategory' => $itemsCategory,
            'itemsFeature' => $itemsFeature,
            'itemsLatest' => $itemsLatest
        ]);
    }
    
}

