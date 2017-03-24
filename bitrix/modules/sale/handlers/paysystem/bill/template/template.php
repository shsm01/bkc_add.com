<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=Loc::getMessage('SALE_HPS_BILL_TITLE')?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CHARSET?>">
<style type="text/css">
	table { border-collapse: collapse; }
	table.acc td { border: 1pt solid #000000; padding: 0pt 3pt; line-height: 21pt; }
	table.it td { border: 1pt solid #000000; padding: 0pt 3pt; }
	table.sign td { font-weight: bold; vertical-align: bottom; }
	table.header td { padding: 0pt; vertical-align: top; }
</style>
</head>

<?

if ($_REQUEST['BLANK'] == 'Y')
	$blank = true;

$pageWidth  = 595.28;
$pageHeight = 841.89;

$background = '#ffffff';
if ($params['BILL_BACKGROUND'])
{
	$path = $params['BILL_BACKGROUND'];
	if (intval($path) > 0)
	{
		if ($arFile = CFile::GetFileArray($path))
			$path = $arFile['SRC'];
	}

	$backgroundStyle = $params['BILL_BACKGROUND_STYLE'];
	if (!in_array($backgroundStyle, array('none', 'tile', 'stretch')))
		$backgroundStyle = 'none';

	if ($path)
	{
		switch ($backgroundStyle)
		{
			case 'none':
				$background = "url('" . $path . "') 0 0 no-repeat";
				break;
			case 'tile':
				$background = "url('" . $path . "') 0 0 repeat";
				break;
			case 'stretch':
				$background = sprintf(
					"url('%s') 0 0 repeat-y; background-size: %.02fpt %.02fpt",
					$path, $pageWidth, $pageHeight
				);
				break;
		}
	}
}

$margin = array(
	'top' => intval($params['BILL_MARGIN_TOP'] ?: 15) * 72/25.4,
	'right' => intval($params['BILL_MARGIN_RIGHT'] ?: 15) * 72/25.4,
	'bottom' => intval($params['BILL_MARGIN_BOTTOM'] ?: 15) * 72/25.4,
	'left' => intval($params['BILL_MARGIN_LEFT'] ?: 20) * 72/25.4
);

$width = $pageWidth - $margin['left'] - $margin['right'];

?>

<body style="margin: 0pt; padding: 0pt; background: <?=$background; ?>"<? if ($_REQUEST['PRINT'] == 'Y') { ?> onload="setTimeout(window.print, 0);"<? } ?>>

<div style="margin: 0pt; padding: <?=join('pt ', $margin); ?>pt; width: <?=$width; ?>pt; background: <?=$background; ?>">

<?if ($params['BILL_HEADER_SHOW'] == 'Y'):?>
	<table class="header">
		<tr>
			<? if ($params["BILL_PATH_TO_LOGO"]) { ?>
			<td style="padding-right: 5pt; padding-bottom: 5pt; ">
				<? $imgParams = CFile::_GetImgParams($params['BILL_PATH_TO_LOGO']); ?>
				<? $imgWidth = $imgParams['WIDTH'] * 96 / (intval($params['BILL_LOGO_DPI']) ?: 96); ?>
				<img src="<?=$imgParams['SRC']; ?>" width="<?=$imgWidth; ?>" />
			</td>
			<? } ?>
			<td>
				<b><?=$params["SELLER_COMPANY_NAME"]; ?></b><br><?
				if ($params["SELLER_COMPANY_ADDRESS"]) {
					$sellerAddr = $params["SELLER_COMPANY_ADDRESS"];
					if (is_array($sellerAddr))
						$sellerAddr = implode(', ', $sellerAddr);
					else
						$sellerAddr = str_replace(array("\r\n", "\n", "\r"), ', ', strval($sellerAddr));
					?><b><?= $sellerAddr ?></b><br><?
				} ?>
				<? if ($params["SELLER_COMPANY_PHONE"]) { ?>
				<b><?=Loc::getMessage('SALE_HPS_BILL_SELLER_COMPANY_PHONE', array('#PHONE#' => $params["SELLER_COMPANY_PHONE"]));?></b><br>
				<? } ?>
			</td>
		</tr>
	</table>

	<?
	if ($params["SELLER_COMPANY_BANK_NAME"])
	{
		$sellerBankCity = '';
		if ($params["SELLER_COMPANY_BANK_CITY"])
		{
			$sellerBankCity = $params["SELLER_COMPANY_BANK_CITY"];
			if (is_array($sellerBankCity))
				$sellerBankCity = implode(', ', $sellerBankCity);
			else
				$sellerBankCity = str_replace(array("\r\n", "\n", "\r"), ', ', strval($sellerBankCity));
		}
		$sellerBank = sprintf(
			"%s %s",
			$params["SELLER_COMPANY_BANK_NAME"],
			$sellerBankCity
		);
		$sellerRs = $params["SELLER_COMPANY_BANK_ACCOUNT"];
	}
	else
	{
		$rsPattern = '/\s*\d{10,100}\s*/';

		$sellerBank = trim(preg_replace($rsPattern, ' ', $params["SELLER_COMPANY_BANK_ACCOUNT"]));

		preg_match($rsPattern, $params["SELLER_COMPANY_BANK_ACCOUNT"], $matches);
		$sellerRs = trim($matches[0]);
	}

	?>
	<table class="acc" width="100%">
		<colgroup>
			<col width="29%">
			<col width="29%">
			<col width="10%">
			<col width="32%">
		</colgroup>
		<tr>
			<td>
				<? if ($params["SELLER_COMPANY_INN"]) { ?>
				<?=Loc::getMessage('SALE_HPS_BILL_INN', array('#INN#' => $params["SELLER_COMPANY_INN"]));?>
				<? } else { ?>
				&nbsp;
				<? } ?>
			</td>
			<td>
				<? if ($params["SELLER_COMPANY_KPP"]) { ?>
				<?=Loc::getMessage('SALE_HPS_BILL_KPP', array('#KPP#' => $params["SELLER_COMPANY_KPP"]));?>
				<? } else { ?>
				&nbsp;
				<? } ?>
			</td>
			<td rowspan="2">
				<br>
				<br>
				<?=Loc::getMessage("SALE_HPS_BILL_SELLER_ACC"); ?>
			</td>
			<td rowspan="2">
				<br>
				<br>
				<?=$sellerRs; ?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<?=Loc::getMessage('SALE_HPS_BILL_SELLER_NAME')?><br>
				<?=$params["SELLER_COMPANY_NAME"]; ?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<?=Loc::getMessage('SALE_HPS_BILL_SELLER_BANK_NAME')?><br>
				<?=$sellerBank; ?>
			</td>
			<td>
				<?=Loc::getMessage('SALE_HPS_BILL_SELLER_BANK_BIK')?><br>
				<?=Loc::getMessage('SALE_HPS_BILL_SELLER_ACC_CORR')?><br>
			</td>
			<td>
				<?=$params["SELLER_COMPANY_BANK_BIC"]; ?><br>
				<?=$params["SELLER_COMPANY_BANK_ACCOUNT_CORR"]; ?>
			</td>
		</tr>
	</table>
<?endif;?>
<br>
<br>

<table width="100%">
	<colgroup>
		<col width="50%">
		<col width="0">
		<col width="50%">
	</colgroup>
<?if ($params['BILL_HEADER']):?>
	<tr>
		<td></td>
		<td style="font-size: 2em; font-weight: bold; text-align: center">
			<nobr><?=$params['BILL_HEADER'];?> <?=Loc::getMessage('SALE_HPS_BILL_SELLER_TITLE', array('#PAYMENT_NUM#' => $params["ACCOUNT_NUMBER"], '#PAYMENT_DATE#' => $params["PAYMENT_DATE_INSERT"]));?>
			</nobr>
		</td>
		<td></td>
	</tr>
<?endif;?>
<? if ($params["BILL_ORDER_SUBJECT"]) { ?>
	<tr>
		<td></td>
		<td><?=$params["BILL_ORDER_SUBJECT"]; ?></td>
		<td></td>
	</tr>
<? } ?>
<? if ($params["PAYMENT_DATE_PAY_BEFORE"]) { ?>
	<tr>
		<td></td>
		<td>
			<?=Loc::getMessage('SALE_HPS_BILL_SELLER_DATE_END', array('#PAYMENT_DATE_END#' => ConvertDateTime($params["PAYMENT_DATE_PAY_BEFORE"], FORMAT_DATE) ?: $params["PAYMENT_DATE_PAY_BEFORE"]));?>
		</td>
		<td></td>
	</tr>
<? } ?>
</table>

<br>
<?

if ($params['BILL_PAYER_SHOW'] == 'Y'):
	if ($params["BUYER_PERSON_COMPANY_NAME"]) {
		echo Loc::getMessage('SALE_HPS_BILL_BUYER_NAME', array('#BUYER_NAME#' => $params["BUYER_PERSON_COMPANY_NAME"]));
		if ($params["BUYER_PERSON_COMPANY_INN"])
			echo Loc::getMessage('SALE_HPS_BILL_BUYER_INN', array('#INN#' => $params["BUYER_PERSON_COMPANY_INN"]));
		if ($params["BUYER_PERSON_COMPANY_ADDRESS"])
		{
			$buyerAddr = $params["BUYER_PERSON_COMPANY_ADDRESS"];
			if (is_array($buyerAddr))
				$buyerAddr = implode(', ', $buyerAddr);
			else
				$buyerAddr = str_replace(array("\r\n", "\n", "\r"), ', ', strval($buyerAddr));
			echo sprintf(", %s", $buyerAddr);
		}
		if ($params["BUYER_PERSON_COMPANY_PHONE"])
			echo sprintf(", %s", $params["BUYER_PERSON_COMPANY_PHONE"]);
		if ($params["BUYER_PERSON_COMPANY_FAX"])
			echo sprintf(", %s", $params["BUYER_PERSON_COMPANY_FAX"]);
		if ($params["BUYER_PERSON_COMPANY_NAME_CONTACT"])
			echo sprintf(", %s", $params["BUYER_PERSON_COMPANY_NAME_CONTACT"]);
	}
endif;
?>

<br>
<br>

<?
$arCurFormat = CCurrencyLang::GetCurrencyFormat($payment->getField('CURRENCY'));
$currency = preg_replace('/(^|[^&])#/', '${1}', $arCurFormat['FORMAT_STRING']);

$basketItems = array();

/** @var \Bitrix\Sale\PaymentCollection $paymentCollection */
$paymentCollection = $payment->getCollection();

/** @var \Bitrix\Sale\Order $order */
$order = $paymentCollection->getOrder();

/** @var \Bitrix\Sale\Basket $basket */
$basket = $order->getBasket();

$items = $this->getBusinessValue($payment, 'BASKET_ITEMS');

if (is_array($items) && $items)
{
	foreach ($items as $basketItem)
		$basketItems[] = $basket->getItemById($basketItem['ID']);
}
else
{
	/** @var \Bitrix\Sale\Basket $basket */
	$basket = $order->getBasket();

	foreach ($basket->getBasketItems() as $basketItem)
		$basketItems[] = $basketItem;
}

$cells = array();
$props = array();

$n = 0;
$sum = 0.00;
$vat = 0;
$cntBasketItem = 0;

$columnList = array('NUMBER', 'NAME', 'QUANTITY', 'MEASURE', 'PRICE', 'VAT_RATE', 'SUM');
$arColsCaption = array();
$vatRateColumn = 0;
foreach ($columnList as $column)
{
	if ($params['BILL_COLUMN_'.$column.'_SHOW'] == 'Y')
	{
		$arColsCaption[$column] = $params['BILL_COLUMN_'.$column.'_TITLE'];
		if (in_array($column, array('PRICE', 'SUM')))
			$arColsCaption[$column] .= ', '.$currency;
	}
}
$arColumnKeys = array_keys($arColsCaption);
$columnCount = count($arColumnKeys);

/** @var \Bitrix\Sale\BasketItem $basketItem */
foreach ($basketItems as $basketItem)
{
	$productName = $basketItem->getField("NAME");
	if ($productName == "OrderDelivery")
		$productName = Loc::getMessage('SALE_HPS_BILL_DELIVERY');
	else if ($productName == "OrderDiscount")
		$productName = Loc::getMessage('SALE_HPS_BILL_DISCOUNT');

	if ($basketItem->isVatInPrice())
		$basketItemPrice = $basketItem->getPrice();
	else
		$basketItemPrice = $basketItem->getPrice()*(1 + $basketItem->getVatRate());

	$cells[++$n] = array();
	foreach ($arColsCaption as $columnId => $caption)
	{
		$data = null;

		switch ($columnId)
		{
			case 'NUMBER':
				$data = $n;
				break;
			case 'NAME':
				$data = htmlspecialcharsbx($productName);
				break;
			case 'QUANTITY':
				$data = roundEx($basketItem->getQuantity(), SALE_VALUE_PRECISION);
				break;
			case 'MEASURE':
				$data = $basketItem->getField("MEASURE_NAME") ? htmlspecialcharsbx($basketItem->getField("MEASURE_NAME")) : Loc::getMessage('SALE_HPS_BILL_BASKET_MEASURE_DEFAULT');
				break;
			case 'PRICE':
				$data = SaleFormatCurrency($basketItem->getPrice(), $basketItem->getCurrency(), true);
				break;
			case 'VAT_RATE':
				$data = roundEx($basketItem->getVatRate() * 100, SALE_VALUE_PRECISION)."%";
				break;
			case 'SUM':
				$data = SaleFormatCurrency($basketItemPrice * $basketItem->getQuantity(), $basketItem->getCurrency(), true);
				break;
		}
		if ($data !== null)
			$cells[$n][$columnId] = $data;
	}
	$props[$n] = array();
	/** @var \Bitrix\Sale\BasketPropertyItem $basketPropertyItem */
	foreach ($basketItem->getPropertyCollection() as $basketPropertyItem)
	{
		if ($basketPropertyItem->getField('CODE') == 'CATALOG.XML_ID' || $basketPropertyItem->getField('CODE') == 'PRODUCT.XML_ID')
			continue;
		$props[$n][] = htmlspecialcharsbx(sprintf("%s: %s", $basketPropertyItem->getField("NAME"), $basketPropertyItem->getField("VALUE")));
	}
	$sum += doubleval($basketItem->getPrice() * $basketItem->getQuantity());
	$vat = max($vat, $basketItem->getVatRate());
}

if ($vat <= 0)
{
	unset($arColsCaption['VAT_RATE']);
	$columnCount = count($arColsCaption);
	$arColumnKeys = array_keys($arColsCaption);
	foreach ($cells as $i => $cell)
		unset($cells[$i]['VAT_RATE']);
}

/** @var \Bitrix\Sale\ShipmentCollection $shipmentCollection */
$shipmentCollection = $order->getShipmentCollection();

$shipment = null;

/** @var \Bitrix\Sale\Shipment $shipmentItem */
foreach ($shipmentCollection as $shipmentItem)
{
	if (!$shipmentItem->isSystem())
	{
		$shipment = $shipmentItem;
		break;
	}
}

if ($shipment !== null && $shipment->getPrice() > 0)
{
	$deliveryItem = Loc::getMessage('SALE_HPS_BILL_DELIVERY');

	if ($shipment->getDeliveryName())
		$deliveryItem .= sprintf(" (%s)", $shipment->getDeliveryName());
	$cells[++$n] = array();
	foreach ($arColsCaption as $columnId => $caption)
	{
		$data = null;

		switch ($columnId)
		{
			case 'NUMBER':
				$data = $n;
				break;
			case 'NAME':
				$data = htmlspecialcharsbx($deliveryItem);
				break;
			case 'QUANTITY':
				$data = 1;
				break;
			case 'MEASURE':
				$data = '';
				break;
			case 'PRICE':
				$data = SaleFormatCurrency($shipment->getPrice(), $shipment->getCurrency(), true);
				break;
			case 'VAT_RATE':
				$data = roundEx($vat * 100, SALE_VALUE_PRECISION)."%";
				break;
			case 'SUM':
				$data = SaleFormatCurrency($shipment->getPrice(), $shipment->getCurrency(), true);
				break;
		}
		if ($data !== null)
			$cells[$n][$columnId] = $data;
	}
	$sum += doubleval($shipment->getPrice());
}

if ($params['BILL_TOTAL_SHOW'] == 'Y')
{
	$cntBasketItem = $n;
	if ($sum < $payment->getSum())
	{
		$cells[++$n] = array();
		for ($i = 0; $i < $columnCount; $i++)
			$cells[$n][$arColumnKeys[$i]] = null;

		$cells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_SUBTOTAL'));
		$cells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($sum, $payment->getField('CURRENCY'), true));
	}

	/** @var \Bitrix\Sale\Tax $taxes */
	$taxes = $order->getTax();

	$taxList = $taxes->getTaxList();
	if ($taxList)
	{
		foreach ($taxes->getTaxList() as $tax)
		{
			$cells[++$n] = array();
			for ($i = 0; $i < $columnCount; $i++)
				$cells[$n][$arColumnKeys[$i]] = null;

			$cells[$n][$arColumnKeys[$columnCount-2]] = htmlspecialcharsbx(sprintf(
					"%s%s%s:",
					($tax["IS_IN_PRICE"] == "Y") ? Loc::getMessage('SALE_HPS_BILL_INCLUDING') : "",
					$tax["TAX_NAME"],
					($vat <= 0 && $tax["IS_PERCENT"] == "Y")
							? sprintf(' (%s%%)', roundEx($tax["VALUE"], SALE_VALUE_PRECISION))
							: ""
			));
			$cells[$n][$arColumnKeys[$columnCount-1]] = SaleFormatCurrency($tax["VALUE_MONEY"], $payment->getField('CURRENCY'), true);
		}
	}

	if (!$taxList)
	{
		$cells[++$n] = array();
		for ($i = 0; $i < $columnCount; $i++)
			$cells[$n][$i] = null;

		$cells[$n][$arColumnKeys[$columnCount-2]] = htmlspecialcharsbx(Loc::getMessage('SALE_HPS_BILL_TOTAL_VAT_RATE'));
		$cells[$n][$arColumnKeys[$columnCount-1]] = htmlspecialcharsbx(Loc::getMessage('SALE_HPS_BILL_TOTAL_VAT_RATE_NO'));
	}
	$sumPaid = $paymentCollection->getPaidSum();
	if (DoubleVal($sumPaid) > 0)
	{
		$cells[++$n] = array();
		for ($i = 0; $i < $columnCount; $i++)
			$cells[$n][$arColumnKeys[$i]] = null;

		$cells[$n][$arColumnKeys[$columnCount-2]] = Loc::getMessage('SALE_HPS_BILL_TOTAL_PAID');
		$cells[$n][$arColumnKeys[$columnCount-1]] = SaleFormatCurrency($sumPaid, $payment->getField('CURRENCY'), true);
	}
	if (DoubleVal($order->getDiscountPrice()) > 0)
	{
		$cells[++$n] = array();
		for ($i = 0; $i < $columnCount; $i++)
			$cells[$n][$arColumnKeys[$i]] = null;

		$cells[$n][$arColumnKeys[$columnCount-2]] = Loc::getMessage('SALE_HPS_BILL_TOTAL_DISCOUNT');
		$cells[$n][$arColumnKeys[$columnCount-1]] = SaleFormatCurrency($order->getDiscountPrice(), $order->getCurrency(), true);
	}

	$cells[++$n] = array();
	for ($i = 0; $i < $columnCount; $i++)
		$cells[$n][$arColumnKeys[$i]] = null;

	$cells[$n][$arColumnKeys[$columnCount-2]] = Loc::getMessage('SALE_HPS_BILL_TOTAL_SUM');
	$cells[$n][$arColumnKeys[$columnCount-1]] = SaleFormatCurrency($payment->getSum(), $payment->getField('CURRENCY'), true);
}
?>
<table class="it" width="100%">
	<tr>
	<?foreach ($arColsCaption as $columnId => $caption):?>
		<td><nobr><?=$caption;?></nobr></td>
	<?endforeach;?>
	</tr>
<?

$rowsCnt = count($cells);
for ($n = 1; $n <= $rowsCnt; $n++):

	$accumulated = 0;
?>
	<tr valign="top">
	<?foreach ($arColsCaption as $columnId => $caption):?>
		<?
			if (!is_null($cells[$n][$columnId]))
			{
				if ($columnId === 'NUMBER')
				{?>
					<td align="center"><?=$cells[$n][$columnId];?></td>
				<?}
				elseif ($columnId === 'NAME')
				{
				?>
					<td align="<?=($n > $cntBasketItem) ? 'right' : 'left';?>"
						style="word-break: break-word; word-wrap: break-word; <? if ($accumulated) {?>border-width: 0pt 1pt 0pt 0pt; <? } ?>"
						<? if ($accumulated) { ?>colspan="<?=($accumulated+1); ?>"<? $accumulated = 0; } ?>>
						<?=$cells[$n][$columnId]; ?>
						<? if (isset($props[$n]) && is_array($props[$n])) { ?>
						<? foreach ($props[$n] as $property) { ?>
						<br>
						<small><?=$property; ?></small>
						<? } ?>
						<? } ?>
					</td>
				<?}
				else
				{
					if (!is_null($cells[$n][$columnId]))
					{
						if ($columnId != 'VAT_RATE' || $vat > 0 || is_null($cells[$n][$columnId]) || $n > $cntBasketItem)
						{ ?>
							<td align="right"
								<? if ($accumulated) { ?>
								style="border-width: 0pt 1pt 0pt 0pt"
								colspan="<?=(($columnId == 'VAT_RATE' && $vat <= 0) ? $accumulated : $accumulated+1); ?>"
								<? $accumulated = 0; } ?>>
								<nobr><?=$cells[$n][$columnId]; ?></nobr>
							</td>
						<? }
					}
					else
					{
						$accumulated++;
					}
				}
			}
			else
			{
				$accumulated++;
			}
		?>
	<?endforeach;?>
	</tr>

<?endfor;?>
</table>
<br>

<?if ($params['BILL_TOTAL_SHOW'] == 'Y'):?>
	<?=Loc::getMessage(
			'SALE_HPS_BILL_BASKET_TOTAL',
			array(
					'#BASKET_COUNT#' => $cntBasketItem,
					'#BASKET_PRICE#' => SaleFormatCurrency($payment->getField('SUM'), $payment->getField('CURRENCY'), false)
			)
	);?>
	<br>

	<b>
	<?

	if (in_array($payment->getField('CURRENCY'), array("RUR", "RUB")))
	{
		echo Number2Word_Rus($payment->getField('SUM'));
	}
	else
	{
		echo SaleFormatCurrency(
			$payment->getField('SUM'),
			$payment->getField('CURRENCY'),
			false
		);
	}

	?>
	</b>
<?endif;?>
<br>
<br>

<? if ($params["BILL_COMMENT1"] || $params["BILL_COMMENT2"]) { ?>
<b><?=Loc::getMessage('SALE_HPS_BILL_COND_COMM')?></b>
<br>
	<? if ($params["BILL_COMMENT1"]) { ?>
	<?=nl2br(HTMLToTxt(preg_replace(
		array('#</div>\s*<div[^>]*>#i', '#</?div>#i'), array('<br>', '<br>'),
		htmlspecialcharsback($params["BILL_COMMENT1"])
	), '', array(), 0)); ?>
	<br>
	<br>
	<? } ?>
	<? if ($params["BILL_COMMENT2"]) { ?>
	<?=nl2br(HTMLToTxt(preg_replace(
		array('#</div>\s*<div[^>]*>#i', '#</?div>#i'), array('<br>', '<br>'),
		htmlspecialcharsback($params["BILL_COMMENT2"])
	), '', array(), 0)); ?>
	<br>
	<br>
	<? } ?>
<? } ?>

<br>
<br>

<?if ($params['BILL_SIGN_SHOW'] == 'Y'):?>
	<? if (!$blank) { ?>
	<div style="position: relative; "><?=CFile::ShowImage(
			$params["BILL_PATH_TO_STAMP"],
		160, 160,
		'style="position: absolute; left: 40pt; "'
	); ?></div>
	<? } ?>

	<div style="position: relative">
		<table class="sign">
			<? if ($params["SELLER_COMPANY_DIRECTOR_POSITION"]) { ?>
			<tr>
				<td style="width: 150pt; "><?=$params["SELLER_COMPANY_DIRECTOR_POSITION"]; ?></td>
				<td style="width: 160pt; border: 1pt solid #000000; border-width: 0pt 0pt 1pt 0pt; text-align: center; ">
					<? if (!$blank) { ?>
					<?=CFile::ShowImage($params["SELLER_COMPANY_DIR_SIGN"], 200, 50); ?>
					<? } ?>
				</td>
				<td>
					<? if ($params["SELLER_COMPANY_DIRECTOR_NAME"]) { ?>
					(<?=$params["SELLER_COMPANY_DIRECTOR_NAME"]; ?>)
					<? } ?>
				</td>
			</tr>
			<tr><td colspan="3">&nbsp;</td></tr>
			<? } ?>
			<? if ($params["SELLER_COMPANY_ACCOUNTANT_POSITION"]) { ?>
			<tr>
				<td style="width: 150pt; "><?=$params["SELLER_COMPANY_ACCOUNTANT_POSITION"]; ?></td>
				<td style="width: 160pt; border: 1pt solid #000000; border-width: 0pt 0pt 1pt 0pt; text-align: center; ">
					<? if (!$blank) { ?>
					<?=CFile::ShowImage($params["SELLER_COMPANY_ACC_SIGN"], 200, 50); ?>
					<? } ?>
				</td>
				<td>
					<? if ($params["SELLER_COMPANY_ACCOUNTANT_NAME"]) { ?>
					(<?=$params["SELLER_COMPANY_ACCOUNTANT_NAME"]; ?>)
					<? } ?>
				</td>
			</tr>
			<? } ?>
		</table>
	</div>
<?endif;?>

</div>

</body>
</html>