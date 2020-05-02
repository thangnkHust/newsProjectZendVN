@extends('news.main')
@section('content')

<div class="content_container">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="main_content">
                    <h3>Ban Khong Co Quyen Truy Cap!!</h3>
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

@endsection