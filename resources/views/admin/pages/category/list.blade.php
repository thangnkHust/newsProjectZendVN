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
                    <th class="column-title">Name</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Hiển thị Home</th>
                    <th class="column-title">Kiểu hiển thị</th>
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
                            $status = template::showItemStatus($controllerName, $id, $val->status);
                            $isHome = template::showItemIsHome($controllerName, $id, $val->is_home);
                            $display = template::showItemSelect($controllerName, $id, $val['display'], 'display');
                            $createdHistory = template::showItemHistory($val->created_by, $val->created);
                            $modifiedHistory = template::showItemHistory($val->modified_by, $val->modified);
                            $listButtonAction = template::showActionButton($controllerName, $id);
                        @endphp

                        <tr class="even pointer">
                            <td class="">{{$index}}</td>
        
                            <td width="20%">
                                {!!$name!!}
                            </td>

                            <td>
                                {!!$status!!}
                            </td>

                            <td>
                                {!!$isHome!!}
                            </td>

                            <td>
                                {!!$display!!}
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