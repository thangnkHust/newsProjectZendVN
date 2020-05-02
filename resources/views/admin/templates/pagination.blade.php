@php

    $totalItems = $items->total();
    $totalPages = $items->lastPage();
    $totalItemsPerPage = $items->perPage();
    // echo $totalItems, $totalPages, $totalItemsPerPage;
@endphp

<div class="x_content">
    <div class="row">
        <div class="col-md-6">
            <p class="m-b-0">Số phần tử trên trang: <b>{{$totalItemsPerPage}}</b> trên <span
                    class="label label-success label-pagination">{{$totalPages}} trang</span></p>
            {{-- <p class="m-b-0">Hiển thị<b> 1 </b> đến<b> 2</b> trên<b> 6</b> Phần tử</p> --}}
        </div>
        <div class="col-md-6">
            {{$items->appends(request()->input())->links('pagination/pagination_backend', ['items' => $items])}}
        </div>
    </div>
</div>