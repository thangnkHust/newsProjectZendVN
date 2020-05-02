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
                    <th class="column-title">Username</th>
                    <th class="column-title">Email</th>
                    <th class="column-title">Fullname</th>
                    <th class="column-title">Level</th>
                    <th class="column-title">Avatar</th>
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
                            $username = hightlight::show($val->username, $params['search'], 'username');
                            $fullname = hightlight::show($val->fullname, $params['search'], 'fullname');
                            $email = hightlight::show($val->email, $params['search'], 'email');
                            $level = template::showItemSelect($controllerName, $id, $val->level, 'level');
                            $avatar = template::showItemThumb($controllerName, $val->avatar, $val->name);
                            $status = template::showItemStatus($controllerName, $id, $val->status);
                            $createdHistory = template::showItemHistory($val->created_by, $val->created);
                            $modifiedHistory = template::showItemHistory($val->modified_by, $val->modified);
                            $listButtonAction = template::showActionButton($controllerName, $id);
                        @endphp

                        <tr class="even pointer">
                            <td class="">{{$index}}</td>
                            <td width="10%">{!!$username!!}</td>
                            <td width="10%">{!!$email!!}</td>
                            <td width="10%">{!!$fullname!!}</td>
                            <td width="20%">{!!$level!!}</td>
                            <td width="5%">{!!$avatar!!}</td>

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