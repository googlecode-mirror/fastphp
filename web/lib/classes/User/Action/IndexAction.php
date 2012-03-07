<?php 
class Product_IndexAction extends BaseAction
{
	public function doGetPrdmsgAction()
	{
		$proArray = array(
			'prdID' => '334343',
			'prdName' => '佳丰高支棉被套现代生活 200*230cm', 
			'prdPrice' => '130.00',
			'shipping' => '6.00', 
			'fromMerchant' => '及金额发',
			'fromSite' => '简单快速减肥',
			'orderUrl' => 'http://wwwdd.ddo.com'
		);		
		echo json_encode($proArray);
	}
}
?>