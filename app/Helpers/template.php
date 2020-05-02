<?php
namespace App\Helpers;
use Config;

class Template{

    public static function showAreaSearch($controllerName, $paramsSearch){
        $xhtml = null;
        // template search dat trong config.test
        $templateField = \config('test.template.search');
        // Tuy vao controllerName co field khac nhau
        $fieldInController = \config('test.config.search');

        $controllerName = (array_key_exists($controllerName, $fieldInController)) ? $controllerName : 'default';

        $xhtmlField = null;

        foreach($fieldInController[$controllerName] as $field){
            $xhtmlField .= \sprintf('
                <li>
                    <a href="#" class="select-field" data-field="%s">
                        %s
                    </a>
                </li>
            ', $field, $templateField[$field]['name']);
        }

        $searchField = in_array($paramsSearch['field'], $fieldInController[$controllerName]) ? $paramsSearch['field'] : 'all';

        $xhtml = \sprintf('
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle btn-active-field" data-toggle="dropdown" aria-expanded="false">
                        %s
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        %s
                    </ul>
                </div>
                <input type="hidden" name="search_field" value="%s">
                <input type="text" class="form-control" name="search_value" value="%s">
                <span class="input-group-btn">
                    <button id="btn-clear-search" type="button" class="btn btn-success" style="margin-right: 0px">Xóa tìm kiếm</button>
                    <button id="btn-search" type="button" class="btn btn-primary">Tìm kiếm</button>
                </span>
            </div>
        ', $templateField[$searchField]['name'], $xhtmlField, $searchField, $paramsSearch['value']);

        return $xhtml;
    }

    public static function showButtonFilter($controllerName, $itemsStatusCount, $currentFilterStatus, $paramsSearch){
        $xhtml = '';
        // print_r ($itemsStatusCount);
        $templateStatus = Config::get('test.template.status');
        if (count($itemsStatusCount) > 0){
            array_unshift($itemsStatusCount, [
                'count' => array_sum(\array_column($itemsStatusCount, 'count')),
                'status' => 'all'
            ]);
            foreach($itemsStatusCount as $value){   //$value = [count, status]
                $statusValue = array_key_exists($value['status'], $templateStatus) ? $value['status']:'default';
                $currentStatus = $templateStatus[$statusValue];

                $link = \route($controllerName) . '?filter_status=' . $statusValue;

                // Kiem tra co dang search ? by $paramsSearch
                if($paramsSearch != ''){
                    $link .= "&search_field=" . $paramsSearch['field'] . "&search_value=" . $paramsSearch['value'];
                }

                $class = ($currentFilterStatus == $statusValue)?'btn-danger':'btn-primary';
                $xhtml .= sprintf('
                    <a href="%s" type="button" class="btn %s">
                        %s <span class="badge bg-white">%s</span>
                    </a>
                ', $link, $class, $currentStatus['name'], $value['count']);
            }
            
        }
            
        return $xhtml;
    }


    public static function showItemHistory($by, $time){
        $xhtml = sprintf(
            '<p><i class="fa fa-user"></i> %s</p>
            <p><i class="fa fa-clock-o"></i> %s</p>', $by, date(config('test.format.short_time'), strtotime($time)));
        return $xhtml;
    }

    public static function showItemStatus($controllerName, $id, $status){
        $templateStatus = Config::get('test.template.status');
        // Check status 
        $statusValue = array_key_exists($status, $templateStatus) ? $status:'default';

        $currentStatus = $templateStatus[$statusValue];
        $link = route($controllerName . '/status', ['status' => $status, 'id' => $id] );

        $xhtml = sprintf(
            '<a href="%s" type="button" class="btn btn-round %s">%s</a>', $link, $currentStatus['class'], $currentStatus['name']);
        return $xhtml;
    }

    public static function showItemIsHome($controllerName, $id, $isHome){
        $templateIsHome = Config::get('test.template.is_home');
        // Check status 
        $isHomeValue = array_key_exists($isHome, $templateIsHome) ? $isHome:'1';

        $currentIsHome = $templateIsHome[$isHomeValue];
        $link = route($controllerName . '/isHome', ['isHome' => $isHome, 'id' => $id] );

        $xhtml = sprintf(
            '<a href="%s" type="button" class="btn btn-round %s">%s</a>', $link, $currentIsHome['class'], $currentIsHome['name']);
        return $xhtml;
    }

    public static function showItemSelect($controllerName, $id, $display, $fieldName){
        $templateDisplay = Config::get('test.template.' . $fieldName);
        $link = route($controllerName . '/' . $fieldName, [$fieldName => 'value-new', 'id' => $id]);
        
        $xhtml = \sprintf('<select name="select-change-attr" data-url="%s" class="form-control">', $link);
        foreach ($templateDisplay as $key => $value) {
            $xhtmlSelected = '';
            if($key == $display){
                $xhtmlSelected = 'selected = "selected"';
            }
            $xhtml .= \sprintf('<option value="%s" %s>%s</option>', $key, $xhtmlSelected, $value['name']);
        }
        
        $xhtml .= '</select>';
        return $xhtml;
    }

    public static function showItemThumb($controllerName, $thumbName, $thumbAlt){
        // echo asset('image/slider/' . $thumbName);
        $xhtml = sprintf(
            '<img src= "%s" alt= "%s" style = "width: 100%%">',  asset("images/$controllerName/$thumbName") , $thumbAlt );
        return $xhtml;
    }

    public static function showActionButton($controllerName, $id){
        $templateButton = \config('test.template.button');

        $buttonInArea = \config('test.config.button');

        $controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName:'default';
        $listButton = $buttonInArea[$controllerName];

        $xhtml = '<div class="zvn-box-btn-filter">';
        foreach($listButton as $btn){
            $currentButton = $templateButton[$btn];
            $link = route($controllerName . $currentButton['route-name'], ['id' => $id]);
            $xhtml .= sprintf('
            <a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top" data-original-title="%s">
                <i class="fa %s"></i>
            </a>
            ', $link, $currentButton['class'], $currentButton['title'], $currentButton['icon']);
        }
        $xhtml .= '</div>';
        return $xhtml;
    }

    public static function showDateTimeFrontend($dateTime){
        return date_format(\date_create($dateTime), Config::get('test.format.short_time'));
    }

    public static function showContent($content, $length, $prefix = '...'){
        $prefix = ($length == 0) ? '':$prefix;
        $content = \str_replace(['<p>', '</p>'], '', $content);
        return preg_replace('/\s+?(\S+)?$/', '', substr($content, 0, $length)) . $prefix;
    }
}

