<div class="product_thumb_div">
    @if (@$products->gallary_images->first()->images_source)
        <img class="productImg" src="{{showImage(@$products->gallary_images->first()->images_source)}}" alt="{{@$products->product_name}}">
    @else
        <img class="productImg" src="{{showImage('backend/img/default.png')}}" alt="{{@$products->product_name}}">
    @endif
</div>
