<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Product;
use App\Models\OrderPackageDetail;

class OrderExport implements FromCollection, WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with('packages','customer')->get();
    }

    public function map($order): array
    {
       
    // dd($order, "order with package");
    $rowData = [];

try {
    foreach ($order->packages as $key => $order_package)
    if($order_package){

    array_push($rowData, $order->created_at->format('d-m-Y') ?? '0');
    array_push($rowData, $order->order_number ?? '0');
    $status = 'Paid';
    if($order->is_confirmed == 1){
        $status =  'Confirmed';
    }if($order->is_completed == 1){
        $status  = 'Completed';
    }if($order->is_cancelled == 1){
        $status = 'Cancelled';
    }
        array_push($rowData, $status);
        array_push($rowData, $order->customer->first_name ?? '0');
        array_push($rowData, $order->address->billing_address ?? '0');
 
    if($order_package != null){
        foreach ($order_package->products as $key => $package_product){
            foreach ($order_package->products as $key => $package_product) {
                array_push($rowData,$package_product->seller_product_sku->sku->product->brand->name ?? '0');
                array_push($rowData,$package_product->seller_product_sku->sku->product->product_name ?? '0');
                array_push($rowData,$package_product->seller_product_sku->sku->product->single_ml ?? '0'); 
            }
        }
    }

    array_push($rowData, $order_package->number_of_product ?? '0');
    array_push($rowData, $order->grand_total ?? '0');
    array_push($rowData, $order->grand_total ?? '0');
    array_push($rowData, $order->shipping_total ?? '0');
    array_push($rowData, $order->GatewayName ?? '0');
   // dd($rowData);
   return $rowData;
    
}

} catch (Exception $e) {       
    dd($e->getMessage());
   }

   return $rowData;
}

    public function headings(): array
    {
        return [
          'Order Date',
          'Order Id',
          'Order Status',
          'Customer Name',
          'Address',
          'Brand Name',
          'Product Name',
          'Size',
          'Quantity',
          'Shipping Charge',
          'Total',
          'Mode Of Payment',
          'Date Of Cod Receipt'
        ];
    }
}
