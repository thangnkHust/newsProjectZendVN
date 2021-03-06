{{-- Load cau hinh chung --}}
@extends('news/main')

{{-- Phan content rieng --}}
@section('content')

<div class="section-category">
    @include('news/block.breadcumb_article', ['item' => $itemArticle])
    <div class="content_container container_category">
        <div class="featured_title">
            <div class="container">
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-9">
                        <div class="single_post">
                            @include('news/pages/article/child_index.article', ['item' => $itemArticle])
                            @include('news/pages/article/child_index.related', ['item' => $itemArticle])
                        </div>
                    </div>
                    <!-- Sidebar -->
                    <div class="col-lg-3">
                        <div class="sidebar">
        
                            <!-- Latest Posts -->
                            @include('news/block.latest_post', ['items' => $itemsLatest])
        
                            <!-- Advertisement -->
                            <!-- Extra -->
                            @include('news/block/advertisement', ['itemsAdvertisement' => []])
        
                            <!-- Most Viewed -->
                            @include('news/block.most_viewed', ['itemsMostViewed' => []])
        
                            <!-- Tags -->
                            @include('news/block.tags', ['itemsTags' => []])
        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
