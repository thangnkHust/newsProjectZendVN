<div class="sidebar_latest">
    <div class="sidebar_title">Bài viết gần đây</div>
    <div class="latest_posts">
        @php
            use App\Helpers\template as template;
            use App\Helpers\URL as URL;
            use App\Models\ArticleModel as ArticleModel;
            $articleModel = new ArticleModel();
        @endphp
        @foreach($items as $item)
            @php
                $name = $item['name'];
                $categoryName = $item->category->name;
                $thumb = asset('images/article/' . $item['thumb']);
                $linkCategory = URL::linkCategory($item->category->id, $categoryName);
                $linkArticle = URL::linkArticle($item['id'], $item['name']);;
                $created = template::showDateTimeFrontend($item['created']);

            @endphp
            <!-- Latest Post -->
            <div class="latest_post d-flex flex-row align-items-start justify-content-start">
                <div>
                    <div class="latest_post_image"><img src="{{$thumb}}" alt="{{$name}}">
                    </div>
                </div>
                <div class="latest_post_content">
                    <div class="post_category_small {{'cat_' . $articleModel->convert_vi_to_en($categoryName)}}"><a href="{{$linkCategory}}">{{$categoryName}}</a></div>
                    <div class="latest_post_title">
                        <a href="{{$linkArticle}}">{{$name}}</a>
                    </div>
                    <div class="latest_post_date">{{$created}}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>