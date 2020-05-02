<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class CategoryRequest extends FormRequest
{   
    private $table = 'category';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {   
        $id = $this->id;
        $condName = "bail|required|between:5,100|unique:$this->table,name";
        if(!empty($id)){
            $condName .= ",$id";
        }
        return [
            'name' => $condName,
            'status' => 'bail|in:active,inactive',
            'is_home' => 'bail|in:1,0',
            'display' => 'bail|in:list,grid',
        ];
    }

    public function messages(){
        return [

        ];
    }

    public function attributes()
    {
       return [
            'status' => 'Feild Status: ',
            'name' => 'Feild Name: ',
            'is_home' => 'Feild Is Home: ',
            'display' => 'Feild Display: ',
        ];
    }
}
