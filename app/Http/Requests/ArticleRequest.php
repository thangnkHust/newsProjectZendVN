<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ArticleRequest extends FormRequest
{   
    private $table = 'article';
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
        $condThumb = 'bail|required|image';
        $condName = "bail|required|between:5,100|unique:$this->table,name";
        if(!empty($id)){
            $condThumb = 'bail|image';
            $condName .= ",$id";
        }
        return [
            'name' => $condName,
            'content' => 'bail|required|min:5',
            'status' => 'bail|in:active,inactive',
            // 'category' => 'bail|in:',
            'thumb' => $condThumb
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
            'content' => 'Feild Content: ',
            'thumb' => 'Feild Thumb: ',
        ];
    }
}
