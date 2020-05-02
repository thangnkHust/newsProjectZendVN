@if($item['display'] == 'list')
    {{-- Kieu list --}}
    @include('news/pages/category/child_index.category_list')
@elseif($item['display'] == 'grid')
    {{-- Kieu grid --}}
    @include('news/pages/category/child_index.category_grid')
@endif
