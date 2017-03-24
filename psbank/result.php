<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оплата");
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment.receive",
	"",
	Array(
		"PAY_SYSTEM_ID_NEW" => "4"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>