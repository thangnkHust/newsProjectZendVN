@if(count($item['related_articles']) > 0) 
    <div class="section_title_container d-flex flex-row align-items-start justify-content-start zvn-title-category">
        <div>
            <div class="section_title">Bài viết liên quan</div>
        </div>
        <div class="section_bar"></div>
    </div>


    @if($item->category->display == 'list')
        @include('news/pages/article/child_index.category_list', ['item' => $item])
    @elseif($item->category->display == 'grid')
        @include('news/pages/article/child_index.category_grid', ['item' => $item])
    @endif
@endif