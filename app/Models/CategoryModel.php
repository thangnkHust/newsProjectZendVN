<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Storage;

class CategoryModel extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id';
    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $fieldSearchAccepted = [
        'id', 'name'
    ];

    protected $crudNotAccepted = [
        '_token'
    ];

    public function article(){
        return $this->hasMany('App\Models\ArticleModel', 'category_id');
    }

    public function listItems($params, $option){

        $result = null;
        if($option['task'] == 'admin-list-items'){
            // $result = SliderModel::all();
            $query = $this->select('id', 'name', 'status', 'is_home', 'display', 'created', 'created_by', 'modified', 'modified_by');
            
            if($params['filter']['status'] != 'all'){
                $query->where('status', '=', $params['filter']['status']);
            }

            if($params['search']['value'] != ''){   
                if($params['search']['field'] == 'all'){
                    $query->where(function($query) use($params){
                        foreach($this->fieldSearchAccepted as $column){
                            $query->orWhere($column, 'like', "%{$params['search']['value']}%");
                        } 
                    });
                }else{
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }
            $result = $query->orderBy('id', 'desc')
                            ->paginate($params['pagination']['totalItemPerPage']);
        }

        if($option['task'] == 'news-list-items'){
            $query = $this->select('id', 'name')
                        ->where('status', '=', 'active')
                        ->limit(8);
            $result = $query->get()->toArray();
        }

        if($option['task'] == 'news-list-items-is-home'){
            $query = $this->select('id', 'name', 'display')
                        ->where('status', '=', 'active')
                        ->where('is_home', '=', '1')
                        ->limit(8);
            $result = $query->get();
        }

        if($option['task'] == 'admin-list-items-in-selectbox'){
            $query = $this->select('id', 'name')
                        ->orderBy('name', 'asc')
                        ->where('status', '=', 'active');
            $result = $query->pluck('name', 'id')->toArray();
        }

        return $result;
    }

    public function countItems($params, $option){
        $result = null;
        if($option['task'] == 'admin-count-items-group-by-status'){
            $query = self::select(DB::raw('count(id) as count, status'))
                                    // ->where('id', '>', 3)
                                    ->groupBy('status');

            if($params['search']['value'] != ''){
                if($params['search']['field'] == 'all'){
                    $query->where(function($query) use($params){
                        foreach($this->fieldSearchAccepted as $column){
                            $query->orWhere($column, 'like', "%{$params['search']['value']}%");
                        } 
                    });
                }else{
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }
            $result = $query->get()
                            ->toArray();   
        }
        return $result;
    }

    public function saveItem($params = null, $option = null){
        // Chuc nang thay doi status
        if($option['task'] == 'change-status'){
            $status = ($params['currentStatus'] == 'active') ? 'inactive' : 'active';
            self::where('id', $params['id'])
                ->update(['status' => $status]);
        }
        // Chuc nang thay doi is_home
        if($option['task'] == 'change-is_home'){
            $isHome = ($params['currentIsHome'] == '1') ? '0' : '1';
            self::where('id', $params['id'])
                ->update(['is_home' => $isHome]);
        }
        // Chuc nang thay doi display
        if($option['task'] == 'change-display'){
            $display = $params['currentDisplay'];
            self::where('id', $params['id'])
                ->update(['display' => $display]);
        }
        // Chuc nang add
        if($option['task'] == 'add-item'){
            $params['created_by'] = 'thangnk';
            $params['created'] = date('Y-m-d');
            $params['id'] = self::max('id') + 1;

            $params = array_diff_key($params, array_flip($this->crudNotAccepted));
            self::insert($params);
        }
        // Chuc nang edit
        if($option['task'] == 'edit-item'){
            // Truong hop khong upload hinh anh moi
            $params['modified_by'] = 'thangnk';
            $params['modified'] = date('Y-m-d');
            $params = array_diff_key($params, array_flip($this->crudNotAccepted));
            self::where('id', $params['id'])->update($params);
        }
    }

    public function deleteItem($params = null, $option = null){
        if($option['task'] == 'delete-item'){
            self::where('id', $params['id'])
                ->delete();
        }
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'name', 'status', 'is_home', 'display')->where('id', $params['id'])->first();
        }

        if($option['task'] == 'news-get-item'){
            $result = self::select('id', 'name', 'display')->where('id', $params['category_id'])->first();
        }

        return $result;
    }
}
