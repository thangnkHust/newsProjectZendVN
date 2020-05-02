<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class SliderRequest extends FormRequest
{   
    private $table = 'slider';
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
        $condName = "bail|required|between:5,1000|unique:$this->table,name";
        if(!empty($id)){
            $condThumb = 'bail|image';
            $condName .= ",$id";
        }
        return [
            'name' => $condName,
            'description' => 'bail|required',
            'link' => 'bail|required|min:5|url',
            'status' => 'bail|in:active,inactive',
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
            'description' => 'Feild Description: ',
            'status' => 'Feild Status: ',
            'name' => 'Feild Name: ',
            'link' => 'Feild Link: ',
        ];
    }
}
