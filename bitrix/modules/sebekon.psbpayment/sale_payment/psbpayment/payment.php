<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
IncludeModuleLangFile(__FILE__);

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

global $APPLICATION;
if(empty($ps_back)) {
	$ps_back = 'http://'.SITE_SERVER_NAME.$APPLICATION->GetCurPageParam();
}
if (stripos($ps_back,'http')===FALSE) {
	$ps_back = 'http://'.SITE_SERVER_NAME.$ps_back;
}
if (stripos($ps_back, '?')===FALSE) {
	$ps_back .= '?ORDER_ID='.$ps_order;
} else {
	$ps_back .= '&ORDER_ID='.$ps_order;
}

if (stripos($ps_back, '//www.')===FALSE && stripos($_SERVER['HTTP_HOST'], '//www.')!==FALSE) {
	$ps_back = str_replace('://','://www.',$ps_back);
} elseif (stripos($ps_back, '//www.')!==FALSE && stripos($_SERVER['HTTP_HOST'], '//www.')===FALSE) {
	$ps_back = str_replace('://www.','://',$ps_back);
}

$ps_amount = number_format($ps_amount, 2, '.','');
$nonce = '';
for($i=0;$i<16;$i++) {
	$nonce .= dechex(rand(1,16));
}
$timezone = new DateTimeZone(date_default_timezone_get()); // Get default system timezone to create a new DateTimeZone object
$offset = $timezone->getOffset(new DateTime()); // Offset in seconds to UTC

CModule::IncludeMOdule('sale');
$bUseAccountNumber = (COption::GetOptionString("sale", "account_number_template", "") !== "") ? true : false;
$arOrder = false;
if ($bUseAccountNumber) {
	$arOrder = CSaleOrder::GetList(array("DATE_UPDATE" => "DESC"),array("ACCOUNT_NUMBER" => $ps_order))->Fetch();
}
if (!$arOrder) {
	$arOrder = CSaleOrder::GetByID($ps_order);
}

// add the start of the vpcURL querystring parameters
$data = array(
        "AMOUNT" =>$ps_amount,
        "CURRENCY" =>$ps_currency,
        "ORDER" => date("Ymd",strtotime($arOrder['DATE_INSERT'])).$ps_order,
        "DESC" => GetMessage("SEBEKON_PSBPAYMENT_ZAKAZ").$ps_order.' '.GetMessage("SEBEKON_PSBPAYMENT_OT").$ps_desc,
        "TERMINAL" =>$ps_terminal,
        "TRTYPE" => 1,
        "MERCH_NAME" =>$ps_merchant_name,
        "MERCHANT" =>$ps_merchant,
        "EMAIL" =>$ps_email,
        "TIMESTAMP" =>date("YmdHis", time()-$offset),
        "NONCE" => $nonce,
        "BACKREF" =>$ps_back,
);
if (defined("SITE_CHARSET") && SITE_CHARSET=='windows-1251' && function_exists('iconv')) {
	$data['DESC'] = iconv('windows-1251','utf-8',$data['DESC']);
}
$data['P_SIGN'] = '';
foreach (array('AMOUNT','CURRENCY','ORDER','MERCH_NAME','MERCHANT','TERMINAL','EMAIL','TRTYPE','TIMESTAMP','NONCE','BACKREF') as $key) {
	if (strlen($data[$key])>0)
		$data['P_SIGN'] .= strlen($data[$key]).$data[$key];
	else
		$data['P_SIGN'] .= '-';
}
$data['P_SIGN'] = hash_hmac('sha1',$data['P_SIGN'],pack('H*', $ps_key));

?>
<?if($arOrder['CANCELED']=='Y'):?>
<strong style="color: red;"><?=GetMessage("SEBEKON_PSBPAYMENT_ZAKAZ_OTMENEN")?></strong>
<?elseif($arOrder['PAYED']=='Y'):?>
<?
	$data['ORG_AMOUNT'] = $data['AMOUNT'];
	$data['TRTYPE'] = 22;
	$data['RRN'] = $arOrder['PAY_VOUCHER_NUM'];
	$data['INT_REF'] = $arOrder['PS_STATUS_MESSAGE'];
	unset($data['DESC']);
	unset($data['MERCH_NAME']);
	unset($data['MERCHANT']);

	$data['P_SIGN'] = '';
	foreach (array('ORDER','AMOUNT','CURRENCY','ORG_AMOUNT','RRN','INT_REF','TRTYPE','TERMINAL','BACKREF','EMAIL','TIMESTAMP','NONCE') as $key) {
		if (strlen($data[$key])>0)
			$data['P_SIGN'] .= strlen($data[$key]).$data[$key];
		else
			$data['P_SIGN'] .= '-';
	}
	$data['P_SIGN'] = hash_hmac('sha1',$data['P_SIGN'],pack('H*', $ps_key));


?>
<form name="order" action="<?=htmlspecialcharsEx($ps_url)?>" method="post" id="sale_payment">
<?
	foreach($data as $key => $value) {
		if (strlen($value) > 0) {?>
        	<input type="hidden" name="<?=$key?>" value="<?=htmlspecialchars($value)?>"/>
			<?
    	}
	}
?>
</form>
<p class="success"><strong style="color: green;"><?=GetMessage("SEBEKON_PSBPAYMENT_ZAKAZ_OPLACEN")?></strong> <a href="javascript: void(0);" onclick="document.getElementById('sale_payment').submit(); return false;" style="color: red;"><?=GetMessage("SEBEKON_PSBPAYMENT_OTMENITQ_OPLATU")?></a></p>

<?elseif(strpos($APPLICATION->GetCurDir(),'payment')!==FALSE):?>
<form name="order" action="<?=htmlspecialcharsEx($ps_url)?>" method="post" id="sale_payment">
<?
	foreach($data as $key => $value) {
		if (strlen($value) > 0) {?>
        	<input type="hidden" name="<?=$key?>" value="<?=htmlspecialchars($value)?>"/>
			<?
    	}
	}
?>
</form>
<h2 style="color:red"><?=GetMessage("SEBEKON_PSBPAYMENT_SEYCAS_VY_BUDETE_PER")?></h2>
<script type="text/javascript">
	document.getElementById('sale_payment').submit();
</script>
<p><?=GetMessage("SEBEKON_PSBPAYMENT_ESLI_OKNO_S_PLATEJNO")?><a href="javascript: void(0);" onclick="document.getElementById('sale_payment').submit(); return false;"><?=GetMessage("SEBEKON_PSBPAYMENT_OPLATITQ_ZAKAZ")?></a>.</p>
<?else:?>
<form name="order" action="<?=htmlspecialcharsEx($ps_url)?>" method="post" id="sale_payment">
<?
	foreach($data as $key => $value) {
		if (strlen($value) > 0) {?>
        	<input type="hidden" name="<?=$key?>" value="<?=htmlspecialchars($value)?>"/>
			<?
    	}
	}
?>
</form>
<p><a href="javascript: void(0);" onclick="document.getElementById('sale_payment').submit(); return false;"><?=GetMessage("SEBEKON_PSBPAYMENT_OPLATITQ_ZAKAZ")?></a>.</p>
<?endif;?>