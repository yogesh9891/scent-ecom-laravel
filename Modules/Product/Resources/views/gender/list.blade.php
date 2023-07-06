@foreach ($genders as $key => $gender)
    <tr class="row1" data-id="{{ $gender->id }}">
        <th class="pl-3"><i class="fa fa-sort"></i></th>
        <td>{{ $gender->name }}</td>
        <td>
            <div class="logo_div">
                @if ($gender->logo != null)
                    <img src="{{showImage($gender->logo)}}" alt="{{$gender->name}}">
                @else
                    <img src="{{showImage('frontend/default/img/gender_image.png')}}" alt="{{@$productSku->product->product_name}}">
                @endif
            </div>
        </td>
        <td>
            <label class="switch_toggle" for="checkbox{{ $gender->id }}">
                <input type="checkbox" id="checkbox{{ $gender->id }}" @if ($gender->status == 1) checked @endif value="{{ $gender->id }}" data-id="{{$gender->id}}" class="status_change">
                <div class="slider round"></div>
            </label>
        </td>
        <td>
            <label class="switch_toggle" for="active_checkbox{{ $gender->id }}">
                <input type="checkbox" id="active_checkbox{{ $gender->id }}" @if ($gender->featured == 1) checked @endif value="{{ $gender->id }}" data-id="{{$gender->id}}" class="featured_change">
                <div class="slider round"></div>
            </label>
        </td>
        <td>
            <!-- shortby  -->
            <div class="dropdown CRM_dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ __('common.select') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                    @if (permissionCheck('product.gender.edit'))
                        <a class="dropdown-item edit_gender" href="{{ route('product.gender.edit', $gender->id) }}">{{__('common.edit')}}</a>
                    @endif
                    @if (permissionCheck('product.gender.destroy'))
                        <a class="dropdown-item delete_gender" data-value="{{route('product.gender.destroy', $gender->id)}}">{{__('common.delete')}}</a>
                    @endif
                </div>
            </div>
            <!-- shortby  -->
        </td>
    </tr>
@endforeach
