<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentDescription = array(
	"NAME" => GetMessage("FORUM_POST_FORM"),
	"DESCRIPTION" => GetMessage("FORUM_POST_FORM_DESCRIPTION"), 
	"ICON" => "/images/icon.gif",
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "communication",
		"CHILD" => array(
			"ID" => "forum",
			"NAME" => GetMEssage("FORUM")
		)
	),
);
?>