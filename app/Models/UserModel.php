<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Storage;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $fieldSearchAccepted = [
        'id', 'username', 'email', 'fullname'
    ];

    protected $crudNotAccepted = [
        '_token', 'avatar_current', 'password_confirmation', 'task'
    ];

    public function listItems($params, $option){

        $result = null;
        if($option['task'] == 'admin-list-items'){
            // $result = SliderModel::all();
            $query = $this->select('id', 'username', 'fullname', 'email', 'avatar', 'status', 'level', 'created', 'created_by', 'modified', 'modified_by');
            
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
            $thumb = $params['avatar'];
            $params['avatar'] = Str::random(10) . '.' . $thumb->clientExtension();
            $params['created_by'] = 'thangnk';
            $params['created'] = date('Y-m-d');
            $params['id'] = self::max('id') + 1;

            $thumb->storeAs('user', $params['avatar'], 'project1_public');

            $params['password'] = md5($params['password']);

            $params = array_diff_key($params, array_flip($this->crudNotAccepted));
            self::insert($params);
        }
        // Chuc nang edit
        if($option['task'] == 'edit-item'){
            // Truong hop upload hinh anh moi
            if(!empty($params['avatar'])){
                Storage::disk('project1_public')->delete('user/' . $params['avatar_current']);
                $thumb = $params['avatar'];
                $params['avatar'] = Str::random(10) . '.' . $thumb->clientExtension();
                $thumb->storeAs('user', $params['avatar'], 'project1_public');
            }
            // Truong hop khong upload hinh anh moi
            $params['modified_by'] = 'thangnk';
            $params['modified'] = date('Y-m-d');
            $params = array_diff_key($params, array_flip($this->crudNotAccepted));
            self::where('id', $params['id'])->update($params);
        }

        // change level
        if($option['task'] == 'change-level'){
            $level = $params['currentLevel'];
            self::where('id', $params['id'])->update(['level' => $level]);
        }

        if($option['task'] == 'change-level-post'){
            $level = $params['level'];
            self::where('id', $params['id'])->update(['level' => $level]);
        }

        if($option['task'] == 'change-password'){
            $params['password'] = md5($params['password']);
            self::where('id', $params['id'])->update(['password' => $params['password']]);
        }
    }

    public function deleteItem($params = null, $option = null){
        if($option['task'] = 'delete-item'){
            $item = self::getItem($params, ['task' => 'get-avatar']);
            Storage::disk('project1_public')->delete('user/' . $item['avatar']);
            self::where('id', $params['id'])
                ->delete();
        }
    }

    public function getItem($params = null, $option = null){
        $result = null;
        // echo $option['task'];
        // die();
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'username', 'fullname', 'email', 'avatar', 'status', 'level')->where('id', $params['id'])->first();
        }

        if($option['task'] == 'get-avatar'){
            $result = self::select('id', 'avatar')->where('id', $params['id'])->first();
        }

        if($option['task'] == 'auth-login') {
            $result = self::select('id', 'username', 'fullname', 'email', 'level', 'avatar', 'status')
                        // ->where('status', 'active')
                        ->where('email', $params['email'])
                        ->where('password', md5($params['password']))->first();
        }
        return $result;
    }
}
