<?php


function smarty_function_echo_url($params, &$smarty) {
	$type = $params['type'];
	unset($params['type']);
	switch($type) {
		case 'css':
		case 'img':
		case 'js':
		case 'file':
			$url = RewriteRuleDao::getResource($type, $params['url']);
			break;
		case 'uploadimg':
			$isSmallPic = false;
			if(isset($params['small']) && strtolower(($params['small'])) == 'yes') {
				$isSmallPic = true;
			}
			$url = RewriteRuleDao::getUploadImage($params['url'], $isSmallPic);
			break;
		case 'avaterimg':
			$url = RewriteRuleDao::getAvaterImage($params['url'], $params['sex']);
			break;
		case 'home':
			$url = RewriteRuleDao::getHomepage();
			break;
		case 'productimg':
			$url = RewriteRuleDao::getProductImage($params['ProductID'],$params['Version']);
			break;
		case 'psearch':
			if(CommonDao::isHotKeyword($params['Keyword'])) {
				$url = RewriteRuleDao::getSearchPage($params);
			} else {
				$url = RewriteRuleDao::getOtherPage($type, $params);
			}
			break;
		default:
			$url = RewriteRuleDao::getOtherPage($type, $params);
			break;
	}
	echo $url;
}