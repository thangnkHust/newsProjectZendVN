<?php

namespace App\Http\Controllers;
use App\Models\ArticleModel as MainModel;
use App\Models\CategoryModel as CategoryModel;
use App\Http\Requests\ArticleRequest as MainRequest;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\View;
use DB;

class ArticleController extends Controller
{
    private $pathControllerView = 'admin.pages.article.';
    private $controllerName = 'article';
    private $model;
    private $params = [];

    public function __construct(){
        $this->params['pagination']['totalItemPerPage'] = 10;
        $this->model = new MainModel;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request){
        
        // Bat su kien status
        $this->params['filter']['status'] =  $request->input('filter_status', 'all');
        $this->params['search']['field'] =  $request->input('search_field', '');
        $this->params['search']['value'] =  $request->input('search_value', '');

        // Lay danh sach hien thi list article
        $items = $this->model->listItems($this->params, ['task' => 'admin-list-items']);
        // Nhom status
        $itemsStatusCount = $this->model->countItems($this->params, ['task' => 'admin-count-items-group-by-status']);
        // [
        //     ['status' => '...',
        //     'count' => ...
        //     ]
        // ]

        return view($this->pathControllerView.'index', [
            // 'controllerName' => $this->controllerName
            'items' => $items,
            'itemsStatusCount' => $itemsStatusCount,
            'params' => $this->params
        ]);
    }
    
    public function form(Request $request){
        $items = null;

        if($request->id != null){
            $params['id'] = $request->id;
            $items = $this->model->getItem($params, ['task' => 'get-item']);
        }
        $categoryModel = new CategoryModel();
        $itemsCategory = $categoryModel->listItems(null, ['task' => 'admin-list-items-in-selectbox']);
        // echo '<pre>';
        // print_r($itemsCategory);
        // echo '</pre>';
        // die();
        return view($this->pathControllerView.'form', [
            'item' => $items,
            'itemsCategory' => $itemsCategory
        ]);
    }

    public function save(MainRequest $request){
        if($request->method() == 'POST'){
            $params = $request->all();
            $task = 'add-item';
            $notify = 'Add item successfully';

            if($params['id'] != null){
                $task = 'edit-item';
                $notify = 'Update item successfully';
            }
            $this->model->saveItem($params, ['task' => $task]);
            return \redirect()->route($this->controllerName)->with('notify', $notify);
        }
    }

    public function status(Request $request){
        $params['currentStatus'] = $request->status;
        $params['id'] = $request->id;
        $this->model->saveItem($params, ['task' => 'change-status']);
        $status = ($params['currentStatus'] == 'active') ? 'inactive' : 'active';
        return \redirect()->route($this->controllerName)->with('notify', \sprintf('Update element id = %s status from %s to %s', $params['id'], $params['currentStatus'], $status));
    }

    public function type(Request $request){
        $params['currentType'] = $request->type;
        $params['id'] = $request->id;
        $this->model->saveItem($params, ['task' => 'change-type']);
        return \redirect()->route($this->controllerName)->with('notify', 'Update element type successfully');
    }

    public function delete(Request $request){
        $params['id'] = $request->id;
        $this->model->deleteItem($params, ['task' => 'delete-item']);
        return \redirect()->route($this->controllerName)->with('notify', \sprintf('Delete element id = %s sucessfully', $params['id']));
    }
}

