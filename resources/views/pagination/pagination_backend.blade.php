@if ($items->lastPage() > 1)
    <ul class="pagination" style="float: right">
        @if($items->currentPage() == 1)
            <li class="disabled">
                <a>Previous</a>
            </li>
        @else
            <li>
                {{-- {{ $items->url($items->currentPage()-1) }} --}}
                <a href="{{ $items->url($items->currentPage()-1) }}" class="page">Previous</a>
            </li>
        @endif
        @for ($i = 1; $i <= $items->lastPage(); $i++)
            <li class="{{ ($items->currentPage() == $i) ? ' active' : '' }}">
                <a href="{{$items->url($i)}}" class="page">Page{{ $i }}</a>
            </li>
        @endfor
        @if($items->currentPage() == $items->lastPage())
            <li class="disabled">
                <a >Next</a>
            </li>
        @else
            <li>
                <a href="{{ $items->url($items->currentPage()+1) }}" class="page">Next</a>
            </li>
        @endif
    </ul>
@endif