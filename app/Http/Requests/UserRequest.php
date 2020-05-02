<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class UserRequest extends FormRequest
{   
    private $table = 'user';
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

        $task = $this->task;
        $id = $this->id;
        $condAvatar = '';
        $condUsername = '';
        $condEmail = '';
        $condPassword = '';
        $condLevel = '';
        $condStatus = '';
        $condFullname = '';

        switch($task){
            case 'add':
                $condUsername = "bail|required|between:5,1000|unique:$this->table,username";
                $condEmail = "bail|required|unique:$this->table,email";
                $condFullname = 'bail|required|min:5';
                $condPassword = 'bail|required|between:5,100|confirmed';
                $condStatus = 'bail|in:active,inactive';
                $condLevel = 'bail|in:admin,member';
                $condAvatar = 'bail|required|image|max:500';
                break;
            case 'edit-info':
                $condUsername = "bail|required|between:5,1000|unique:$this->table,username,$id";
                $condEmail = "bail|required|unique:$this->table,email,$id";
                $condFullname = 'bail|required|min:5';
                $condStatus = 'bail|in:active,inactive';
                $condAvatar = 'bail|image|max:500';
                break;
            case 'change_password':
                $condPassword = 'bail|required|between:5,100|confirmed';
                break;
            case 'change_level':
                $condLevel = 'bail|in:admin,member';
                break;
        }

        return [
            'username' => $condUsername,
            'email' => $condEmail,
            'fullname' => $condFullname,
            'password' => $condPassword,
            'level' => $condLevel,
            'status' => $condStatus,
            'avatar' => $condAvatar
        ];
    }

    public function messages(){
        return [

        ];
    }

    public function attributes()
    {
        return [
            
        ];
    }
}
