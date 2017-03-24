<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?

IncludeModuleLangFile(__FILE__);

$psTitle = GetMessage("SEBEKON_PSBPAYMENT_PROMSVAZQBANK");
$psDescription = GetMessage("SEBEKON_PSBPAYMENT_PROMSVAZQBANK_DESCR");

$arPSCorrespondence = array(
		"ps_url" => array(
			"NAME" => "ps_url",
			"DESCR" => GetMessage("SEBEKON_PSBPAYMENT_ADRES_SERVERA_BANKA"),
			"VALUE" => "http://193.200.10.117:8080/cgi-bin/cgi_link",
			"TYPE" => ""
		),
		"ps_amount" => Array(
			"NAME" => "ps_amount",
			"VALUE" => "",
			"DESCR" => GetMessage("SEBEKON_PSBPAYMENT_SUMMA_K_OPLATE"),
			"TYPE" => "ORDER",
		),
		"ps_order" => Array(
			"NAME" => "ps_order",
			"VALUE" => "",
			"DESCR" => GetMessage("SEBEKON_PSBPAYMENT_NOMER_ZAKAZA"),
			"TYPE" => "ORDER",
		),
		"ps_desc" => Array(
			"NAME" => "ps_desc",
			"VALUE" => "",
			"DESCR" => GetMessage("SEBEKON_PSBPAYMENT_OPISANIE_ZAKAZA"),
			"TYPE" => "ORDER",
		),
		"ps_currency" => array(
			"NAME" => "ps_currency",
			"DESCR" => GetMessage("SEBEKON_PSBPAYMENT_VYLUTA"),
			"VALUE" => "RUB",
			"TYPE" => ""
		),
		"ps_terminal" => array(
			"NAME" => "ps_terminal",
			"DESCR" => GetMessage("SEBEKON_PSBPAYMENT_NOMER_TERMINALA"),
			"VALUE" => "",
			"TYPE" => ""
		),
		"ps_merchant" => Array(
			"NAME" => "ps_merchant",
			"VALUE" => "",
			"DESCR" => GetMessage("SEBEKON_PSBPAYMENT_NOMER_TORGOVOY_TOCKI"),
			"TYPE" => "",
		),
		"ps_key" => Array(
			"NAME" => "ps_key",
			"VALUE" => "",
			"DESCR" => GetMessage("SEBEKON_PSBPAYMENT_SEKRETNYY_KLUC"),
			"TYPE" => "",
		),
		"ps_merchant_name" => Array(
			"NAME" => "ps_merchant_name",
			"VALUE" => "",
			"DESCR" => GetMessage("SEBEKON_PSBPAYMENT_NAZVANIE_TORGOVOY_TO"),
			"TYPE" => "",
		),
		"ps_email" => Array(
			"NAME" => "ps_email",
			"VALUE" => "",
			"DESCR" => GetMessage("SEBEKON_PSBPAYMENT_ADRES_EL_POCTY_TORG"),
			"TYPE" => "",
		),
		"ps_back" => Array(
			"NAME" => "ps_back",
			"VALUE" => "http://{$_SERVER['HTTP_HOST']}/personal/order/payment/psbank.php",
			"DESCR" => "URL ".GetMessage("SEBEKON_PSBPAYMENT_DLA_VOZVRATA_NA_SAY"),
			"TYPE" => "",
		),	
	);
?>