<?php 


				$soap = new DebugSoapClient('https://netconnect.bluedart.com/Ver1.10/ShippingAPI/WayBill/WayBillGeneration.svc?wsdl',
				array(
				'trace' 							=> 1,  
				'style'								=> SOAP_DOCUMENT,
				'use'									=> SOAP_LITERAL,
				'soap_version' 				=> SOAP_1_2
				));
				
				$soap->__setLocation("https://netconnect.bluedart.com/Ver1.10/ShippingAPI/WayBill/WayBillGeneration.svc?wsdl");
				
				$soap->sendRequest = true;
				$soap->printRequest = false;
				$soap->formatXML = true; 
				
				$actionHeader = new SoapHeader('http://www.w3.org/2005/08/addressing','Action','http://tempuri.org/IWayBillGeneration/GenerateWayBill',true);
				$soap->__setSoapHeaders($actionHeader);	
		#echo "end of Soap 1.2 version (WSHttpBinding)  setting";


$params = array(
'Request' => 
	array (
		'Consignee' =>
			array (
				'ConsigneeAddress1' => 'A',
				'ConsigneeAddress2' => 'A',
				'ConsigneeAddress3'=> 'A',
				'ConsigneeAttention'=> 'A',
				'ConsigneeMobile'=> '1234567890',
				'ConsigneeName'=> 'Asdf',
				'ConsigneePincode'=> '110056',
				'ConsigneeTelephone'=> '1234567890',
			)	,
		'Services' => 
			array (
				'ActualWeight' => '1',
				'CollectableAmount' => '0',
				'Commodity' =>
					array (
						'CommodityDetail1' => 'PRETTYSECRETS Dark Blue 	Allure',
						'CommodityDetail2'  => ' Aultra Boost Mutltiway Push Up ',						
						'CommodityDetail3' => 'Bra'
				),
				'CreditReferenceNo' => '105',
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
					'PickupDate' => '2022-11-11',
					'PickupTime' => '1800',
					'PieceCount' => '1',
					'ProductCode' => 'A',
					'ProductType' => 'Dutiables',
					'SpecialInstruction' => '1',
					'SubProductCode' => ''
			),
			'Shipper' =>
				array(
					'CustomerAddress1' => 'sadf',
					'CustomerAddress2' => 'sadf',
					'CustomerAddress3' => 'sadf',
					'CustomerCode' => '408494',
					'CustomerEmailID' => 'a@b.com',
					'CustomerMobile' => '1234567890',
					'CustomerName' => 'ashish',
					'CustomerPincode' => '400004',
					'CustomerTelephone' => '1234567890',
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

// Here I call my external function
$result = $soap->__soapCall('GenerateWayBill',array($params));
 dd($result);
#echo "Generated Waybill number " + $result->GenerateWayBillResult->AWBNo;
#echo $result->GenerateWayBillResult->Status->WayBillGenerationStatus->StatusInformation 

echo "<br>";
// echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
 
class DebugSoapClient extends SoapClient {
  public $sendRequest = true;
  public $printRequest = true;
  public $formatXML = true;

  public function __doRequest($request, $location, $action, $version, $one_way=0) {
    if ( $this->printRequest ) {
      if ( !$this->formatXML ) {
        $out = $request;
      }
      else {
        $doc = new DOMDocument;
        $doc->preserveWhiteSpace = false;
        $doc->loadxml($request);
        $doc->formatOutput = true;
        $out = $doc->savexml();
      }
      echo $out;
    }

    if ( $this->sendRequest ) {
      return parent::__doRequest($request, $location, $action, $version, $one_way);
    }
    else {
      return '';
    }
  }
}