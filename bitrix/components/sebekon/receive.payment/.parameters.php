<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock") || !CModule::IncludeModule("sebekon.psbpayment"))
	return;

$arComponentParameters = array(
    'GROUPS' => array(
		"PS" => array(
			"NAME" => GetMessage("PS"),
			"SORT" => "100",
		),
    ),
    'PARAMETERS' => array(
		'PS_KEY' => array(
			"PARENT" => "PS",
			"NAME" => GetMessage("PS_KEY"),
			"TYPE" => "STRING",
		),
    ),
);
?>
