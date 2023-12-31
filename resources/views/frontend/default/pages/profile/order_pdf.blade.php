<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('common.documents') }}</title>
    <link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/order_pdf.css'))}}" />

</head>
<body>
    <div class="invoice_wrapper">
        <!-- invoice print part here -->
        <div class="invoice_print mb_30">
            <div class="container">
                <div class="invoice_part_iner">
                    <table class="table border_bottom mb_30">
                        <thead>
                            <tr>
                                <td>
                                    <div class="logo_img">
                                        <img src="{{showImage(app('general_setting')->logo)}}" width="150px" alt="">
                                    </div>
                                </td>
                                <td class="virtical_middle text_right invoice_info">
                                    <h4 class="text_uppercase">{{app('general_setting')->company_name}}</h4>
                                    <h4>{{app('general_setting')->phone}}</h4>
                                    <h4>{{app('general_setting')->email}}</h4>
                                    <h4>{{$order->order_number}}</h4>
                                </td>
                            </tr>
                        </thead>
                    </table>
                    <!-- middle content  -->
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                   <!-- single table  -->
                                   <table class="mb_30">
                                       <tbody>
                                           <tr>
                                               <td>
                                                   <h3 class="font_18 mb-0" >{{ __('common.billing_info') }}</h3>
                                               </td>
                                           </tr>
                                           <tr>
                                                <td>
                                                    <p class="line_grid_2" >
                                                        <span>
                                                            <span>{{ __('common.name') }}</span>
                                                            <span>:</span>
                                                        </span>
                                                        {{($order->customer_id) ? $order->address->billing_name : $order->guest_info->billing_name}}
                                                    </p>
                                                </td>
                                           </tr>
                                           <tr>
                                                <td>
                                                    <p class="line_grid_2" >
                                                        <span>
                                                            <span>{{ __('common.email') }}</span>
                                                            <span>:</span>
                                                        </span>
                                                        {{($order->customer_id) ? $order->address->billing_email : $order->guest_info->billing_email}}
                                                    </p>
                                                </td>
                                           </tr>
                                           <tr>
                                                <td>
                                                    <p class="line_grid_2" >
                                                        <span>
                                                            <span>{{ __('common.phone') }}</span>
                                                            <span>:</span>
                                                        </span>
                                                        {{($order->customer_id) ? $order->address->billing_phone : $order->guest_info->billing_phone}}
                                                    </p>
                                                </td>
                                           </tr>
                                           <tr>
                                                <td>
                                                    <p class="line_grid_2" >
                                                        <span>
                                                            <span>{{ __('common.address') }}</span>
                                                            <span>:</span>
                                                        </span>
                                                        {{($order->customer_id) ? $order->address->billing_address : $order->guest_info->billing_address}}
                                                    </p>
                                                </td>
                                           </tr>
                                           <tr>
                                                <td>
                                                    <p class="line_grid_2" >
                                                        <span>
                                                            <span>{{ __('common.city') }}</span>
                                                            <span>:</span>
                                                        </span>
                                                        {{($order->customer_id) ? @$order->address->getBillingCity->name : @$order->guest_info->getBillingCity->name}}
                                                    </p>
                                                </td>
                                           </tr>
                                           <tr>
                                                <td>
                                                    <p class="line_grid_2" >
                                                        <span>
                                                            <span>{{ __('common.state') }}</span>
                                                            <span>:</span>
                                                        </span>
                                                        {{($order->customer_id) ? @$order->address->getBillingState->name : @$order->guest_info->getBillingState->name}}
                                                    </p>
                                                </td>
                                           </tr>
                                           <tr>
                                                <td>
                                                    <p class="line_grid_2" >
                                                        <span>
                                                            <span>{{ __('common.country') }}</span>
                                                            <span>:</span>
                                                        </span>
                                                        {{($order->customer_id) ? @$order->address->getBillingCountry->name : @$order->guest_info->getBillingCountry->name}}
                                                    </p>
                                                </td>
                                           </tr>
                                       </tbody>
                                   </table>
                                   <!--/ single table  -->
                                </td>
                                <td>
                                    <!-- single table  -->
                                    <table class="mb_30">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h3 class="font_18 mb-0" >{{ __('common.company_info') }}</h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                 <td>
                                                     <p class="line_grid" >
                                                         <span>
                                                             <span>{{ __('common.name') }}</span>
                                                             <span>:</span>
                                                         </span>
                                                          {{app('general_setting')->company_name}}
                                                     </p>
                                                 </td>
                                            </tr>
                                            <tr>
                                                 <td>
                                                     <p class="line_grid" >
                                                         <span>
                                                             <span>{{ __('common.email') }}</span>
                                                             <span>:</span>
                                                         </span>
                                                        {{app('general_setting')->email}}
                                                     </p>
                                                 </td>
                                            </tr>
                                            <tr>
                                                 <td>
                                                     <p class="line_grid" >
                                                         <span>
                                                             <span>{{ __('common.phone') }}</span>
                                                             <span>:</span>
                                                         </span>
                                                         {{app('general_setting')->phone}}
                                                     </p>
                                                 </td>
                                            </tr>
                                            <tr>
                                                 <td>
                                                     <p class="line_grid" >
                                                         <span>
                                                             <span>{{ __('common.website') }}</span>
                                                             <span>:</span>
                                                         </span>
                                                         {{ app('general_setting')->website_url }}
                                                     </p>
                                                 </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--/ single table  -->
                                </td>
                            </tr>
                            <tr>
                                <td>
                                   <!-- single table  -->
                                   <table>
                                       <tbody>
                                           <tr>
                                               <td>
                                                   <h3 class="font_18 mb-0" >{{ __('shipping.shipping_info') }} @if($order->delivery_type == 'pickup_location')(Collect from Pickup location) @endif</h3>
                                               </td>
                                           </tr>
                                           <tr>
                                                <td>
                                                    <p class="line_grid_2" >
                                                        <span>
                                                            <span>{{ __('common.name') }}</span>
                                                            <span>:</span>
                                                        </span>
                                                        {{($order->customer_id) ? $order->address->shipping_name : $order->guest_info->shipping_name}}
                                                    </p>
                                                </td>
                                           </tr>
                                           <tr>
                                                <td>
                                                    <p class="line_grid_2" >
                                                        <span>
                                                            <span>{{ __('common.email') }}</span>
                                                            <span>:</span>
                                                        </span>
                                                        {{($order->customer_id) ? $order->address->shipping_email : $order->guest_info->shipping_email}}
                                                    </p>
                                                </td>
                                           </tr>
                                           <tr>
                                                <td>
                                                    <p class="line_grid_2" >
                                                        <span>
                                                            <span>{{ __('common.phone') }}</span>
                                                            <span>:</span>
                                                        </span>
                                                        {{($order->customer_id) ? $order->address->shipping_phone : $order->guest_info->shipping_phone}}
                                                    </p>
                                                </td>
                                           </tr>
                                           <tr>
                                                <td>
                                                    <p class="line_grid_2" >
                                                        <span>
                                                            <span>{{ __('common.address') }}</span>
                                                            <span>:</span>
                                                        </span>
                                                        {{($order->customer_id) ? $order->address->shipping_address : $order->guest_info->shipping_address}}
                                                    </p>
                                                </td>
                                           </tr>
                                           <tr>
                                                <td>
                                                    <p class="line_grid_2" >
                                                        <span>
                                                            <span>{{ __('common.city') }}</span>
                                                            <span>:</span>
                                                        </span>
                                                        {{($order->customer_id) ? @$order->address->getShippingCity->name : $order->guest_info->getShippingCity->name}}
                                                    </p>
                                                </td>
                                           </tr>
                                           <tr>
                                                <td>
                                                    <p class="line_grid_2" >
                                                        <span>
                                                            <span>{{ __('common.state') }}</span>
                                                            <span>:</span>
                                                        </span>
                                                        {{($order->customer_id) ? @$order->address->getShippingState->name : $order->guest_info->getShippingState->name}}
                                                    </p>
                                                </td>
                                           </tr>
                                           <tr>
                                                <td>
                                                    <p class="line_grid_2" >
                                                        <span>
                                                            <span>{{ __('common.country') }}</span>
                                                            <span>:</span>
                                                        </span>
                                                        {{($order->customer_id) ? $order->address->getShippingCountry->name : $order->guest_info->getShippingCountry->name}}
                                                    </p>
                                                </td>
                                           </tr>
                                       </tbody>
                                   </table>
                                   <!--/ single table  -->
                                </td>
                                <td>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                   <!-- single table  -->
                                                   <table class="mb_30">
                                                       <tbody>
                                                           <tr>
                                                               <td>
                                                                   <h3 class="font_18 mb-0" >{{ __('order.order_info') }}</h3>
                                                               </td>
                                                           </tr>
                                                           @if($order->customer_id == null)
                                                           <tr>
                                                                <td>
                                                                    <p class="line_grid" >
                                                                        <span>
                                                                            <span>{{ __('common.secret_id') }}</span>
                                                                            <span>:</span>
                                                                        </span>
                                                                        {{$order->guest_info->guest_id}}
                                                                    </p>
                                                                </td>
                                                           </tr>
                                                           @endif
                                                           <tr>
                                                                <td>
                                                                    <p class="line_grid" >
                                                                        <span>
                                                                            <span>{{ __('order.is_paid') }}</span>
                                                                            <span>:</span>
                                                                        </span>
                                                                        {{$order->is_paid == 1 ? 'Yes' : 'C.O.D'}}
                                                                    </p>
                                                                </td>
                                                           </tr>
                                                           @if(Auth::user()  &&  Auth::user()->is_membership )
                                                           <tr>
                                                                <td>
                                                                    <p class="line_grid" >
                                                                        <span>
                                                                            <span>{{ __('common.grand_total') }}</span>
                                                                            <span>:</span>
                                                                        </span>
                                                                       ₹ {{($order->grand_total)}}
                                                                    </p>
                                                                </td>
                                                           </tr>
                                                           @else
                                                           <tr>
                                                                <td>
                                                                    <p class="line_grid" >
                                                                        <span>
                                                                            <span>{{ __('order.subtotal') }}</span>
                                                                            <span>:</span>
                                                                        </span>
                                                                       ₹ {{($order->sub_total)}}
                                                                    </p>
                                                                </td>
                                                           </tr>
                                                           <tr>
                                                                <td>
                                                                    <p class="line_grid" >
                                                                        <span>
                                                                            <span>{{ __('common.discount') }}</span>
                                                                            <span>:</span>
                                                                        </span>
                                                                       ₹ - {{($order->discount_total)}}
                                                                    </p>
                                                                </td>
                                                           </tr>
                                                           @if($order->coupon)
                                                           <tr>
                                                                <td>
                                                                    <p class="line_grid" >
                                                                        <span>
                                                                            <span>{{ __('common.coupon') }} {{__('common.discount')}}</span>
                                                                            <span>:</span>
                                                                        </span>
                                                                       ₹ - {{($order->coupon->discount_amount)}}
                                                                    </p>
                                                                </td>
                                                           </tr>
                                                           @endif
                                                           {{-- <tr>
                                                                <td>
                                                                    <p class="line_grid" >
                                                                        <span>
                                                                            <span>{{ __('common.shipping_charge') }}</span>
                                                                            <span>:</span>
                                                                        </span>
                                                                       ₹ {{($order->shipping_total)}}
                                                                    </p>
                                                                </td>
                                                           </tr>
                                                           <tr>
                                                                <td>
                                                                    <p class="line_grid" >
                                                                        <span>
                                                                            <span>{{ __('gst.total_gst') }}</span>
                                                                            <span>:</span>
                                                                        </span>
                                                                       ₹ {{($order->tax_amount)}}
                                                                    </p>
                                                                </td>
                                                           </tr> --}}
                                                           
                                                           <tr>
                                                                <td>
                                                                    <p class="line_grid" >
                                                                        <span>
                                                                            <span>{{ __('common.grand_total') }}</span>
                                                                            <span>:</span>
                                                                        </span>
                                                                       ₹ {{($order->grand_total)}}
                                                                    </p>
                                                                </td>
                                                           </tr>
                                                           @endif
                                                       </tbody>
                                                   </table>
                                                   <!--/ single table  -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- invoice print part end -->
        <h3 class="center title_text">{{ __('order.ordered_products') }}</h3>
        @foreach ($order->packages as $key => $order_package)
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <p class="line_grid">
                                <span>
                                    <span>{{ __('common.package') }}</span>
                                    <span>:</span>
                                </span>
                                {{ $order_package->package_code }}
                            </p>
                        </td>
                        <td>
                            @if(isModuleActive('MultiVendor'))
                            <p class="line_grid_auto grid_end">
                                <span>
                                    <span>{{ __('common.shop_name') }}</span>
                                    <span>:</span>
                                </span>
                                @if($order_package->seller->role->type == 'seller'){{ (@$order_package->seller->SellerAccount->seller_shop_display_name) ? @$order_package->seller->SellerAccount->seller_shop_display_name : @$order_package->seller->first_name }} @else {{ app('general_setting')->company_name }} @endif
                            </p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @if (file_exists(base_path().'/Modules/GST/') && (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax"))
                                @foreach ($order_package->gst_taxes as $key => $gst_tax)
                                    <p class="line_grid ">
                                        <span>
                                            <span>{{ $gst_tax->gst->name }}</span>
                                            <span>:</span>
                                        </span>
                                       ₹ {{ ($gst_tax->amount) }}
                                    </p>
                                @endforeach
                            @endif
                        </td>
                        {{-- @if($order->delivery_type == 'home_delivery')
                            <td>
                                <p class="line_grid_auto grid_end">
                                    <span>
                                        <span>{{ __('shipping.shipping_method') }}</span>
                                        <span>:</span>
                                    </span>
                                    {{ $order_package->shipping->method_name }}
                                </p>
                            </td>
                        @endif --}}
                    </tr>
                </tbody>
            </table>

            <table class="table border_table mb_30" >
                <tr>
                    <th scope="col" width="30%" class="text_left">{{ __('common.name') }}</th>
                    <th scope="col" class="text_left">{{ __('common.details') }}</th>
                    <th scope="col" class="text-right">{{ __('common.price') }}</th>
                    <th scope="col" class="text-right">{{ __('common.total') }}</th>
                </tr>
                @foreach ($order_package->products as $key => $package_product)
                    <tr>
                        <td>{{ @$package_product->seller_product_sku->product->product_name??@$package_product->seller_product_sku->sku->product->product_name }}</td>
                        @if (@$package_product->seller_product_sku->sku->product->product_type == 2)
                            <td>
                                Qty: {{ $package_product->qty }}
                                <br>
                                @php
                                    $countCombinatiion = count(@$package_product->seller_product_sku->product_variations);
                                @endphp
                                @foreach (@$package_product->seller_product_sku->product_variations as $key => $combination)
                                    @if ($combination->attribute->name == 'Color')
                                        <div class="box_grid ">
                                            <span>{{ $combination->attribute->name }}:</span><span class='box' style="background-color:{{ $combination->attribute_value->value }}"></span>
                                        </div>
                                    @else
                                        {{ $combination->attribute->name }}:
                                        {{ $combination->attribute_value->value }}
                                    @endif
                                    @if ($countCombinatiion > $key + 1)
                                        <br>
                                    @endif
                                @endforeach
                            </td>
                        @else
                            <td>Qty: {{ $package_product->qty }}</td>
                        @endif

                        <td class="text-right">₹ {{ ($package_product->price) }}</td>
                        <td class="text-right">₹ {{ ($package_product->price * $package_product->qty) }}</td>
                    </tr>
                @endforeach
            </table>
            <hr>
        @endforeach
    </div>

    <script src="{{asset(asset_path('backend/js/jquery.min.js'))}}"></script>
</body>
</html>
