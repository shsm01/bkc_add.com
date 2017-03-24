<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?

IncludeModuleLangFile(__FILE__);
	
// If input is null, returns string "No Value Returned", else returns value corresponding to given key
function null2unknown($map, $key) {
    if (array_key_exists($key, $map)) {
        if (!is_null($map[$key])) {
            return $map[$key];
        }
    } 
    return "";
}

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

$data['AMOUNT']       	= null2unknown($_REQUEST,"AMOUNT");
$data['ORG_AMOUNT']     = null2unknown($_REQUEST,"ORG_AMOUNT");
$data['CURRENCY']       = null2unknown($_REQUEST,"CURRENCY");
$data['ORDER']       	= null2unknown($_REQUEST,"ORDER");
$data['DESC']       	= null2unknown($_REQUEST,"DESC");
$data['TERMINAL']       = null2unknown($_REQUEST,"TERMINAL");
$data['TRTYPE']       	= null2unknown($_REQUEST,"TRTYPE");
$data['MERCH_NAME']     = null2unknown($_REQUEST,"MERCH_NAME");
$data['MERCHANT']       = null2unknown($_REQUEST,"MERCHANT");
$data['EMAIL']       	= null2unknown($_REQUEST,"EMAIL");
$data['TIMESTAMP']      = null2unknown($_REQUEST,"TIMESTAMP");
$data['NONCE']       	= null2unknown($_REQUEST,"NONCE");
$data['BACKREF']       	= null2unknown($_REQUEST,"BACKREF");
$data['RESULT']       	= null2unknown($_REQUEST,"RESULT");
$data['RC']       		= null2unknown($_REQUEST,"RC");
$data['RCTEXT']      	= null2unknown($_REQUEST,"RCTEXT");
$data['AUTHCODE']       = null2unknown($_REQUEST,"AUTHCODE");
$data['RRN']       		= null2unknown($_REQUEST,"RRN");
$data['INT_REF']       	= null2unknown($_REQUEST,"INT_REF");
$data['P_SIGN']       	= null2unknown($_REQUEST,"P_SIGN");
$data['NAME']      		= null2unknown($_REQUEST,"NAME");
$data['CARD']	       	= null2unknown($_REQUEST,"CARD");


$errorExists = false;
$errors = array();
$arOrder = false;
$bUseAccountNumber = false;

if(strlen($data['P_SIGN']) > 0) {
	$ps_p_sign = '';
	
	if ($data['TRTYPE'] == 1) {
		$ps_arr = array('AMOUNT','CURRENCY','ORDER','MERCH_NAME','MERCHANT','TERMINAL','EMAIL','TRTYPE','TIMESTAMP','NONCE','BACKREF','RESULT','RC','RCTEXT','AUTHCODE','RRN','INT_REF');
	} elseif($data['TRTYPE'] == 22) {
		$ps_arr = array('ORDER','AMOUNT','CURRENCY','ORG_AMOUNT','RRN','INT_REF','TRTYPE','TERMINAL','BACKREF','EMAIL','TIMESTAMP','NONCE','RESULT','RC','RCTEXT');		
	} else {
		$errors[] = GetMessage("SEBEKON_PSBPAYMENT_DANNAA_KOMANDA_NE_PO");
		$errorExists = true;
	}
	
	foreach ($ps_arr as $key) {
		if (strlen($data[$key])>0)
			$ps_p_sign .= strlen($data[$key]).$data[$key];
		else
			$ps_p_sign .= '-';
	}
	$ps_p_sign = hash_hmac('sha1',$ps_p_sign, pack('H*', $ps_key));
	
	
	// set a flag to indicate if hash has been validated	

	if (strtoupper($data['P_SIGN']) == strtoupper($ps_p_sign)) {
		if ($data['TRTYPE'] == 1) {
			switch($data['RESULT']) {
				case  0:
						$strPS_STATUS_DESCRIPTION = "";	
						$strPS_STATUS_DESCRIPTION .= "Purchase Amount: {$data['AMOUNT']};";
						$strPS_STATUS_DESCRIPTION .= "Response: {$data['RCTEXT']};";
						$strPS_STATUS_DESCRIPTION .= "Retrieval Reference Number : {$data['RRN']};";
						$strPS_STATUS_DESCRIPTION .= "Internal Reference Number : {$data['INT_REF']};";
						$strPS_STATUS_DESCRIPTION .= "Bank Authorization ID: {$data['AUTHCODE']};";
						$strPS_STATUS_DESCRIPTION .= "Card Type: $cardType;";  
						
						$ORDER_ID = substr($data['ORDER'], 8);
						$bUseAccountNumber = (COption::GetOptionString("sale", "account_number_template", "") !== "") ? true : false;
						$arOrder = false;
						if ($bUseAccountNumber) {
							$arOrder = CSaleOrder::GetList(array("DATE_UPDATE" => "DESC"),array("ACCOUNT_NUMBER" => $ORDER_ID))->Fetch();
						}
						if (!$arOrder) {
							$arOrder = CSaleOrder::GetByID($ORDER_ID);
						}
						
						$arFields = array(
							"PS_STATUS" => "Y",
							"PS_STATUS_CODE" => $data['INT_REF'],
							"PS_STATUS_DESCRIPTION" => $strPS_STATUS_DESCRIPTION,
							"PS_STATUS_MESSAGE" => $data['INT_REF'],
							"PS_SUM" => $data['AMOUNT'],
							"PS_CURRENCY" => 'Rub',
							"PS_RESPONSE_DATE" => Date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG))),
						);
						$arOrder['PS_SUM'] = $arFields['PS_SUM'];
						$arFields["PAY_VOUCHER_NUM"] = $data['RRN'];
						$arFields["PAY_VOUCHER_DATE"] = Date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG)));		

						if (abs(IntVal($arOrder["PRICE"])-IntVal($data['AMOUNT']))<=1) {			
							CSaleOrder::PayOrder($arOrder["ID"], "Y");
						}

						CSaleOrder::Update($arOrder["ID"], $arFields);
					break;
				case  1: $errors[] = GetMessage("SEBEKON_PSBPAYMENT_ZAKAZ_UJE_RANEE_BYL"); $errorExists = true; break;
				case  2: $errors[] = GetMessage("SEBEKON_PSBPAYMENT_ZAPROS_OTKLONEN_BANK").$data['RCTEXT']; $errorExists = true; break;				
				case  3: $errors[] = GetMessage("SEBEKON_PSBPAYMENT_ZAPROS_OTKLONEN_SLUZ").$data['RCTEXT'];	$errorExists = true; break;
				default: $errorExists = true; $errors[] = GetMessage("SEBEKON_PSBPAYMENT_NEVERNYY_OTVET_SERVE");	break;
			}
		} elseif ($data['TRTYPE'] == 22) {
			switch($data['RESULT']) {
				case  0:
						$strPS_STATUS_DESCRIPTION = "";	
						$strPS_STATUS_DESCRIPTION .= "Purchase Amount: {$data['AMOUNT']};";
						$strPS_STATUS_DESCRIPTION .= "Response: {$data['RCTEXT']};";
						$strPS_STATUS_DESCRIPTION .= "Retrieval Reference Number : {$data['RRN']};";
						$strPS_STATUS_DESCRIPTION .= "Internal Reference Number : {$data['INT_REF']};";
						$strPS_STATUS_DESCRIPTION .= "Bank Authorization ID: {$data['AUTHCODE']};";
						$strPS_STATUS_DESCRIPTION .= "Card Type: $cardType;";       
						
						$ORDER_ID = substr($data['ORDER'], 8);
						$bUseAccountNumber = (COption::GetOptionString("sale", "account_number_template", "") !== "") ? true : false;
						$arOrder = false;
						if ($bUseAccountNumber) {
							$arOrder = CSaleOrder::GetList(array("DATE_UPDATE" => "DESC"),array("ACCOUNT_NUMBER" => $ORDER_ID))->Fetch();
						}
						if (!$arOrder) {
							$arOrder = CSaleOrder::GetByID($ORDER_ID);
						}
						
						$arFields = array(
							"PS_STATUS" => "N",
							"PS_STATUS_CODE" => $data['INT_REF'],
							"PS_STATUS_DESCRIPTION" => $strPS_STATUS_DESCRIPTION,
							"PS_STATUS_MESSAGE" => $data['INT_REF'],
							"PS_SUM" => $data['AMOUNT'],
							"PS_CURRENCY" => 'Rub',
							"PS_RESPONSE_DATE" => Date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG))),
						);
						$arFields["PAY_VOUCHER_NUM"] = $data['RRN'];
						$arFields["PAY_VOUCHER_DATE"] = Date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG)));		

						CSaleOrder::Update($arOrder["ID"], $arFields);
						CSaleOrder::CancelOrder($arOrder["ID"], "Y", GetMessage("SEBEKON_PSBPAYMENT_VOZVRASENA_OPLATA"));
					break;
				case  1: $errors[] = GetMessage("SEBEKON_PSBPAYMENT_ZAKAZ_UJE_RANEE_BYL1"); $errorExists = true; break;
				case  2: $errors[] = GetMessage("SEBEKON_PSBPAYMENT_ZAPROS_OTKLONEN_BANK").$data['RCTEXT']; $errorExists = true; break;				
				case  3: $errors[] = GetMessage("SEBEKON_PSBPAYMENT_ZAPROS_OTKLONEN_SLUZ").$data['RCTEXT'];	$errorExists = true; break;
				default: $errorExists = true; $errors[] = GetMessage("SEBEKON_PSBPAYMENT_NEVERNYY_OTVET_SERVE");	break;
			}
		} else {
			$errors[] = GetMessage("SEBEKON_PSBPAYMENT_DANNAA_KOMANDA_NE_PO");
			$errorExists = true;
		}
	} else {
		$errors[] = GetMessage("SEBEKON_PSBPAYMENT_UKAZANA_NEPRAVILQNAA").$ps_p_sign;
		$errorExists = true;
	}
} elseif($_REQUEST['ORDER_ID']) {
	$ORDER_ID = intval($_REQUEST['ORDER_ID']);
	$bUseAccountNumber = (COption::GetOptionString("sale", "account_number_template", "") !== "") ? true : false;
	$arOrder = false;
	if ($bUseAccountNumber) {
		$arOrder = CSaleOrder::GetList(array("DATE_UPDATE" => "DESC"),array("ACCOUNT_NUMBER" => $ORDER_ID))->Fetch();
	}
	if (!$arOrder) {
		$arOrder = CSaleOrder::GetByID($ORDER_ID);
	}
	
	if ($arOrder) {
		if ($arOrder['PAYED']!='Y') {
			$errorExists = true;
			$errors[] = GetMessage("SEBEKON_PSBPAYMENT_K_SOJALENIU_PLATEJ");
		}
	} else {
		$errorExists = true;
		$errors[] = GetMessage("SEBEKON_PSBPAYMENT_NEVERNYY_NOMER_ZAKAZA");
	}
	
} else {
	$errorExists = true;
	$errors[] = GetMessage("SEBEKON_PSBPAYMENT_NEVERNYY_OTVET_SERVE");
}

if ($arOrder && $bUseAccountNumber && $arOrder['ACCOUNT_NUMBER']) {
	$arOrder['ID'] = $arOrder['ACCOUNT_NUMBER'];
}

if ($arOrder) {
	echo "<h1 class=\"head\">".str_replace(array('#ORDER_ID#'), array($arOrder['ID']), GetMessage("SEBEKON_PSBPAYMENT_OPLATA_ZAKAZA"))."</h1>";
} else {
	"<h1 class=\"head\">".GetMessage("SEBEKON_PSBPAYMENT_OPLATA_ZAKAZA_2")."</h1>";
}
	
if (count($errors)==0) {
	echo "<p><h3>".GetMessage("SEBEKON_PSBPAYMENT_PLATEJ_BYL_USPESNO_P")."</h3></p>";
	
	echo "<b>".GetMessage("SEBEKON_PSBPAYMENT_DETALI_PLATEJA")."</b><br>\n";
	echo "<li>".str_replace(array('#ORDER_ID#'), array($arOrder['ID']), GetMessage("SEBEKON_PSBPAYMENT_ZAKAZ"))."</li>\n";			
	echo "<li>".GetMessage("SEBEKON_PSBPAYMENT_SUMMA").number_format($arOrder['PS_SUM'],2,',',' ')." ".GetMessage("SEBEKON_PSBPAYMENT_RUB")."</li>\n";
} else {
	echo '<p style="color: red;">'.GetMessage("SEBEKON_PSBPAYMENT_K_SOJALENIU_PLATEJ_B").'<br/>';
	foreach($errors as $e) {
		echo $e."<br/>";
	}
	echo "</p>";
	if ($arOrder) {
		echo "<p>".str_replace(array('#ORDER_ID#'), array($arOrder['ID']),GetMessage("SEBEKON_PSBPAYMENT_POPROBUYTE_OPLATITQ"))."</p>";
	}
}

?>


