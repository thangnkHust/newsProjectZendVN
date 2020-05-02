{{-- Single post image --}}
@include('news/partials/article.image', ['item' => $item, 'type' => 'single'])

{{-- Single post content --}}
@include('news/partials/article.content', ['item' => $item, 'lengthContent' => 'full', 'showCategory' => true])