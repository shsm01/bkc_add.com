<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock") || !CModule::IncludeModule("sebekon.psbpayment"))
	return;

$arParams['IBLOCK_TYPE'] = CSebekonPsbpayment::IBLOCK_CODE;
if(!$arIBlock = CIBlock::GetList(array('ID' => 'DESC'), array('ACTIVE' => 'Y', 'CODE' => CSebekonPsbpayment::IBLOCK_CODE))->Fetch()) {
	return;
}
$arParams['IBLOCK_ID'] = $arIBlock['ID'];


function null2unknown($map, $key) {
    if (array_key_exists($key, $map)) {
        if (!is_null($map[$key])) {
            return $map[$key];
        }
    } 
    return "";
}


$arResult = array();

if ($_REQUEST['RETURN_FROM_BANK']=='Y') {
	//Если мы перенаправлены из банка
	$arResult['ORDER_ID'] = intval($_REQUEST['ORDER_ID']);
	if(empty($arResult['ORDER_ID'])) {
		return;
	}
	
	if($arResult['DATA'] = CIBlockElement::GetList(array('ID' => 'ASC'), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arResult['ORDER_ID']), false, false, array('ID', 'PREVIEW_TEXT', 'IBLOCK_ID', 'PROPERTY_ORDER_SUM', 'PROPERTY_ORDER_STATUS', 'PROPERTY_ORDER_STATUS.XML_ID'))->Fetch()) {
		$arResult['DATA']['AMOUNT'] = $arResult['DATA']['PROPERTY_ORDER_SUM_VALUE'];
		$arResult['STATUS'] = CIBlockProperty::GetPropertyEnum('ORDER_STATUS', array(), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arResult['DATA']['PROPERTY_ORDER_STATUS_ENUM_ID']))->Fetch();
		if ($arResult['STATUS']['XML_ID']!=2) {			
			if ($arResult['DATA']['PREVIEW_TEXT']!='') {
				$arResult['ERRORS'] = array($arResult['DATA']['PREVIEW_TEXT']);
			} else {
				$arResult['ERRORS'] = array(GetMessage('INVALID_SERVER_RESPONSE'));
			}
		}
		$this->IncludeComponentTemplate();
		return;
	}
}


/*
$ps_key = trim(CSalePaySystemAction::GetParamValue("ps_key"));
$ps_url = trim(CSalePaySystemAction::GetParamValue("ps_url"));
$ps_amount = trim(CSalePaySystemAction::GetParamValue("ps_amount"));
$ps_order = trim(CSalePaySystemAction::GetParamValue("ps_order"));
$ps_desc = trim(CSalePaySystemAction::GetParamValue("ps_desc"));
$ps_currency = trim(CSalePaySystemAction::GetParamValue("ps_currency"));
$ps_terminal = trim(CSalePaySystemAction::GetParamValue("ps_terminal"));
$ps_merchant = trim(CSalePaySystemAction::GetParamValue("ps_merchant"));
$ps_merchant_name = trim(CSalePaySystemAction::GetParamValue("ps_merchant_name"));
$ps_email = trim(CSalePaySystemAction::GetParamValue("ps_email"));
$ps_back = trim(CSalePaySystemAction::GetParamValue("ps_back"));
*/


$arResult['DATA']['AMOUNT']       	= null2unknown($_REQUEST,"AMOUNT");
$arResult['DATA']['ORG_AMOUNT']     = null2unknown($_REQUEST,"ORG_AMOUNT");
$arResult['DATA']['CURRENCY']       = null2unknown($_REQUEST,"CURRENCY");
$arResult['DATA']['ORDER']       	= null2unknown($_REQUEST,"ORDER");
$arResult['DATA']['DESC']       	= null2unknown($_REQUEST,"DESC");
$arResult['DATA']['TERMINAL']       = null2unknown($_REQUEST,"TERMINAL");
$arResult['DATA']['TRTYPE']       	= null2unknown($_REQUEST,"TRTYPE");
$arResult['DATA']['MERCH_NAME']     = null2unknown($_REQUEST,"MERCH_NAME");
$arResult['DATA']['MERCHANT']       = null2unknown($_REQUEST,"MERCHANT");
$arResult['DATA']['EMAIL']       	= null2unknown($_REQUEST,"EMAIL");
$arResult['DATA']['TIMESTAMP']      = null2unknown($_REQUEST,"TIMESTAMP");
$arResult['DATA']['NONCE']       	= null2unknown($_REQUEST,"NONCE");
$arResult['DATA']['BACKREF']       	= null2unknown($_REQUEST,"BACKREF");
$arResult['DATA']['RESULT']       	= null2unknown($_REQUEST,"RESULT");
$arResult['DATA']['RC']       		= null2unknown($_REQUEST,"RC");
$arResult['DATA']['RCTEXT']      	= null2unknown($_REQUEST,"RCTEXT");
$arResult['DATA']['AUTHCODE']       = null2unknown($_REQUEST,"AUTHCODE");
$arResult['DATA']['RRN']       		= null2unknown($_REQUEST,"RRN");
$arResult['DATA']['INT_REF']       	= null2unknown($_REQUEST,"INT_REF");
$arResult['DATA']['P_SIGN']       	= null2unknown($_REQUEST,"P_SIGN");
$arResult['DATA']['NAME']      		= null2unknown($_REQUEST,"NAME");
$arResult['DATA']['CARD']	       	= null2unknown($_REQUEST,"CARD");


$arResult['ERROR_EXISTS'] = false;
$arResult['ERRORS'] = array();

if(strlen($arResult['DATA']['P_SIGN']) > 0) {
	$ps_p_sign = '';
	
	if ($arResult['DATA']['TRTYPE'] == 1) {
		$ps_arr = array('AMOUNT','CURRENCY','ORDER','MERCH_NAME','MERCHANT','TERMINAL','EMAIL','TRTYPE','TIMESTAMP','NONCE','BACKREF','RESULT','RC','RCTEXT','AUTHCODE','RRN','INT_REF');
	} elseif($arResult['DATA']['TRTYPE'] == 22) {
		$ps_arr = array('ORDER','AMOUNT','CURRENCY','ORG_AMOUNT','RRN','INT_REF','TRTYPE','TERMINAL','BACKREF','EMAIL','TIMESTAMP','NONCE','RESULT','RC','RCTEXT');		
	} else {
		$arResult['ERRORS'][] = GetMessage("NOT_EXIST_COMMAND");
		$arResult['ERROR_EXISTS'] = true;
	}
	
	foreach ($ps_arr as $key) {
		if (strlen($arResult['DATA'][$key])>0)
			$ps_p_sign .= strlen($arResult['DATA'][$key]).$arResult['DATA'][$key];
		else
			$ps_p_sign .= '-';
	}
	$ps_p_sign = hash_hmac('sha1',$ps_p_sign, pack('H*', $arParams['PS_KEY']));
	
	
	// set a flag to indicate if hash has been validated	

	if (strtoupper($arResult['DATA']['P_SIGN']) == strtoupper($ps_p_sign)) {
		if ($arResult['DATA']['TRTYPE'] == 1) {
			switch($arResult['DATA']['RESULT']) {
				case  0:
						$strPS_STATUS_DESCRIPTION = "";	
						$strPS_STATUS_DESCRIPTION .= "Purchase Amount: {$arResult['DATA']['AMOUNT']};";
						$strPS_STATUS_DESCRIPTION .= "Response: {$arResult['DATA']['RCTEXT']};";
						$strPS_STATUS_DESCRIPTION .= "Retrieval Reference Number : {$arResult['DATA']['RRN']};";
						$strPS_STATUS_DESCRIPTION .= "Internal Reference Number : {$arResult['DATA']['INT_REF']};";
						$strPS_STATUS_DESCRIPTION .= "Bank Authorization ID: {$arResult['DATA']['AUTHCODE']};";
						$strPS_STATUS_DESCRIPTION .= "Card Type: $cardType;";  // ?????????
						
						$arResult['ORDER_ID'] = substr($arResult['DATA']['ORDER'], 8);
						
						
						if($arOrder = CIBlockElement::GetList(array('ID' => 'ASC'), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arResult['ORDER_ID']), false, false, array('ID', 'PROPERTY_ORDER_SUM'))->Fetch()) {
						
							//$arOrder = CSaleOrder::GetByID($arResult['ORDER_ID']);
							/*
							$arFields = array(
								"PS_STATUS" => "Y",
								"PAYED" => "Y",
								//"STATUS_ID" => "O",
								"PS_STATUS_CODE" => $arResult['DATA']['INT_REF'],
								"PS_STATUS_DESCRIPTION" => $strPS_STATUS_DESCRIPTION,
								"PS_STATUS_MESSAGE" => $arResult['DATA']['INT_REF'],
								"PS_SUM" => $arResult['DATA']['AMOUNT'],
								"PS_CURRENCY" => 'Rub',
								"PS_RESPONSE_DATE" => Date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG))),
								"USER_ID" => $arOrder["USER_ID"],
							);
							$arFields["PAY_VOUCHER_NUM"] = $arResult['DATA']['RRN'];
							$arFields["PAY_VOUCHER_DATE"] = Date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG)));		
							*/
							
							$arFields = array(
								'CODE' 				=> date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG))),
								'DETAIL_TEXT' 		=> $strPS_STATUS_DESCRIPTION,
								'DETAIL_TEXT_TYPE' 	=> 'text'
							);
							
							if (abs(IntVal($arOrder["PROPERTY_ORDER_SUM_VALUE"])-IntVal($arResult['DATA']['AMOUNT']))<=1) {
								$el = new CIBlockElement;
								$el->Update($arOrder['ID'], $arFields);
								
								if($arStatus = CIBlockProperty::GetPropertyEnum('ORDER_STATUS', array(), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'EXTERNAL_ID' => 2))->Fetch()) {
									CIBlockElement::SetPropertyValuesEx($arOrder['ID'], $arParams['IBLOCK_ID'], array('ORDER_STATUS' => $arStatus['ID']));
								}
								
								$arEventData = array(
									'ORDER_ID' => $arOrder['ID'],
									'MESSAGE' => GetMessage('EVENT_MESSAGE_SUCCESS', array('#ORDER_SUM#' => number_format($arResult['DATA']['AMOUNT'], 2, ',', ' ')))
								);
								CEvent::SendImmediate(CSebekonPsbpayment::EVENT_TYPE, SITE_ID, $arEventData);
								
								foreach(GetModuleEvents("sebekon.psbpayment", "OnOrderPayed", true) as $arEvent) {
									ExecuteModuleEventEx($arEvent, array($arOrder['ID'])) ;
								}
								
								//CSaleOrder::PayOrder($arOrder["ID"], "Y");
								//CSaleOrder::StatusOrder($arOrder["ID"], 'P');
							}
						} else {
							$arResult['ORDER_ID'] = null;
						}
						//CSaleOrder::Update($arOrder["ID"], $arFields);
					break;
				case  1: $arResult['ERRORS'][] = GetMessage('ORDER_IS_PAYED'); $arResult['ERROR_EXISTS'] = true; break;
				case  2: $arResult['ERRORS'][] = GetMessage('REQUEST_REJECTED_BY_BANK', array('#REASON#' => $arResult['DATA']['RCTEXT'])); $arResult['ERROR_EXISTS'] = true; break;				
				case  3: $arResult['ERRORS'][] = GetMessage('REQUEST_REJECTED_BY_GATEWAY', array('#REASON#' => $arResult['DATA']['RCTEXT']));	$arResult['ERROR_EXISTS'] = true; break;
				default: $arResult['ERROR_EXISTS'] = true; $arResult['ERRORS'][] = GetMessage('INVALID_SERVER_RESPONSE');	break;
			}
		} elseif ($arResult['DATA']['TRTYPE'] == 22) {
			switch($arResult['DATA']['RESULT']) {
				case  0:
						$strPS_STATUS_DESCRIPTION = "";	
						$strPS_STATUS_DESCRIPTION .= "Purchase Amount: {$arResult['DATA']['AMOUNT']};";
						$strPS_STATUS_DESCRIPTION .= "Response: {$arResult['DATA']['RCTEXT']};";
						$strPS_STATUS_DESCRIPTION .= "Retrieval Reference Number : {$arResult['DATA']['RRN']};";
						$strPS_STATUS_DESCRIPTION .= "Internal Reference Number : {$arResult['DATA']['INT_REF']};";
						$strPS_STATUS_DESCRIPTION .= "Bank Authorization ID: {$arResult['DATA']['AUTHCODE']};";
						$strPS_STATUS_DESCRIPTION .= "Card Type: $cardType;";       
						
						$arResult['ORDER_ID'] = substr($arResult['DATA']['ORDER'], 8);
						//$arOrder = CSaleOrder::GetByID($arResult['ORDER_ID']);
						
						if($arOrder = CIBlockElement::GetList(array('ID' => 'ASC'), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arResult['ORDER_ID']), false, false, array('ID', 'PROPERTY_ORDER_SUM'))->Fetch()) {
							/*
							$arFields = array(
								"PS_STATUS" => "N",
								"PAYED" => "N",
								//"STATUS_ID" => "O",
								"PS_STATUS_CODE" => $arResult['DATA']['INT_REF'],
								"PS_STATUS_DESCRIPTION" => $strPS_STATUS_DESCRIPTION,
								"PS_STATUS_MESSAGE" => $arResult['DATA']['INT_REF'],
								"PS_SUM" => $arResult['DATA']['AMOUNT'],
								"PS_CURRENCY" => 'Rub',
								"PS_RESPONSE_DATE" => Date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG))),
								"USER_ID" => $arOrder["USER_ID"],
							);
							$arFields["PAY_VOUCHER_NUM"] = $arResult['DATA']['RRN'];
							$arFields["PAY_VOUCHER_DATE"] = Date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG)));		
							*/
							
							
							$arFields = array(
								'CODE' 				=> date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG))),
								'DETAIL_TEXT' 		=> $strPS_STATUS_DESCRIPTION,
								'DETAIL_TEXT_TYPE' 	=> 'text'
							);
							$el = new CIBlockElement;
							$el->Update($arOrder['ID'], $arFields);
							if($arStatus = CIBlockProperty::GetPropertyEnum('ORDER_STATUS', array(), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'EXTERNAL_ID' => 3))->Fetch()) {
								CIBlockElement::SetPropertyValuesEx($arOrder['ID'], $arParams['IBLOCK_ID'], array('ORDER_STATUS' => $arStatus['ID']));
							}
							
							$arEventData = array(
								'ORDER_ID' => $arOrder['ID'],
								'MESSAGE' => GetMessage('EVENT_MESSAGE_CANCELED', array('#ORDER_SUM#' => number_format($arResult['DATA']['AMOUNT'], 2, ',', ' ')))
							);
							CEvent::SendImmediate(CSebekonPsbpayment::EVENT_TYPE, SITE_ID, $arEventData);
							
							foreach(GetModuleEvents("sebekon.psbpayment", "OnOrderCanceled", true) as $arEvent) {
								ExecuteModuleEventEx($arEvent, Array($arOrder['ID'])) ;
							}
							
							/*
							CSaleOrder::Update($arOrder["ID"], $arFields);
							CSaleOrder::CancelOrder($arOrder["ID"], "Y", 'Возвращена оплата');	
							*/
						} else {
							$arResult['ORDER_ID'] = null;
						}
					break;
				case  1: $arResult['ERRORS'][] = GetMessage('ORDER_IS_CANCELED'); $arResult['ERROR_EXISTS'] = true; break;
				case  2: $arResult['ERRORS'][] = GetMessage('REQUEST_REJECTED_BY_BANK', array('#REASON#' => $arResult['DATA']['RCTEXT'])); $arResult['ERROR_EXISTS'] = true; break;				
				case  3: $arResult['ERRORS'][] = GetMessage('REQUEST_REJECTED_BY_GATEWAY', array('#REASON#' => $arResult['DATA']['RCTEXT']));	$arResult['ERROR_EXISTS'] = true; break;
				default: $arResult['ERROR_EXISTS'] = true; $arResult['ERRORS'][] = GetMessage('INVALID_SERVER_RESPONSE');	break;
			}
		} else {
			$arResult['ERRORS'][] = GetMessage('NOT_EXIST_COMMAND');
			$arResult['ERROR_EXISTS'] = true;
		}
	} else {
		$arResult['ERRORS'][] = GetMessage('CONTAINS_INVALID_SIGNATURE', array('#SIGNATURE#' => $ps_p_sign));
		$arResult['ERROR_EXISTS'] = true;
	}
} else {
	$arResult['ERROR_EXISTS'] = true;
	$arResult['ERRORS'][] = GetMessage('INVALID_SERVER_RESPONSE');
}

$this->IncludeComponentTemplate(); 


?>
