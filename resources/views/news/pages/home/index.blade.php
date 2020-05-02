{{-- Load cau hinh chung --}}
@extends('news/main')

{{-- Phan content rieng --}}
@section('content')

<!-- Home -->
@include('news/block/slider')
<!-- Content Container -->
<div class="content_container">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="main_content">
                    <!-- Featured -->
                    {{-- Bien tu truyen vao cac subview --}}
                    @include("news/block.featured", ['items' => $itemsFeature])
                    {{-- @include("news/block.featured") --}}

                    <!-- Category -->
                    @include('news/pages/home/child_index.category')
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
