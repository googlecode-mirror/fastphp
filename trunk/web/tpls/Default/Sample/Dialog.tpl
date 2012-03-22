<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
{*
<link href="/res/css/global.css" rel="stylesheet" />
<-- 
*}
{load_css
	file1='global.css'
	file2='jquery-ui/jquery.ui.base.css'
	file3='jquery-ui/jquery.ui.dialog.css'
}
{load_js
	 file1='jquery.js'
	 file2='plugins/jquery.ui.core.js'
	 file2='plugins/jquery.ui.dialog.js'
}
{* --> *}
<script>
{literal}
$(function() {
	// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$( "#dialog-message" ).dialog({
		modal: true,
		buttons: {
			Ok: function() {
				$( this ).dialog( "close" );
			}
		}
	});
});
{/literal}
</script>
</head>

<body>
{include file="Default/Include/Header.tpl"}

<div id="dialog-message" title="Download complete">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		Your files have downloaded successfully into the My Downloads folder.
	</p>
	<p>
		Currently using <b>36% of your storage space</b>.
	</p>
</div>

{include file="Default/Include/Footer.tpl"}
</body>
</html>