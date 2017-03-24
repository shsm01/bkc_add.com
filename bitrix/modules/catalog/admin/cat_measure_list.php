<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/catalog/prolog.php");
global $APPLICATION;
global $DB;
global $USER;

if(!($USER->CanDoOperation('catalog_read') || $USER->CanDoOperation('catalog_store')))
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
CModule::IncludeModule("catalog");
$bReadOnly = !$USER->CanDoOperation('catalog_store');

IncludeModuleLangFile(__FILE__);

$bCanAdd = true;
$bExport = false;
if($_REQUEST["mode"] == "excel")
	$bExport = true;

if($ex = $APPLICATION->GetException())
{
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

	$strError = $ex->GetString();
	ShowError($strError);

	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
	die();
}

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/catalog/prolog.php");

$sTableID = "b_catalog_measure";
$oSort = new CAdminSorting($sTableID, "ID", "asc");
$lAdmin = new CAdminList($sTableID, $oSort);
$arFilterFields = array();
$lAdmin->InitFilter($arFilterFields);
$arFilter = array();

if($lAdmin->EditAction() && !$bReadOnly)
{
	foreach ($_POST['FIELDS'] as $ID => $arFields)
	{
		$ID = (int)$ID;

		if ($ID <= 0 || !$lAdmin->IsUpdated($ID))
			continue;

		$DB->StartTransaction();
		if (!CCatalogMeasure::update($ID, $arFields))
		{
			if($ex = $APPLICATION->GetException())
				$lAdmin->AddUpdateError($ex->GetString(), $ID);
			else
				$lAdmin->AddUpdateError(GetMessage("ERROR_UPDATING_REC")." (".$arFields["ID"].", ".$arFields["TITLE"].", ".$arFields["SORT"].")", $ID);

			$DB->Rollback();
		}
		else
		{
			$DB->Commit();
		}
	}
}

if(($arID = $lAdmin->GroupAction()) && !$bReadOnly)
{
	if($_REQUEST['action_target']=='selected')
	{
		$arID = Array();
		$dbResultList = CCatalogMeasure::getList(array($_REQUEST["by"] => $_REQUEST["order"]), $arFilter, false, false, array('ID'));
		while($arResult = $dbResultList->Fetch())
			$arID[] = $arResult['ID'];
	}

	foreach ($arID as $ID)
	{
		if(strlen($ID) <= 0)
			continue;

		switch ($_REQUEST['action'])
		{
			case "delete":
				@set_time_limit(0);
				$DB->StartTransaction();
				if(!CCatalogMeasure::delete($ID))
				{
					$DB->Rollback();

					if($ex = $APPLICATION->GetException())
						$lAdmin->AddGroupError($ex->GetString(), $ID);
					else
						$lAdmin->AddGroupError(GetMessage("ERROR_DELETING_TYPE"), $ID);
				}
				else
				{
					$DB->Commit();
				}
				break;
		}
	}
}
$arSelect = array(
	"ID",
//	"CODE",
	"MEASURE_TITLE",
	"SYMBOL_RUS",
	"SYMBOL_INTL",
	"SYMBOL_LETTER_INTL",
	"IS_DEFAULT",
);

if(array_key_exists("mode", $_REQUEST) && $_REQUEST["mode"] == "excel")
	$arNavParams = false;
else
	$arNavParams = array("nPageSize"=>CAdminResult::GetNavSize($sTableID));

$dbResultList = CCatalogMeasure::getList(
	array($_REQUEST["by"] => $_REQUEST["order"]),
	array(),
	false,
	$arNavParams,
	$arSelect
);
$dbResultList = new CCatalogMeasureAdminResult($dbResultList, $sTableID);
$dbResultList->NavStart();
$lAdmin->NavText($dbResultList->GetNavPrint(GetMessage("CAT_MEASURE_TITLE")));

$lAdmin->AddHeaders(array(
	array(
		"id" => "ID",
		"content" => "ID",
		"sort" => "ID",
		"default" => true
	),
	array(
		"id" => "CODE",
		"content" => GetMessage("CAT_MEASURE_CODE"),
		"sort" => "CODE",
		"default" => true
	),
	array(
		"id" => "MEASURE_TITLE",
		"content" => GetMessage("CAT_MEASURE_MEASURE_TITLE"),
		"sort" => "MEASURE_TITLE",
		"default" => true
	),
	array(
		"id" => "SYMBOL_RUS",
		"content" => GetMessage("CAT_MEASURE_SYMBOL_RUS"),
		"sort" => "SYMBOL_RUS",
		"default" => true
	),
	array(
		"id" => "SYMBOL_INTL",
		"content" => GetMessage("CAT_MEASURE_SYMBOL_INTL"),
		"sort" => "SYMBOL_INTL",
		"default" => true
	),
	array(
		"id" => "SYMBOL_LETTER_INTL",
		"content" => GetMessage("CAT_MEASURE_SYMBOL_LETTER_INTL"),
		"sort" => "SYMBOL_LETTER_INTL",
		"default" => false
	),
	array(
		"id" => "IS_DEFAULT",
		"content" => GetMessage("CAT_MEASURE_IS_DEFAULT"),
		"sort" => "IS_DEFAULT",
		"default" => true
	),
));

$arSelectFieldsMap = array(
	"ID" => false,
	"CODE" => false,
	"MEASURE_TITLE" => false,
	"SYMBOL_RUS" => false,
	"SYMBOL_INTL" => false,
	"SYMBOL_LETTER_INTL" => false,
	"IS_DEFAULT" => false,
);

$arSelectFields = $lAdmin->GetVisibleHeaderColumns();
if(!in_array('ID', $arSelectFields))
	$arSelectFields[] = 'ID';

$arSelectFieldsMap = array_merge($arSelectFieldsMap, array_fill_keys($arSelectFields, true));

$arUserList = array();
$arUserID = array();
$strNameFormat = CSite::GetNameFormat(true);

$arRows = array();

while($arRes = $dbResultList->Fetch())
{
	$arRes['ID'] = (int)$arRes['ID'];
	if($arSelectFieldsMap['USER_ID'])
	{
		$arRes['USER_ID'] = (int)$arRes['USER_ID'];
		if(0 < $arRes['USER_ID'])
			$arUserID[$arRes['USER_ID']] = true;
	}
	if($arSelectFieldsMap['MODIFIED_BY'])
	{
		$arRes['MODIFIED_BY'] = (int)$arRes['MODIFIED_BY'];
		if(0 < $arRes['MODIFIED_BY'])
			$arUserID[$arRes['MODIFIED_BY']] = true;
	}

	$arRows[$arRes['ID']] = $row =& $lAdmin->AddRow($arRes['ID'], $arRes);
	$row->AddField("ID", $arRes['ID']);
	if($bReadOnly)
	{
		if($arSelectFieldsMap['CODE'])
			$row->AddField("CODE", false);
		if($arSelectFieldsMap['MEASURE_TITLE'])
			$row->AddInputField("MEASURE_TITLE", false);
		if($arSelectFieldsMap['SYMBOL_RUS'])
			$row->AddInputField("SYMBOL_RUS", false);
		if($arSelectFieldsMap['SYMBOL_INTL'])
			$row->AddInputField("SYMBOL_INTL", false);
		if($arSelectFieldsMap['SYMBOL_LETTER_INTL'])
			$row->AddInputField("SYMBOL_LETTER_INTL", false);
		if($arSelectFieldsMap['IS_DEFAULT'])
			$row->AddCheckField("IS_DEFAULT", false);
	}
	else
	{
		if($arSelectFieldsMap['CODE'])
			$row->AddInputField("CODE", false);
		if($arSelectFieldsMap['MEASURE_TITLE'])
			$row->AddInputField("MEASURE_TITLE", array("size" => 30));
		if($arSelectFieldsMap['SYMBOL_RUS'])
			$row->AddInputField("SYMBOL_RUS", array("size" => 8));
		if($arSelectFieldsMap['SYMBOL_INTL'])
			$row->AddInputField("SYMBOL_INTL", array("size" => 8));
		if($arSelectFieldsMap['SYMBOL_LETTER_INTL'])
			$row->AddInputField("SYMBOL_LETTER_INTL", array("size" => 8));
		if($arSelectFieldsMap['IS_DEFAULT'])
			$row->AddCheckField("IS_DEFAULT", false);
	}

	if($arSelectFieldsMap['DATE_CREATE'])
		$row->AddCalendarField("DATE_CREATE", false);
	if($arSelectFieldsMap['DATE_MODIFY'])
		$row->AddCalendarField("DATE_MODIFY", false);

	$arActions = array();
	$arActions[] = array("ICON"=>"edit", "TEXT"=>GetMessage("CAT_MEASURE_EDIT_ALT"), "ACTION"=>$lAdmin->ActionRedirect("cat_measure_edit.php?ID=".$arRes['ID']."&lang=".LANGUAGE_ID."&".GetFilterParams("filter_").""), "DEFAULT"=>true);

	if(!$bReadOnly)
	{
		$arActions[] = array("SEPARATOR" => true);
		$arActions[] = array("ICON"=>"delete", "TEXT"=>GetMessage("CAT_MEASURE_DELETE_ALT"), "ACTION"=>"if(confirm('".GetMessageJS('CAT_MEASURE_DELETE_CONFIRM')."')) ".$lAdmin->ActionDoGroup($arRes['ID'], "delete"));
	}

	$row->AddActions($arActions);
}
if(isset($row))
	unset($row);

if($arSelectFieldsMap['USER_ID'] || $arSelectFieldsMap['MODIFIED_BY'])
{
	if(!empty($arUserID))
	{
		$byUser = 'ID';
		$byOrder = 'ASC';
		$rsUsers = CUser::GetList(
			$byUser,
			$byOrder,
			array('ID' => implode(' | ', array_keys($arUserID))),
			array('FIELDS' => array('ID', 'LOGIN', 'NAME', 'LAST_NAME', 'SECOND_NAME', 'EMAIL'))
		);
		while($arOneUser = $rsUsers->Fetch())
		{
			$arOneUser['ID'] = (int)$arOneUser['ID'];
			$arUserList[$arOneUser['ID']] = '<a href="/bitrix/admin/user_edit.php?lang='.LANGUAGE_ID.'&ID='.$arOneUser['ID'].'">'.CUser::FormatName($strNameFormat, $arOneUser).'</a>';
		}
	}

	foreach ($arRows as &$row)
	{
		if($arSelectFieldsMap['USER_ID'])
		{
			$strCreatedBy = '';
			if(0 < $row->arRes['USER_ID'] && isset($arUserList[$row->arRes['USER_ID']]))
			{
				$strCreatedBy = $arUserList[$row->arRes['USER_ID']];
			}
			$row->AddViewField("USER_ID", $strCreatedBy);
		}
		if($arSelectFieldsMap['MODIFIED_BY'])
		{
			$strModifiedBy = '';
			if(0 < $row->arRes['MODIFIED_BY'] && isset($arUserList[$row->arRes['USER_ID']]))
			{
				$strModifiedBy = $arUserList[$row->arRes['MODIFIED_BY']];
			}
			$row->AddViewField("MODIFIED_BY", $strModifiedBy);
		}
	}
	if(isset($row))
		unset($row);
}

$lAdmin->AddFooter(
	array(
		array(
			"title" => GetMessage("MAIN_ADMIN_LIST_SELECTED"),
			"value" => $dbResultList->SelectedRowsCount()
		),
		array(
			"counter" => true,
			"title" => GetMessage("MAIN_ADMIN_LIST_CHECKED"),
			"value" => "0"
		),
	)
);

if(!$bReadOnly)
{
	$lAdmin->AddGroupActionTable(
		array(
			"delete" => GetMessage("MAIN_ADMIN_LIST_DELETE"),
		)
	);
}

if(!$bReadOnly && $bCanAdd)
{
	$aContext = array(
		array(
			"TEXT" => GetMessage("CAT_MEASURE_ADD_NEW_OKEI"),
			"ICON" => "btn_new",
			"LINK" => "cat_measure_edit.php?lang=".LANGUAGE_ID."&OKEI=Y",
			"TITLE" => GetMessage("CAT_MEASURE_ADD_NEW_OKEI_ALT")
		),
		array(
			"TEXT" => GetMessage("CAT_MEASURE_ADD_NEW"),
			"ICON" => "btn_new",
			"LINK" => "cat_measure_edit.php?lang=".LANGUAGE_ID,
			"TITLE" => GetMessage("CAT_MEASURE_ADD_NEW_ALT")
		),
	);
	$lAdmin->AddAdminContextMenu($aContext);
}

$lAdmin->CheckListMode();

$APPLICATION->SetTitle(GetMessage("CAT_MEASURE_TITLE"));
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

$lAdmin->DisplayList();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");