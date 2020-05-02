@php
    use App\Helpers\template;
    use App\Models\ArticleModel as ArticleModel;
    use App\Helpers\URL as URL;
    $name = $item['name'];
    $thumb = asset('images/article/' . $item['thumb']);
    $itemCategoryName = isset($item->category->name) ? $item->category->name : '';
    $itemCategoryID = isset($item->category->id) ? $item->category->id : '';
    $linkArticle = URL::linkArticle($item['id'], $item['name']);
    $linkCategory = URL::linkCategory($itemCategoryID, $itemCategoryName);

    $created = template::showDateTimeFrontend($item['created']);

    if($lengthContent === 'full'){
        $content = $item['content'];
    }else{
        $content = template::showContent($item['content'], $lengthContent);
    }
    
    $articleModel = new ArticleModel();
@endphp
<div class="post_content">
    @if($showCategory)
        <div class="post_category {{'cat_' . $articleModel->convert_vi_to_en($item->category->name)}}">
            <a href="{{$linkCategory}}">{{$item->category->name}}</a>
        </div>
    @endif
    <div class="post_title"><a href="{{ $linkArticle }}"> {{ $name }}</a></div>
    <div class="post_info d-flex flex-row align-items-center justify-content-start">
        <div class="post_author d-flex flex-row align-items-center justify-content-start">
            <div class="post_author_name"><a href="#">thangnk</a>
            </div>
        </div>
        <div class="post_date"><a href="#">{{$created}}</a></div>
    </div>

    <div class="post_text">
        <p>{!!$content!!}</p>
    </div>
</div>

