@if ($coupon->coupon_type == 1)
    {{ __('marketing.product_base') }}
@elseif($coupon->coupon_type == 2)
    {{ __('marketing.order_base') }}
@elseif($coupon->coupon_type == 4)
    {{ __('brand') }}
@else
    {{ __('marketing.free_shipping') }}
@endif
