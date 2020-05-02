<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Storage;

class SliderModel extends Model
{
    protected $table = 'slider';
    protected $primaryKey = 'id';
    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $fieldSearchAccepted = [
        'id', 'name', 'description', 'link'
    ];

    protected $crudNotAccepted = [
        '_token', 'thumb_current'
    ];

    public function listItems($params, $option){

        $result = null;
        if($option['task'] == 'admin-list-items'){
            // $result = SliderModel::all();
            $query = $this->select('id', 'name', 'description', 'status', 'created', 'created_by', 'modified', 'modified_by');
            
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
            $query = $this->select('id', 'name', 'description', 'link', 'thumb')
                        ->where('status', '=', 'active')
                        ->limit(5);
            $result = $query->get()->toArray();
        }
        // print_r($result);
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
        // Chuc nang add
        if($option['task'] == 'add-item'){
            $thumb = $params['thumb'];
            $params['thumb'] = Str::random(10) . '.' . $thumb->clientExtension();
            $params['created_by'] = 'thangnk';
            $params['created'] = date('Y-m-d');
            $params['id'] = self::max('id') + 1;

            $thumb->storeAs('slider', $params['thumb'], 'project1_public');
            $params = array_diff_key($params, array_flip($this->crudNotAccepted));
            self::insert($params);
        }
        // Chuc nang edit
        if($option['task'] == 'edit-item'){
            // Truong hop upload hinh anh moi
            if(!empty($params['thumb'])){
                Storage::disk('project1_public')->delete('slider/' . $params['thumb_current']);
                $thumb = $params['thumb'];
                $params['thumb'] = Str::random(10) . '.' . $thumb->clientExtension();
                $thumb->storeAs('slider', $params['thumb'], 'project1_public');
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
            Storage::disk('project1_public')->delete('slider/' . $item['thumb']);
            self::where('id', $params['id'])
                ->delete();
        }
    }

    public function getItem($params = null, $option = null){
        $result = null;
        // echo $option['task'];
        // die();
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'name', 'description', 'status', 'link', 'thumb')->where('id', $params['id'])->first();
        }

        if($option['task'] == 'get-thumb'){
            $result = self::select('id', 'thumb')->where('id', $params['id'])->first();
        }
        return $result;
    }
}
