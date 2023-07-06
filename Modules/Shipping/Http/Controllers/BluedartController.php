<?php

namespace Modules\Shipping\Http\Controllers;
use App\Http\Controllers\Controller;
use Modules\Shipping\Services\BlueDart\DebugSoapClient;

use Request;
use SoapHeader;

class BluedartController extends Controller
{
    public $pickupRequest = [];
    public $result ;
    
    public function checkPincode($pincode=0){
                $soap = new DebugSoapClient('https://netconnect.bluedart.com/Ver1.10/ShippingAPI/Finder/ServiceFinderQuery.svc?wsdl',
                    array(
                    'trace'  => 1,
                    'style'  => SOAP_DOCUMENT,
                    'use'   => SOAP_LITERAL,
                    'soap_version'=> SOAP_1_2
                    ));

                    $soap->__setLocation("https://netconnect.bluedart.com/Ver1.10/ShippingAPI/Finder/ServiceFinderQuery.svc?wsdl");

                    $soap->sendRequest = true;
                    $soap->printRequest = false;
                    $soap->formatXML = true;

                    $actionHeader = new SoapHeader('http://www.w3.org/2005/08/addressing','Action','http://tempuri.org/IServiceFinderQuery/GetServicesforPincode',true);
                    $soap->__setSoapHeaders($actionHeader);

                    $params = array('pinCode' => $pincode,
                        'profile' =>
                         array(
                            'Api_type' => 'M',
                            'Customercode'=>'',
                            'IsAdmin'=>'',
                            'LicenceKey'=>'1qtrpmppmspkuemzfo0s75grikkpiquj',
                            'LoginID'=>'BOM18156',
                            'Password'=>'',
                            'Version'=>'2')
                            );

// Here I call my external function
            $result = $soap->__soapCall('GetServicesforPincode',array($params));
                #echo "<br>";
            // dd($result);

               /*$log = new Bluedartlog;
                $log->request = json_encode($params);
                $log->response = json_encode($result->GetServicesforPincodeResult);
                $log->errormesssage = $result->GetServicesforPincodeResult->ErrorMessage;
                $log->save(); */ 
                /* for debug */
                // echo '<pre>';
                // print_r(print_r($result));exit;
                return $result->GetServicesforPincodeResult ?? '';
    }

    // public function createPickup($pickupDatas){
    //     // dd($pickupDatas);
    //    // $name = $pickupData->email;
    //    $soap = new DebugSoapClient('https://netconnect.bluedart.com/Ver1.10/ShippingAPI/Pickup/PickupRegistrationService.svc?wsdl',
    //     array(
    //         'trace'   => 1,
    //         'style'    => SOAP_DOCUMENT,
    //         'use'        => SOAP_LITERAL,
    //         'soap_version'  => SOAP_1_2
    //     ));

    //    $soap->__setLocation("https://netconnect.bluedart.com/Ver1.10/ShippingAPI/Pickup/PickupRegistrationService.svc?wsdl");

    //    $soap->sendRequest = true;
    //    $soap->printRequest = false;
    //    $soap->formatXML = true;

    //    $actionHeader = new SoapHeader('http://www.w3.org/2005/08/addressing','Action','http://tempuri.org/IPickupRegistration/RegisterPickup',true);
    //    $soap->__setSoapHeaders($actionHeader);
    //    // dd($pickupData->name);
    // $params = array(
    // 'request' => 
    //         array (
    //                 'AreaCode' => 'BOM',
    //                 'ContactPersonName' => $pickupDatas['name'],
    //                 'CustomerAddress1' => $pickupDatas['address'],
    //                 'CustomerAddress2' => $pickupDatas['address'],
    //                 'CustomerAddress3' => $pickupDatas['address'],
    //                 'CustomerCode' => '408494',
    //                 'CustomerName' => $pickupDatas['name'],
    //                 'CustomerPincode' => $pickupDatas['postal_code'],
    //                 'CustomerTelephoneNumber' => $pickupDatas['phone'],
    //                 'DoxNDox' => '1',
    //                 'EmailID' => $pickupDatas['email'],
    //                 'MobileTelNo' => $pickupDatas['phone'],
    //                 'NumberofPieces' => '1',
    //                 'OfficeCloseTime' => '16:00',
    //                 'ProductCode' => 'A',
    //                 'ReferenceNo' => time(),
    //                 'Remarks' => 'TEST',
    //                 'RouteCode' => '99',
    //                 'ShipmentPickupDate' => date('Y-m-d'),
    //                 'ShipmentPickupTime' => '1600',
    //                 'VolumeWeight' => '1.2',
    //                 'WeightofShipment' => '1.2',
    //                 'isToPayShipper' => 'false'),
    //         'profile' =>
    //          array(
    //             'Api_type' => 'S',
    //             'LicenceKey' =>'1qtrpmppmspkuemzfo0s75grikkpiquj',
    //             'LoginID' =>'BOM18156',
    //             'Version' =>'1.3')
    //             );$soap = new DebugSoapClient('https://netconnect.bluedart.com/Ver1.10/ShippingAPI/WayBill/WayBillGeneration.svc?wsdl',
    //             array(
    //             'trace'   => 1,  
    //             'style'     => SOAP_DOCUMENT,
    //             'use'         => SOAP_LITERAL,
    //             'soap_version'  => SOAP_1_2
    //             ));
                
    //             $soap->__setLocation("https://netconnect.bluedart.com/Ver1.10/ShippingAPI/WayBill/WayBillGeneration.svc?wsdl");
                
    //             $soap->sendRequest = true;
    //             $soap->printRequest = false;
    //             $soap->formatXML = true; 
                
    //             $actionHeader = new SoapHeader('http://www.w3.org/2005/08/addressing','Action','http://tempuri.org/IWayBillGeneration/GenerateWayBill',true);
    //             $soap->__setSoapHeaders($actionHeader);

    //     $result = $soap->__soapCall('RegisterPickup',array($params));
    //     // dd($result);
    //     return $result->GetServicesforPickupResult ?? '';
    // }


public function wayBillService($wayBillService)
  {
    $soap = new DebugSoapClient('https://netconnect.bluedart.com/Ver1.10/ShippingAPI/WayBill/WayBillGeneration.svc?wsdl',
    array(
    'trace'    => 1,  
    'style'    => SOAP_DOCUMENT,
    'use'       => SOAP_LITERAL,
    'soap_version'   => SOAP_1_2
    ));
                
    $soap->__setLocation("https://netconnect.bluedart.com/Ver1.10/ShippingAPI/WayBill/WayBillGeneration.svc?wsdl");
                
    $soap->sendRequest = true;
    $soap->printRequest = false;
    $soap->formatXML = true; 
                
    $actionHeader = new SoapHeader('http://www.w3.org/2005/08/addressing','Action','http://tempuri.org/IWayBillGeneration/GenerateWayBill',true);
    $soap->__setSoapHeaders($actionHeader);

    $params = array(
        'Request' => 
    array (
        'Consignee' =>
            array (
                'ConsigneeAddress1' => $wayBillService['address'],
                'ConsigneeAddress2' => $wayBillService['address'],
                'ConsigneeAddress3' => $wayBillService['address'],
                'ConsigneeAttention' => 'A',
                'ConsigneeMobile'  => $wayBillService['phone'],
                'ConsigneeName'  => $wayBillService['name'],
                'ConsigneePincode' => $wayBillService['postal_code'],
                'ConsigneeTelephone' => $wayBillService['phone'],
            )   ,
        'Services' => 
            array (
                'ActualWeight' => '1',
                'CollectableAmount' => '0',
                'Commodity' =>
                    array (
                        'CommodityDetail1' => 'PRETTYSECRETS Dark Blue  Allure',
                        'CommodityDetail2'  => ' Aultra Boost Mutltiway Push Up ',                      
                        'CommodityDetail3' => 'Bra'
                ),
                'CreditReferenceNo' => time(),
                'DeclaredValue' => '1000',
                'Dimensions' =>
                    array (
                    'Dimension' =>
                        array (
                            'Breadth' => '1',
                            'Count' => '1',
                            'Height' => '1',
                            'Length' => '1'
                            ),
                    ),
                    'InvoiceNo' => '',
                    'PackType' => '',
                    'PickupDate' => date('Y-m-d'),
                    'PickupTime' => '1800',
                    'PieceCount' => '1',
                    'ProductCode' => 'A',
                    'ProductType' => 'Dutiables',
                    'SpecialInstruction' => '1',
                    'SubProductCode' => 'C',
                    'PDFOutputNotRequired'=>false,
                    'RegisterPickup'=>true,
                    'PickupMode'=>'P'
            ),
            'Shipper' =>
                array(
                    'CustomerAddress1' => 'BLUE DART EXPRESS LTD. BLUE DART CENTRE SAHAR AIRPORT ROAD ANDHERI EAST',
                    'CustomerAddress2' => 'BLUE DART EXPRESS LTD. BLUE DART CENTRE SAHAR AIRPORT ROAD ANDHERI EAST',
                    'CustomerAddress3' => 'BLUE DART EXPRESS LTD. BLUE DART CENTRE SAHAR AIRPORT ROAD ANDHERI EAST',
                    'CustomerCode' => '408494',
                    'CustomerEmailID' => 'csbom@bluedart.com',
                    'CustomerMobile' => '79034111122',
                    'CustomerName' => 'Blue Dart',
                    'CustomerPincode' => '400099',
                    'CustomerTelephone' => '1860 233 1234',
                    'IsToPayCustomer' => false,
                    'OriginArea' => 'BOM',
                    'Sender' => '1',
                    'VendorCode' => ''
                )
            ),

    'Profile' => 
        array(
          'Api_type' => 'S',
          'Customercode'=>'',
          'IsAdmin'=>'',
          'LicenceKey'=>'1qtrpmppmspkuemzfo0s75grikkpiquj',
          'LoginID'=>'BOM18156',
          'Password'=>'',
          'Version'=>'2')
        );

#echo "<br>";
#echo '<h2>Parameters</h2><pre>'; print_r($params); echo '</pre>';

// Here I call my external function
$result = $soap->__soapCall('GenerateWayBill',array($params));
// dd($result);
// dd($result->GenerateWayBillResult['AWBNo']);
// dd($result->GenerateWayBillResult->AWBNo);
#echo "Generated Waybill number " + $result->GenerateWayBillResult->AWBNo;
#echo $result->GenerateWayBillResult->Status->WayBillGenerationStatus->StatusInformation 
return $result ;
// echo "<br>";
echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';

  }

}
