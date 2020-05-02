<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Storage;

class ArticleModel extends Model
{
    protected $table = 'article';
    protected $primaryKey = 'id';
    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $fieldSearchAccepted = [
        'name', 'content'
    ];

    protected $crudNotAccepted = [
        '_token', 'thumb_current'
    ];
    public function category(){
        return $this->belongsTo('App\Models\CategoryModel', 'category_id');
    }

    public function convert_vi_to_en($str) {
        // echo $str;
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(đ)/", "d", $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(Đ)/", "D", $str);
        $str = str_replace(" ", "_", str_replace("&*#39;","",$str));
        $str = strtolower($str);
        return $str;
    }

    public function listItems($params, $option){

        $result = null;
        if($option['task'] == 'admin-list-items'){
            // $result = SliderModel::all();
            $query = $this->select('id', 'name', 'status', 'content', 'thumb', 'created', 'created_by', 'modified', 'modified_by', 'category_id', 'type');

            // foreach($query as $item){
            //     echo '<pre>';
            //     print_r($item->category->name);
            //     echo '</pre>';
            // }
            // die();

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
            $result = $query->get();
        }
        
        if($option['task'] == 'news-list-items-feature'){
            $query = $this->select('id', 'name', 'content', 'created', 'category_id', 'type', 'thumb')
                        ->where('status', '=', 'active')
                        ->where('type', '=', 'feature')
                        ->orderBy('id', 'desc')
                        ->take(3);
            $result = $query->get();
        }

        if($option['task'] == 'news-list-items-latest'){
            $query = $this->select('id', 'name', 'content', 'created', 'category_id', 'type', 'thumb')
                        ->where('status', '=', 'active')
                        ->orderBy('id', 'desc')
                        ->take(4);
            $result = $query->get();
        }

        if($option['task'] == 'news-list-items-in-category'){
            $query = $this->select('id', 'name', 'content', 'created', 'thumb')
                        ->where('status', '=', 'active')
                        ->where('category_id', '=', $params['category_id'])
                        ->orderBy('id', 'desc')
                        ->take(4);
            $result = $query->get()->toArray();
        }

        if($option['task'] == 'news-list-items-related-in-category'){
            $query = $this->select('id', 'name', 'content', 'created', 'thumb', 'category_id')
                        ->where('status', '=', 'active')
                        ->where('id', '!=', $params['article_id'])
                        ->where('category_id', '=', $params['category_id'])
                        ->take(4);
            $result = $query->get()->toArray();
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
        // Chuc nang thay doi type
        if($option['task'] == 'change-type'){
            self::where('id', $params['id'])
                ->update(['type' => $params['currentType']]);
        }
        // Chuc nang add
        if($option['task'] == 'add-item'){
            $params['created_by'] = 'thangnk';
            $params['created'] = date('Y-m-d');
            $params['id'] = self::max('id') + 1;
            $thumb = $params['thumb'];
            $params['thumb'] = Str::random(10) . '.' . $thumb->clientExtension();
            $thumb->storeAs('article', $params['thumb'], 'project1_public');

            $params = array_diff_key($params, array_flip($this->crudNotAccepted));
            self::insert($params);
        }
        // Chuc nang edit
        if($option['task'] == 'edit-item'){
            // Truong hop co upload hinh anh moi
            if(!empty($params['thumb'])){
                Storage::disk('project1_public')->delete('article/' . $params['thumb_current']);
                $thumb = $params['thumb'];
                $params['thumb'] = Str::random(10) . '.' . $thumb->clientExtension();
                $thumb->storeAs('article', $params['thumb'], 'project1_public');
            }
            // Truong hop khong upload hinh anh moi
            $params['modified_by'] = 'thangnk';
            $params['modified'] = date('Y-m-d');
            $params = array_diff_key($params, array_flip($this->crudNotAccepted));
            self::where('id', $params['id'])->update($params);
        }
    }

    public function deleteItem($params = null, $option = null){
        if($option['task'] = 'delete-item'){
            $item = self::getItem($params, ['task' => 'get-thumb']);
            Storage::disk('project1_public')->delete('article/' . $item['thumb']);
            self::where('id', $params['id'])
                ->delete();
        }
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'name', 'content', 'thumb', 'status', 'category_id')->where('id', $params['id'])->first();
        }
        if($option['task'] == 'get-thumb'){
            $result = self::select('id', 'thumb')->where('id', $params['id'])->first();
        }

        if($option['task'] == 'news-get-item'){
            $result = self::select('id', 'name', 'content', 'category_id', 'thumb', 'created')
                    ->where('id', $params['article_id'])
                    ->where('status', '=', 'active')->first();
        }

        return $result;
    }
}
