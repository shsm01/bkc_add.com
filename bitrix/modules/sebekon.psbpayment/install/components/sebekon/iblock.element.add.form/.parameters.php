<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock") || !CModule::IncludeModule("sebekon.psbpayment"))
	return;

global $APPLICATION;
	
$arCurrentValues["IBLOCK_TYPE"] = CSebekonPsbpayment::IBLOCK_CODE;
if(!$arIBlock = CIBlock::GetList(array('ID' => 'DESC'), array('ACTIVE' => 'Y', 'CODE' => CSebekonPsbpayment::IBLOCK_CODE))->Fetch()) {
	return;
}
$arCurrentValues["IBLOCK_ID"] = $arIBlock['ID'];
	
if($arCurrentValues["IBLOCK_ID"] > 0)
{
	$arIBlock = CIBlock::GetArrayByID($arCurrentValues["IBLOCK_ID"]);

	$bWorkflowIncluded = ($arIBlock["WORKFLOW"] == "Y") && CModule::IncludeModule("workflow");
	$bBizproc = ($arIBlock["BIZPROC"] == "Y") && CModule::IncludeModule("bizproc");
}
else
{
	$bWorkflowIncluded = CModule::IncludeModule("workflow");
	$bBizproc = false;
}

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock=array();
$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
{
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}

$arProperty_LNSF = array(
	"NAME" => GetMessage("IBLOCK_ADD_NAME"),
	"TAGS" => GetMessage("IBLOCK_ADD_TAGS"),
	"DATE_ACTIVE_FROM" => GetMessage("IBLOCK_ADD_ACTIVE_FROM"),
	"DATE_ACTIVE_TO" => GetMessage("IBLOCK_ADD_ACTIVE_TO"),
	"IBLOCK_SECTION" => GetMessage("IBLOCK_ADD_IBLOCK_SECTION"),
	"PREVIEW_TEXT" => GetMessage("IBLOCK_ADD_PREVIEW_TEXT"),
	"PREVIEW_PICTURE" => GetMessage("IBLOCK_ADD_PREVIEW_PICTURE"),
	//"DETAIL_TEXT" => GetMessage("IBLOCK_ADD_DETAIL_TEXT"),
	"DETAIL_PICTURE" => GetMessage("IBLOCK_ADD_DETAIL_PICTURE"),
);
$arVirtualProperties = $arProperty_LNSF;
$arExceptionProps = array(
	'ORDER_STATUS'
);
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr=$rsProp->Fetch())
{
	$arProperty[$arr["ID"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "F")) && !in_array($arr["CODE"], $arExceptionProps))
	{
		$arProperty_LNSF[$arr["ID"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}

$arGroups = array();
$rsGroups = CGroup::GetList($by="c_sort", $order="asc", Array("ACTIVE" => "Y"));
while ($arGroup = $rsGroups->Fetch())
{
	$arGroups[$arGroup["ID"]] = $arGroup["NAME"];
}

if ($bWorkflowIncluded)
{
	$rsWFStatus = CWorkflowStatus::GetList($by="c_sort", $order="asc", Array("ACTIVE" => "Y"), $is_filtered);
	$arWFStatus = array();
	while ($arWFS = $rsWFStatus->Fetch())
	{
		$arWFStatus[$arWFS["ID"]] = $arWFS["TITLE"];
	}
}
else
{
	$arActive = array("ANY" => GetMessage("IBLOCK_STATUS_ANY"), "INACTIVE" => GetMessage("IBLOCK_STATUS_INCATIVE"));
	$arActiveNew = array("N" => GetMessage("IBLOCK_ALLOW_N"), "NEW" => GetMessage("IBLOCK_ACTIVE_NEW_NEW"), "ANY" => GetMessage("IBLOCK_ACTIVE_NEW_ANY"));
}

$arAllowEdit = array("CREATED_BY" => GetMessage("IBLOCK_CREATED_BY"), "PROPERTY_ID" => GetMessage("IBLOCK_PROPERTY_ID"));

$arComponentParameters = array(
	"GROUPS" => array(
		"PARAMS" => array(
			"NAME" => GetMessage("IBLOCK_PARAMS"),
			"SORT" => "200"
		),
		"ACCESS" => array(
			"NAME" => GetMessage("IBLOCK_ACCESS"),
			"SORT" => "400",
		),
		"FIELDS" => array(
			"NAME" => GetMessage("IBLOCK_FIELDS"),
			"SORT" => "300",
		),
		"TITLES" => array(
			"NAME" => GetMessage("IBLOCK_TITLES"),
			"SORT" => "1000",
		),
		"PS" => array(
			"NAME" => GetMessage("PS"),
			"SORT" => "1100",
		),
	),

	"PARAMETERS" => array(
		"SEF_MODE" => Array(),
/*
		"IBLOCK_TYPE" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("IBLOCK_TYPE"),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arIBlockType,
			"REFRESH" => "Y",
		),

		"IBLOCK_ID" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("IBLOCK_IBLOCK"),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
		),
*/
		"PROPERTY_CODES" => array(
			"PARENT" => "FIELDS",
			"NAME" => GetMessage("IBLOCK_PROPERTY"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arProperty_LNSF,
		),

		"PROPERTY_CODES_REQUIRED" => array(
			"PARENT" => "FIELDS",
			"NAME" => GetMessage("IBLOCK_PROPERTY_REQUIRED"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "N",
			"VALUES" => $arProperty_LNSF,
		),

		"GROUPS" => array(
			"PARENT" => "ACCESS",
			"NAME" => GetMessage("IBLOCK_GROUPS"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "N",
			"VALUES" => $arGroups,
			'DEFAULT' => array(0 => '2')
		),

		"STATUS_NEW" => array(
			"PARENT" => "PARAMS",
			"NAME" => $bWorkflowIncluded? GetMessage("IBLOCK_STATUS_NEW"): ($bBizproc? GetMessage("IBLOCK_BP_NEW"): GetMessage("IBLOCK_ACTIVE_NEW")),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"VALUES" => $bWorkflowIncluded ? $arWFStatus : $arActiveNew,
		),
/*
		"STATUS" => array(
			"PARENT" => "ACCESS",
			"NAME" => $bWorkflowIncluded? GetMessage("IBLOCK_STATUS_STATUS"): GetMessage("IBLOCK_STATUS_ACTIVE"),
			"TYPE" => "LIST",
			"MULTIPLE" => $bWorkflowIncluded ? "Y" : "N",
			"VALUES" => $bWorkflowIncluded ? $arWFStatus : $arActive,
		),
	
		"LIST_URL" => array(
			"PARENT" => "PARAMS",
			"TYPE" => "TEXT",
			"NAME" => GetMessage("IBLOCK_ADD_LIST_URL"),
		),
*/

		"ELEMENT_ASSOC" => array(
			"PARENT" => "ACCESS",
			"NAME" => GetMessage("IBLOCK_ELEMENT_ASSOC"),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "N",
			"VALUES" => $arAllowEdit,
			"REFRESH" => "Y",
			"DEFAULT" => "CREATED_BY",
		),
	),
);

if ($arCurrentValues["ELEMENT_ASSOC"] == "PROPERTY_ID")
{
	$arComponentParameters["PARAMETERS"]["ELEMENT_ASSOC_PROPERTY"] = array(
		"PARENT" => "ACCESS",
		"NAME" => GetMessage("IBLOCK_ELEMENT_ASSOC_PROPERTY"),
		"TYPE" => "LIST",
		"MULTIPLE" => "N",
		"VALUES" => $arProperty,
		"ADDITIONAL_VALUES" => "Y",
	);
}

$arComponentParameters["PARAMETERS"]["MAX_USER_ENTRIES"] = array(
	"PARENT" => "ACCESS",
	"NAME" => GetMessage("IBLOCK_MAX_USER_ENTRIES"),
	"TYPE" => "TEXT",
	"DEFAULT" => "100000",
);

$arComponentParameters["PARAMETERS"]["MAX_LEVELS"] = array(
	"PARENT" => "ACCESS",
	"NAME" => GetMessage("IBLOCK_MAX_LEVELS"),
	"TYPE" => "TEXT",
	"DEFAULT" => "100000",
);

$arComponentParameters["PARAMETERS"]["LEVEL_LAST"] = array(
	"PARENT" => "ACCESS",
	"NAME" => GetMessage("IBLOCK_LEVEL_LAST"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "Y",
);

$arComponentParameters["PARAMETERS"]["USE_CAPTCHA"] = array(
	"PARENT" => "PARAMS",
	"NAME" => GetMessage("IBLOCK_USE_CAPTCHA"),
	"TYPE" => "CHECKBOX",
);
/*
$arComponentParameters["PARAMETERS"]["USER_MESSAGE_EDIT"] = array(
	"PARENT" => "PARAMS",
	"NAME" => GetMessage("IBLOCK_USER_MESSAGE_EDIT"),
	"TYPE" => "TEXT",
);

$arComponentParameters["PARAMETERS"]["USER_MESSAGE_ADD"] = array(
	"PARENT" => "PARAMS",
	"NAME" => GetMessage("IBLOCK_USER_MESSAGE_ADD"),
	"TYPE" => "TEXT",
);
*/
$arComponentParameters["PARAMETERS"]["DEFAULT_INPUT_SIZE"] = array(
	"PARENT" => "PARAMS",
	"NAME" => GetMessage("IBLOCK_DEFAULT_INPUT_SIZE"),
	"TYPE" => "TEXT",
	"DEFAULT" => 30,
);

$arComponentParameters["PARAMETERS"]["RESIZE_IMAGES"] = array(
	"PARENT" => "PARAMS",
	"NAME" => GetMessage("CP_BIEAF_RESIZE_IMAGES"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
);

$arComponentParameters["PARAMETERS"]["MAX_FILE_SIZE"] = array(
	"PARENT" => "ACCESS",
	"NAME" => GetMessage("IBLOCK_MAX_FILE_SIZE"),
	"TYPE" => "TEXT",
	"DEFAULT" => "0",
);

$arComponentParameters["PARAMETERS"]["PREVIEW_TEXT_USE_HTML_EDITOR"] = array(
	"PARENT" => "ACCESS",
	"NAME" => GetMessage("CP_BIEAF_PREVIEW_TEXT_USE_HTML_EDITOR"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
);

$arComponentParameters["PARAMETERS"]["DETAIL_TEXT_USE_HTML_EDITOR"] = array(
	"PARENT" => "ACCESS",
	"NAME" => GetMessage("CP_BIEAF_DETAIL_TEXT_USE_HTML_EDITOR"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
);

foreach ($arVirtualProperties as $key => $title)
{
	$arComponentParameters["PARAMETERS"]["CUSTOM_TITLE_".$key] = array(
		"PARENT" => "TITLES",
		"NAME" => $title,
		"TYPE" => "STRING",
	);
}


$arComponentParameters["PARAMETERS"]["PS_KEY"] = array(
	"PARENT" => "PS",
	"NAME" => GetMessage("PS_KEY"),
	"TYPE" => "STRING",
);
$arComponentParameters["PARAMETERS"]["PS_URL"] = array(
	"PARENT" => "PS",
	"NAME" => GetMessage("PS_URL"),
	"TYPE" => "STRING",
	'DEFAULT' => 'http://193.200.10.117:8080/cgi-bin/cgi_link'
);
$arComponentParameters["PARAMETERS"]["PS_CURRENCY"] = array(
	"PARENT" => "PS",
	"NAME" => GetMessage("PS_CURRENCY"),
	"TYPE" => "STRING",
	'DEFAULT' => 'RUB'
);
$arComponentParameters["PARAMETERS"]["PS_BACK"] = array(
	"PARENT" => "PS",
	"NAME" => GetMessage("PS_BACK"),
	"TYPE" => "STRING",
	'DEFAULT' => 'http://'.$_SERVER['HTTP_HOST'].'/ps.php'
);


$arComponentParameters["PARAMETERS"]["PS_DESC"] = array(
	"PARENT" => "PS",
	"NAME" => GetMessage("PS_DESC"),
	"TYPE" => "STRING",
	'DEFAULT' => ''
);
$arComponentParameters["PARAMETERS"]["PS_TERMINAL"] = array(
	"PARENT" => "PS",
	"NAME" => GetMessage("PS_TERMINAL"),
	"TYPE" => "STRING",
	'DEFAULT' => ''
);
$arComponentParameters["PARAMETERS"]["PS_MERCHANT"] = array(
	"PARENT" => "PS",
	"NAME" => GetMessage("PS_MERCHANT"),
	"TYPE" => "STRING",
	'DEFAULT' => ''
);
$arComponentParameters["PARAMETERS"]["PS_MERCHANT_NAME"] = array(
	"PARENT" => "PS",
	"NAME" => GetMessage("PS_MERCHANT_NAME"),
	"TYPE" => "STRING",
	'DEFAULT' => ''
);
$arComponentParameters["PARAMETERS"]["PS_EMAIL"] = array(
	"PARENT" => "PS",
	"NAME" => GetMessage("PS_EMAIL"),
	"TYPE" => "STRING",
	'DEFAULT' => ''
);

?>