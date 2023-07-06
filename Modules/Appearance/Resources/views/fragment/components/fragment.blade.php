
<div class="row">
    <div class="col-lg-12">
        <table class="table Crm_table_active3">
            <thead>
                <tr>
                    <th scope="col" class=" text-center">S.N.</th>
                    <th  scope="col" class="">Name</th>
                    <th  scope="col" class="">Email</th>
                    <th  scope="col" class="">Phone</th>
                    <th  scope="col" class="">Brand</th>
                    <th  scope="col" class="">Item</th>
                    <th  scope="col" class="">Size</th>
                    <th  scope="col" class="">Message</th>
                    <th  scope="col" class="">Delete</th>
                </tr>
            </thead>
            <tbody id="sku_tbody">
                @foreach($getFragments as $key => $getFragment)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$getFragment->name}}</td>
                    <td>{{$getFragment->email}}</td>
                    <td>{{$getFragment->phone}}</td>
                    <td>{{$getFragment->brand}}</td>
                    <td>{{$getFragment->item}}</td>
                    <td>{{$getFragment->size}}</td>
                    <td>{{$getFragment->message}}</td>
                    <td>
                        <a href="{{url('appearance/delete',$getFragment->id)}}" >Delete</a>
                    </td>
                </tr>  
                @endforeach
            </tbody>
        </table>
    </div>
</div>

