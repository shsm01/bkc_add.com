<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (!CSalePdf::isPdfAvailable())
	die();

if ($_REQUEST['BLANK'] == 'Y')
	$blank = true;

$pdf = new CSalePdf('P', 'pt', 'A4');

if ($params['BILLUA_BACKGROUND'])
{
	$pdf->SetBackground(
		$params['BILLUA_BACKGROUND'],
		$params['BILLUA_BACKGROUND_STYLE']
	);
}

$pageWidth  = $pdf->GetPageWidth();
$pageHeight = $pdf->GetPageHeight();

$pdf->AddFont('Font', '', 'pt_sans-regular.ttf', true);
$pdf->AddFont('Font', 'B', 'pt_sans-bold.ttf', true);

$fontFamily = 'Font';
$fontSize   = 10.5;

$margin = array(
	'top' => intval($params['BILLUA_MARGIN_TOP'] ?: 15) * 72/25.4,
	'right' => intval($params['BILLUA_MARGIN_RIGHT'] ?: 15) * 72/25.4,
	'bottom' => intval($params['BILLUA_MARGIN_BOTTOM'] ?: 15) * 72/25.4,
	'left' => intval($params['BILLUA_MARGIN_LEFT'] ?: 20) * 72/25.4
);

$width = $pageWidth - $margin['left'] - $margin['right'];

$pdf->SetDisplayMode(100, 'continuous');
$pdf->SetMargins($margin['left'], $margin['top'], $margin['right']);
$pdf->SetAutoPageBreak(true, $margin['bottom']);

$pdf->AddPage();


$pdf->SetFont($fontFamily, 'B', $fontSize);
if($params['BILLUA_HEADER'])
{
	$pdf->Write(15, CSalePdf::prepareToPdf($params['BILLUA_HEADER']).CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILLUA_TITLE', array('#PAYMENT_NUMBER#' => htmlspecialcharsbx($params["ACCOUNT_NUMBER"]), '#PAYMENT_DATE#' => $params["DATE_INSERT"]))));
	$pdf->Ln();
	$pdf->Ln();
}
if ($params['BILLUA_SELLER_SHOW'] == 'Y')
{
	$pdf->SetFont($fontFamily, '', $fontSize);

	$title = CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILLUA_SELLER').': ');
	$title_width = $pdf->GetStringWidth($title);
	$pdf->Write(15, $title);

	$pdf->Write(15, CSalePdf::prepareToPdf($params["SELLER_COMPANY_NAME"]));
	$pdf->Ln();

	$pdf->Cell($title_width, 15, '');
	$pdf->MultiCell(0, 15, CSalePdf::prepareToPdf(sprintf(
			Loc::getMessage('SALE_HPS_BILLUA_SELLER_COMPANY_RS').' %s, '.Loc::getMessage('SALE_HPS_BILLUA_SELLER_COMPANY_BANK').' %s, '.Loc::getMessage('SALE_HPS_BILLUA_SELLER_COMPANY_MFO').' %s',
		$params["SELLER_COMPANY_BANK_ACCOUNT"],
		$params["SELLER_COMPANY_BANK_NAME"],
		$params["SELLER_COMPANY_MFO"]
	)));

	$sellerAddr = '';
	if ($params["SELLER_COMPANY_ADDRESS"])
	{
		$sellerAddr = $params["SELLER_COMPANY_ADDRESS"];
		if (is_array($sellerAddr))
			$sellerAddr = implode(', ', $sellerAddr);
		else
			$sellerAddr = str_replace(array("\r\n", "\n", "\r"), ', ', strval($sellerAddr));
	}

	$pdf->Cell($title_width, 15, '');
	$pdf->MultiCell(0, 15, CSalePdf::prepareToPdf(sprintf(
		Loc::getMessage('SALE_HPS_BILLUA_SELLER_COMPANY_ADDRESS').': %s, '.Loc::getMessage('SALE_HPS_BILLUA_SELLER_COMPANY_PHONE').': %s',
		$sellerAddr,
		$params["SELLER_COMPANY_PHONE"]
	)));

	$pdf->Cell($title_width, 15, '');
	$pdf->MultiCell(0, 15, CSalePdf::prepareToPdf(sprintf(
		Loc::getMessage('SALE_HPS_BILLUA_SELLER_COMPANY_EDRPOY').': %s, '.Loc::getMessage('SALE_HPS_BILLUA_SELLER_COMPANY_IPN').': %s, '.Loc::getMessage('SALE_HPS_BILLUA_SELLER_COMPANY_PDV').': %s',
		$params["SELLER_COMPANY_EDRPOY"],
		$params["SELLER_COMPANY_IPN"],
		$params["SELLER_COMPANY_PDV"]
	)));

	if ($params["SELLER_COMPANY_SYS"])
	{
		$pdf->Cell($title_width, 15, '');
		$pdf->Write(15, CSalePdf::prepareToPdf($params["SELLER_COMPANY_SYS"]));
		$pdf->Ln();
	}
	$pdf->Ln();
}

if ($params['BILLUA_PAYER_SHOW'] === 'Y')
{
	$pdf->Cell($title_width, 15, CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILLUA_BUYER').': '));

	$pdf->Write(15, CSalePdf::prepareToPdf($params["BUYER_PERSON_COMPANY_NAME"]));
	$pdf->Ln();

	$buyerPhone = $params["BUYER_PERSON_COMPANY_PHONE"];
	$buyerFax = $params["BUYER_PERSON_COMPANY_FAX"];
	if ($buyerPhone || $buyerFax)
	{
		$pdf->Cell($title_width, 15, '');

		if ($buyerPhone)
		{
			$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(Loc::getMessage('SALE_HPS_BILLUA_BUYER_PHONE').': %s', $buyerPhone)));
			if ($buyerFax)
				$pdf->Write(15, CSalePdf::prepareToPdf(', '));
		}

		if ($buyerFax)
			$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(Loc::getMessage('SALE_HPS_BILLUA_BUYER_FAX').': %s', $buyerFax)));

		$pdf->Ln();
	}

	if ($params["BUYER_PERSON_COMPANY_ADDRESS"])
	{
		$buyerAddr = $params["BUYER_PERSON_COMPANY_ADDRESS"];
		if (is_array($buyerAddr))
			$buyerAddr = implode(', ', $buyerAddr);
		else
			$buyerAddr = str_replace(array("\r\n", "\n", "\r"), ', ', strval($buyerAddr));
		$pdf->Cell($title_width, 15, '');
		$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(
			Loc::getMessage('SALE_HPS_BILLUA_BUYER_ADDRESS').': %s',
			$buyerAddr
		)));
		$pdf->Ln();
	}

	$pdf->Ln();

	if ($params["BUYER_PERSON_COMPANY_DOGOVOR"])
	{
		$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(
			Loc::getMessage('SALE_HPS_BILLUA_BUYER_DOGOVOR').': %s',
				$params["BUYER_PERSON_COMPANY_DOGOVOR"]
		)));

		$pdf->Ln();
	}
}
$basketItems = array();

/** @var \Bitrix\Sale\PaymentCollection $paymentCollection */
$paymentCollection = $payment->getCollection();

/** @var \Bitrix\Sale\Order $order */
$order = $paymentCollection->getOrder();

/** @var \Bitrix\Sale\Basket $basket */
$basket = $order->getBasket();

$arCurFormat = CCurrencyLang::GetCurrencyFormat($order->getCurrency());
$currency = trim(str_replace('#', '', $arCurFormat['FORMAT_STRING']));

$arCells = array();
$columnList = array('NUMBER', 'NAME', 'QUANTITY', 'MEASURE', 'PRICE', 'VAT_RATE', 'SUM');
$arColsCaption = array();
foreach ($columnList as $column)
{
	if ($params['BILLUA_COLUMN_'.$column.'_SHOW'] == 'Y')
	{
		$arColsCaption[$column] = CSalePdf::prepareToPdf($params['BILLUA_COLUMN_'.$column.'_TITLE']);
		if (in_array($column, array('PRICE', 'SUM')))
			$arColsCaption[$column] .= ', '.CSalePdf::prepareToPdf($currency);
	}
}
$arColumnKeys = array_keys($arColsCaption);
$columnCount = count($arColumnKeys);

if (count($basket->getBasketItems()) > 0)
{
	$arCells = array();
	$arProps = array();
	$arRowsWidth = array();

	foreach ($arColsCaption as $columnId => $caption)
		$arRowsWidth[$columnId] = 0;

	$n = 0;
	$sum = 0.00;
	$vat = 0;

	/** @var \Bitrix\Sale\BasketItem $basketItem */
	foreach ($basket->getBasketItems() as $basketItem)
	{
		$productName = $basketItem->getField("NAME");
		if ($productName == "OrderDelivery")
			$productName = Loc::getMessage('SALE_HPS_BILLUA_DELIVERY');
		else if ($productName == "OrderDiscount")
			$productName = Loc::getMessage('SALE_HPS_BILLUA_DISCOUNT');

		if ($basketItem->isVatInPrice())
			$basketItemPrice = $basketItem->getPrice();
		else
			$basketItemPrice = $basketItem->getPrice()*(1 + $basketItem->getVatRate());

		$arCells[++$n] = array();
		foreach ($arColsCaption as $columnId => $caption)
		{
			$data = null;

			switch ($columnId)
			{
				case 'NUMBER':
					$data = CSalePdf::prepareToPdf($n);
					break;
				case 'NAME':
					$data = CSalePdf::prepareToPdf($productName);
					break;
				case 'QUANTITY':
					$data = CSalePdf::prepareToPdf(roundEx($basketItem->getQuantity(), SALE_VALUE_PRECISION));
					break;
				case 'MEASURE':
					$data = CSalePdf::prepareToPdf($basketItem->getField("MEASURE_NAME") ? $basketItem->getField("MEASURE_NAME") : Loc::getMessage('SALE_HPS_BILLUA_MEASHURE'));
					break;
				case 'PRICE':
					$data = CSalePdf::prepareToPdf(SaleFormatCurrency($basketItem->getPrice(), $basketItem->getCurrency(), true));
					break;
				case 'VAT_RATE':
					$data = CSalePdf::prepareToPdf(roundEx($basketItem->getVatRate()*100, SALE_VALUE_PRECISION)."%");
					break;
				case 'SUM':
					$data = CSalePdf::prepareToPdf(SaleFormatCurrency($basketItemPrice * $basketItem->getQuantity(), $basketItem->getCurrency(), true));
					break;
			}
			if ($data !== null)
				$arCells[$n][$columnId] = $data;
		}

		$arProps[$n] = array();

		/** @var \Bitrix\Sale\BasketPropertyItem $basketPropertyItem */
		foreach ($basketItem->getPropertyCollection() as $basketPropertyItem)
		{
			if ($basketPropertyItem->getField('CODE') == 'CATALOG.XML_ID' || $basketPropertyItem->getField('CODE') == 'PRODUCT.XML_ID')
				continue;
			$arProps[$n][] = CSalePdf::prepareToPdf(sprintf("%s: %s", $basketPropertyItem->getField("NAME"), $basketPropertyItem->getField("VALUE")));
		}

		foreach ($arColsCaption as $columnId => $caption)
			$arRowsWidth[$columnId] = max($arRowsWidth[$columnId], $pdf->GetStringWidth($arCells[$n][$columnId]));

		$sum += doubleval($basketItem->getPrice() * $basketItem->getQuantity());
		$vat = max($vat, $basketItem->getVatRate());
	}

	if ($vat <= 0)
	{
		unset($arColsCaption['VAT_RATE']);
		$columnCount = count($arColsCaption);
		$arColumnKeys = array_keys($arColsCaption);
		foreach ($arCells as $i => $cell)
			unset($arCells[$i]['VAT_RATE']);
	}

	if ($vat > 0 && array_key_exists('PRICE', $arColsCaption))
		$arColsCaption['PRICE'] = CSalePdf::prepareToPdf($params['BILLUA_COLUMN_PRICE_TAX_TITLE'].', '.$currency);

	if ($vat > 0 && array_key_exists('SUM', $arColsCaption))
		$arColsCaption['SUM'] = CSalePdf::prepareToPdf($params['BILLUA_COLUMN_SUM_TAX_TITLE'].', '.$currency);


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

	if ($shipment && (float)$shipment->getPrice() > 0)
	{
		$sDeliveryItem = Loc::getMessage('SALE_HPS_BILLUA_DELIVERY');
		if ($shipment->getDeliveryName())
			$sDeliveryItem .= sprintf(" (%s)", $shipment->getDeliveryName());

		$arCells[++$n] = array();
		foreach ($arColsCaption as $columnId => $caption)
		{
			$data = null;

			switch ($columnId)
			{
				case 'NUMBER':
					$data = CSalePdf::prepareToPdf($n);
					break;
				case 'NAME':
					$data = CSalePdf::prepareToPdf($sDeliveryItem);
					break;
				case 'QUANTITY':
					$data = CSalePdf::prepareToPdf(1);
					break;
				case 'MEASURE':
					$data = CSalePdf::prepareToPdf('');
					break;
				case 'PRICE':
					$data = CSalePdf::prepareToPdf(SaleFormatCurrency($shipment->getPrice(), $shipment->getCurrency(), true));
					break;
				case 'VAT_RATE':
					$data = CSalePdf::prepareToPdf(roundEx($vat*100, SALE_VALUE_PRECISION)."%");
					break;
				case 'SUM':
					$data = CSalePdf::prepareToPdf(SaleFormatCurrency($shipment->getPrice(), $shipment->getCurrency(), true));
					break;
			}
			if ($data !== null)
				$arCells[$n][$columnId] = $data;
		}

		foreach ($arColsCaption as $columnId => $caption)
			$arRowsWidth[$columnId] = max($arRowsWidth[$columnId], $pdf->GetStringWidth($arCells[$n][$columnId]));

		$sum += doubleval($shipment->getPrice());
	}

	$items = $n;
	$orderTax = 0;
	$taxes = $order->getTax();
	if ($params['BILLUA_TOTAL_SHOW'] === 'Y')
	{
		$taxesList = $taxes->getTaxList();
		if ($taxesList)
		{
			foreach ($taxesList as $tax)
			{
				$arCells[++$n] = array();
				for ($i = 0; $i < $columnCount; $i++)
					$arCells[$n][$arColumnKeys[$i]] = null;

				$arCells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf(sprintf(
					"%s%s%s:",
					($tax["IS_IN_PRICE"] == "Y") ? Loc::getMessage('SALE_HPS_BILLUA_IN_PRICE') : "",
					($vat <= 0) ? $tax["TAX_NAME"] : Loc::getMessage('SALE_HPS_BILLUA_TAX'),
					($vat <= 0 && $tax["IS_PERCENT"] == "Y")
						? sprintf(' (%s%%)', roundEx($tax["VALUE"],SALE_VALUE_PRECISION))
						: ""
				));
				$arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency(
					$tax["VALUE_MONEY"],
					$order->getCurrency(),
					true
				));

				$orderTax += $tax["VALUE_MONEY"];

				$arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
			}
		}

		$sumPaid = $paymentCollection->getPaidSum();
		if (DoubleVal($sumPaid) > 0)
		{
			$arCells[++$n] = array();
			for ($i = 0; $i < $columnCount; $i++)
				$arCells[$n][$arColumnKeys[$i]] = null;

			$arCells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILLUA_PAYMENT_PAID').":");
			$arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($sumPaid, $order->getCurrency(), true));

			$arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
		}

		if (DoubleVal($order->getDiscountPrice()) > 0)
		{
			$arCells[++$n] = array();
			for ($i = 0; $i < $columnCount; $i++)
				$arCells[$n][$arColumnKeys[$i]] = null;

			$arCells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILLUA_DISCOUNT').":");
			$arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($order->getDiscountPrice(), $order->getCurrency(), true));

			$arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
		}

		$arCells[++$n] = array();
		for ($i = 0; $i < $columnCount; $i++)
			$arCells[$n][$arColumnKeys[$i]] = null;

		$arCells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf($vat <= 0 ? Loc::getMessage('SALE_HPS_BILLUA_SUM_WITHOUT_TAX').':' : Loc::getMessage('SALE_HPS_BILLUA_SUM').':');
		$arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($payment->getSum(), $order->getCurrency(), true));

		$arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
	}

	foreach ($arColsCaption as $columnId => $caption)
		$arRowsWidth[$columnId] = max($arRowsWidth[$columnId], $pdf->GetStringWidth($arColsCaption[$columnId]));

	foreach ($arColsCaption as $columnId => $caption)
		$arRowsWidth[$columnId] += 10;

	if (array_key_exists('NAME', $arColsCaption))
		$arRowsWidth['NAME'] = $width - (array_sum($arRowsWidth)-$arRowsWidth['NAME']);
}

$pdf->Ln();

$x0 = $pdf->GetX();
$y0 = $pdf->GetY();

foreach ($arColsCaption as $columnId => $column)
{
	if ($vat > 0 || $columnId !== 'VAT_RATE')
		$pdf->Cell($arRowsWidth[$columnId], 20, $column, 0, 0, 'C');
	$i = array_search($columnId, $arColumnKeys);
	${"x".($i+1)} = $pdf->GetX();
}

$pdf->Ln();

$y5 = $pdf->GetY();

$pdf->Line($x0, $y0, ${"x".$columnCount}, $y0);
for ($i = 0; $i <= $columnCount; $i++)
{
	if ($vat > 0 || $arColumnKeys[$i] != 'VAT_RATE')
		$pdf->Line(${"x$i"}, $y0, ${"x$i"}, $y5);
}
$pdf->Line($x0, $y5, ${'x'.$columnCount}, $y5);

$rowsCnt = count($arCells);
for ($n = 1; $n <= $rowsCnt; $n++)
{
	$arRowsWidth_tmp = $arRowsWidth;
	$accumulated = 0;
	foreach ($arColsCaption as $columnId => $column)
	{
		if (is_null($arCells[$n][$columnId]))
		{
			$accumulated += $arRowsWidth_tmp[$columnId];
			$arRowsWidth_tmp[$columnId] = null;
		}
		else
		{
			$arRowsWidth_tmp[$columnId] += $accumulated;
			$accumulated = 0;
		}
	}

	$x0 = $pdf->GetX();
	$y0 = $pdf->GetY();

	$pdf->SetFont($fontFamily, '', $fontSize);

	if (!is_null($arCells[$n]['NAME']))
	{
		$text = $arCells[$n]['NAME'];
		$cellWidth = $arRowsWidth_tmp['NAME'];
	}
	else
	{
		$text = (array_key_exists('VAT_RATE', $arCells[$n])) ? $arCells[$n]['VAT_RATE'] : '';
		$cellWidth = (array_key_exists('VAT_RATE', $arRowsWidth_tmp)) ? $arRowsWidth_tmp['VAT_RATE'] : 0;
	}

	$l = 0;
	do
	{
		if ($cellWidth-5 > 0)
			list($string, $text) = $pdf->splitString($text, $cellWidth-5);

		foreach ($arColsCaption as $columnId => $column)
		{
			if (in_array($columnId, array('QUANTITY', 'MEASURE', 'PRICE', 'SUM')))
			{
				if (!is_null($arCells[$n][$columnId]))
				{
					$pdf->Cell($arRowsWidth_tmp[$columnId], 15, ($l == 0) ? $arCells[$n][$columnId] : '', 0, 0, 'R');
				}
			}
			elseif ($columnId == 'NUMBER')
			{
				if (!is_null($arCells[$n][$columnId]))
					$pdf->Cell($arRowsWidth_tmp[$columnId], 15, ($l == 0) ? $arCells[$n][$columnId] : '', 0, 0, 'C');
			}
			elseif ($columnId == 'NAME')
			{
				if (!is_null($arCells[$n][$columnId]))
					$pdf->Cell($arRowsWidth_tmp[$columnId], 15, $string, 0, 0,  ($n > $items) ? 'R' : '');
			}
			elseif ($columnId == 'VAT_RATE')
			{
				if (!is_null($arCells[$n][$columnId]))
				{
					if (is_null($arCells[$n][$columnId]))
						$pdf->Cell($arRowsWidth_tmp[$columnId], 15, $string, 0, 0, 'R');
					else if ($vat > 0)
						$pdf->Cell($arRowsWidth_tmp[$columnId], 15, ($l == 0) ? $arCells[$n][$columnId] : '', 0, 0, 'R');
				}
			}

			if ($l == 0)
			{
				$pos = array_search($columnId, $arColumnKeys);
				${'x'.($pos+1)} = $pdf->GetX();
			}
		}

		$pdf->Ln();
		$l++;
	}
	while($pdf->GetStringWidth($text));

	if (isset($arProps[$n]) && is_array($arProps[$n]))
	{
		$pdf->SetFont($fontFamily, '', $fontSize-2);
		foreach ($arProps[$n] as $property)
		{
			$i = 0;
			$line = 0;
			foreach ($arColsCaption as $columnId => $caption)
			{
				$i++;
				if ($i == $columnCount)
					$line = 1;
				if ($columnId == 'NAME')
					$pdf->Cell($arRowsWidth_tmp[$columnId], 12, $property, 0, $line);
				else
					$pdf->Cell($arRowsWidth_tmp[$columnId], 12, '', 0, $line);
			}
		}
	}

	$y5 = $pdf->GetY();

	if ($y0 > $y5)
		$y0 = $margin['top'];
	for ($i = ($n > $items) ? $columnCount - 1 : 0; $i <= $columnCount; $i++)
	{
		if ($vat > 0 || $arColumnKeys[$i] != 'VAT_RATE')
			$pdf->Line(${"x$i"}, $y0, ${"x$i"}, $y5);
	}

	$pdf->Line(($n <= $items) ? $x0 : ${'x'.($columnCount-1)}, $y5, ${'x'.$columnCount}, $y5);
}
$pdf->Ln();
if ($params['BILLUA_TOTAL_SHOW'] === 'Y')
{
	$pdf->SetFont($fontFamily, 'B', $fontSize);
	$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(
		Loc::getMessage('SALE_HPS_BILLUA_BASKET_ITEMS_TOTAL'),
		$items,
		($payment->getField('CURRENCY') == "UAH")
			? Number2Word_Rus(
				$payment->getSum(),
				"Y",
				$payment->getField('CURRENCY')
			)
			: SaleFormatCurrency(
				$payment->getSum(),
				$payment->getField('CURRENCY'),
				false
			)
	)));
	$pdf->Ln();

	if ($vat > 0)
	{
		$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(
				Loc::getMessage('SALE_HPS_BILLUA_BASKET_ITEMS_TAX'),
			($payment->getField('CURRENCY') == "UAH")
				? Number2Word_Rus($orderTax, "Y", $payment->getField('CURRENCY'))
				: SaleFormatCurrency($orderTax, $payment->getField('CURRENCY'), false)
		)));
	}
	else
	{
		$pdf->Write(15, CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILLUA_BASKET_ITEMS_WITHOUT_TAX')));
	}
	$pdf->Ln();
	$pdf->Ln();
}
if ($params["BILLUA_COMMENT1"] || $params["BILLUA_COMMENT2"])
{
	$pdf->Write(15, CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILLUA_COMMENT')));
	$pdf->Ln();

	$pdf->SetFont($fontFamily, '', $fontSize);

	if ($params["BILLUA_COMMENT1"])
	{
		$pdf->Write(15, HTMLToTxt(preg_replace(
			array('#</div>\s*<div[^>]*>#i', '#</?div>#i'), array('<br>', '<br>'),
			CSalePdf::prepareToPdf($params["BILLUA_COMMENT1"])
		), '', array(), 0));
		$pdf->Ln();
		$pdf->Ln();
	}

	if ($params["BILLUA_COMMENT2"])
	{
		$pdf->Write(15, HTMLToTxt(preg_replace(
			array('#</div>\s*<div[^>]*>#i', '#</?div>#i'), array('<br>', '<br>'),
			CSalePdf::prepareToPdf($params["BILLUA_COMMENT2"])
		), '', array(), 0));
		$pdf->Ln();
		$pdf->Ln();
	}
}

$pdf->Ln();
if ($params['BILLUA_FOOTER_SHOW'] == 'Y')
{
	if ($params['BILLUA_PATH_TO_STAMP'])
	{
		$filePath = $pdf->GetImagePath($params['BILLUA_PATH_TO_STAMP']);
		if ($filePath != '' && !$blank && \Bitrix\Main\IO\File::isFileExists($filePath))
		{
			list($stampHeight, $stampWidth) = $pdf->GetImageSize($params['BILLUA_PATH_TO_STAMP']);
			if ($stampHeight && $stampWidth)
			{
				if ($stampHeight > 120 || $stampWidth > 120)
				{
					$ratio = 120 / max($stampHeight, $stampWidth);
					$stampHeight = $ratio * $stampHeight;
					$stampWidth = $ratio * $stampWidth;
				}
				$pdf->Image(
						$params['BILLUA_PATH_TO_STAMP'],
						$margin['left'] + 40, $pdf->GetY(),
						$stampWidth, $stampHeight
				);
			}
		}
	}

	$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX()+$width, $pdf->GetY());
	$pdf->Ln();
	$pdf->Ln();

	$isAccSign = false;
	if (!$blank && $params['SELLER_COMPANY_ACC_SIGN'])
	{
		list($signHeight, $signWidth) = $pdf->GetImageSize($params['SELLER_COMPANY_ACC_SIGN']);

		if ($signHeight && $signWidth)
		{
			$ratio = min(37.5/$signHeight, 150/$signWidth);
			$signHeight = $ratio * $signHeight;
			$signWidth  = $ratio * $signWidth;

			$isAccSign = true;
		}
	}

	$pdf->SetFont($fontFamily, 'B', $fontSize);
	$pdf->Write(15, CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILLUA_WRITER').': '));

	if ($isAccSign)
	{
		$pdf->Image(
			$params['SELLER_COMPANY_ACC_SIGN'],
			$pdf->GetX() + 80 - $signWidth/2, $pdf->GetY() - $signHeight + 15,
			$signWidth, $signHeight
		);
	}

	$pdf->SetFont($fontFamily, '', $fontSize);
	$pdf->Cell(160, 15, '', 'B', 0, 'C');

	$pdf->Write(15, CSalePdf::prepareToPdf($params["SELLER_COMPANY_ACCOUNTANT_NAME"]));

	$pdf->SetX(max($pdf->GetX()+20, $margin['left']+3*$width/5));

	$pdf->SetFont($fontFamily, 'B', $fontSize);
	$pdf->Write(15, CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILLUA_ACC_POSITION').': '));

	$pdf->SetFont($fontFamily, '', $fontSize);
	$pdf->Cell(0, 15, CSalePdf::prepareToPdf($params["SELLER_COMPANY_ACCOUNTANT_POSITION"]), 'B', 0, 'C');

	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
}
if ($params["DATE_PAY_BEFORE"])
{
	$pdf->SetFont($fontFamily, 'B', $fontSize);
	$pdf->Cell(0, 15, CSalePdf::prepareToPdf(sprintf(
		Loc::getMessage('SALE_HPS_BILLUA_DATE_PAID_BEFORE'),
		ConvertDateTime($params["DATE_PAY_BEFORE"], FORMAT_DATE)
			?: $params["DATE_PAY_BEFORE"]
	)), 0, 0, 'R');
}


$dest = 'I';
if ($_REQUEST['GET_CONTENT'] == 'Y')
	$dest = 'S';
else if ($_REQUEST['DOWNLOAD'] == 'Y')
	$dest = 'D';

return $pdf->Output(
	sprintf(
		'Rakhunok No%s vid %s.pdf',
		str_replace(
			array(
				chr(0), chr(1), chr(2), chr(3), chr(4), chr(5), chr(6), chr(7), chr(8), chr(9), chr(10), chr(11),
				chr(12), chr(13), chr(14), chr(15), chr(16), chr(17), chr(18), chr(19), chr(20), chr(21), chr(22),
				chr(23), chr(24), chr(25), chr(26), chr(27), chr(28), chr(29), chr(30), chr(31),
				'"', '*', '/', ':', '<', '>', '?', '\\', '|'
			),
			'_',
			strval($params["ACCOUNT_NUMBER"])
		),
		ConvertDateTime($payment->getField("DATE_BILL"), 'YYYY-MM-DD')
	), $dest
);
?>