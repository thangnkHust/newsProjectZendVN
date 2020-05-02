@php
    use App\Helpers\template as template;
    use App\Helpers\hightlight as hightlight;
@endphp


<div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Slider Info</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th>
                    <th class="column-title">Hành động</th>
                </tr>
                </thead>
                <tbody>

                @if(count($items) > 0)
                    @foreach ($items as $key => $val)
                        @php
                            $index = $key + 1;
                            $id = $val->id;
                            $name = hightlight::show($val->name, $params['search'], 'name');
                            $description = hightlight::show($val->description, $params['search'], 'description');
                            $link = hightlight::show($val->link, $params['search'], 'link');
                            $thumb = template::showItemThumb($controllerName, $val->thumb, $val->name);
                            $status = template::showItemStatus($controllerName, $id, $val->status);
                            $createdHistory = template::showItemHistory($val->created_by, $val->created);
                            $modifiedHistory = template::showItemHistory($val->modified_by, $val->modified);
                            $listButtonAction = template::showActionButton($controllerName, $id);
                        @endphp

                        <tr class="even pointer">
                            <td class="">{{$index}}</td>
        
                            <td width="40%">
                                <p><strong>Name: </strong>{!!$name!!}</p>
                                <p><strong>Description: </strong>{!!$description!!}</p>
                                <p><strong>Link: </strong>{!!$link!!}</p>
                                <p>
                                    {!!$thumb!!}
                                </p>
                            </td>

                            <td>
                                {!!$status!!}
                            </td>
        
                            <td>
                                {!!$createdHistory!!}
                            </td>
        
                            <td>
                                {!!$modifiedHistory!!}
                            </td>
        
                            <td class="last">
                                {!!$listButtonAction!!}
                            </td>
                        </tr>
                    @endforeach
                @else
                    {{-- Khong co data --}}
                    @include('admin/templates/list_empty', ['colspan' => 6])
                @endif
                
                </tbody>
            </table>
        </div>
    </div>