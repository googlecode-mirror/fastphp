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
		default:
			$url = RewriteRuleDao::getOtherPage($type, $params);
			break;
	}
	echo $url;
}