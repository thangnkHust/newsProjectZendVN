<?php

namespace App\Helpers;
use Illuminate\Support\Str;

class URL{
    public static function linkCategory($id, $name){
        return route('categoryNews/index', [
            'category_id' => $id,
            'category_name' => Str::slug($name, '_')
        ]);
    }

    public static function linkArticle($id, $name){
        return route('articleNews/index', [
            'article_id' => $id,
            'article_name' => Str::slug($name, '_')
        ]);
    }
}