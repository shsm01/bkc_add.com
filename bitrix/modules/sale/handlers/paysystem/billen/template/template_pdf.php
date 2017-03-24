<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if (!CSalePdf::isPdfAvailable())
	die();

if ($_REQUEST['BLANK'] == 'Y')
	$blank = true;

$pdf = new CSalePdf('P', 'pt', 'A4');

if ($params['BILLEN_BACKGROUND'])
{
	$pdf->SetBackground(
		$params['BILLEN_BACKGROUND'],
		$params['BILLEN_BACKGROUND_STYLE']
	);
}

$pageWidth  = $pdf->GetPageWidth();
$pageHeight = $pdf->GetPageHeight();

$pdf->AddFont('Font', '', 'pt_sans-regular.ttf', true);
$pdf->AddFont('Font', 'B', 'pt_sans-bold.ttf', true);

$fontFamily = 'Font';
$fontSize   = 10.5;

$margin = array(
	'top' => intval($params['BILLEN_MARGIN_TOP'] ?: 15) * 72/25.4,
	'right' => intval($params['BILLEN_MARGIN_RIGHT'] ?: 15) * 72/25.4,
	'bottom' => intval($params['BILLEN_MARGIN_BOTTOM'] ?: 15) * 72/25.4,
	'left' => intval($params['BILLEN_MARGIN_LEFT'] ?: 20) * 72/25.4
);

$width = $pageWidth - $margin['left'] - $margin['right'];

$pdf->SetDisplayMode(100, 'continuous');
$pdf->SetMargins($margin['left'], $margin['top'], $margin['right']);
$pdf->SetAutoPageBreak(true, $margin['bottom']);

$pdf->AddPage();


$y0 = $pdf->GetY();
$logoHeight = 0;
$logoWidth = 0;

if ($params['BILLEN_PATH_TO_LOGO'])
{
	list($imageHeight, $imageWidth) = $pdf->GetImageSize($params['BILLEN_PATH_TO_LOGO']);

	$imgDpi = intval($params['BILLEN_LOGO_DPI']) ?: 96;
	$imgZoom = 96 / $imgDpi;

	$logoHeight = $imageHeight * $imgZoom + 5;
	$logoWidth  = $imageWidth * $imgZoom + 5;

	$pdf->Image($params['BILLEN_PATH_TO_LOGO'], $pdf->GetX(), $pdf->GetY(), -$imgDpi, -$imgDpi);
}

$pdf->SetFont($fontFamily, 'B', $fontSize);

$text = CSalePdf::prepareToPdf($params["SELLER_COMPANY_NAME"]);
$textWidth = $width - $logoWidth;
while ($pdf->GetStringWidth($text))
{
	list($string, $text) = $pdf->splitString($text, $textWidth);
	$pdf->SetX($pdf->GetX() + $logoWidth);
	$pdf->Cell($textWidth, 15, $string, 0, 0, 'L');
	$pdf->Ln();
}

if ($params["SELLER_COMPANY_ADDRESS"])
{
	$sellerAddress = $params["SELLER_COMPANY_ADDRESS"];
	if (is_string($sellerAddress))
	{
		$sellerAddress = explode("\n", str_replace(array("\r\n", "\n", "\r"), "\n", $sellerAddress));
		if (count($sellerAddress) === 1)
			$sellerAddress = $sellerAddress[0];
	}
	if (is_array($sellerAddress))
	{
		if (!empty($sellerAddress))
		{
			$i = 0;
			foreach ($sellerAddress as $item)
			{
				if ($i++ > 0)
					$pdf->Ln();

				$text = $pdf->prepareToPdf($item);
				$textWidth = $width - $logoWidth;
				while ($pdf->GetStringWidth($text))
				{
					list($string, $text) = $pdf->splitString($text, $textWidth);
					$pdf->SetX($pdf->GetX() + $logoWidth);
					$pdf->Cell($textWidth, 15, $string, 0, 0, 'L');
					$pdf->Ln();
				}
			}
			unset($item);
		}
	}
	else
	{
		$text = $pdf->prepareToPdf($sellerAddress);
		$textWidth = $width - $logoWidth;
		while ($pdf->GetStringWidth($text))
		{
			list($string, $text) = $pdf->splitString($text, $textWidth);
			$pdf->SetX($pdf->GetX() + $logoWidth);
			$pdf->Cell($textWidth, 15, $string, 0, 0, 'L');
			$pdf->Ln();
		}
	}
}

if ($params["SELLER_COMPANY_PHONE"])
{
	$pdf->Ln();
	$text = CSalePdf::prepareToPdf(sprintf("Tel.: %s", $params["SELLER_COMPANY_PHONE"]));
	$textWidth = $width - $logoWidth;
	while ($pdf->GetStringWidth($text))
	{
		list($string, $text) = $pdf->splitString($text, $textWidth);
		$pdf->SetX($pdf->GetX() + $logoWidth);
		$pdf->Cell($textWidth, 15, $string, 0, 0, 'L');
		$pdf->Ln();
	}
}

$pdf->Ln();
$pdf->SetY(max($y0 + $logoHeight, $pdf->GetY()));
$pdf->Ln();

if ($params['BILLEN_HEADER'])
{
	$pdf->SetFont($fontFamily, 'B', $fontSize * 2);
	$pdf->Cell(0, 15, CSalePdf::prepareToPdf($params['BILLEN_HEADER']), 0, 0, 'C');

	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
}
$pdf->SetFont($fontFamily, 'B', $fontSize);

if ($params['BILLEN_PAYER_SHOW'] === 'Y')
{
	if ($params["BUYER_PERSON_COMPANY_NAME"])
	{
		$pdf->Write(15, CSalePdf::prepareToPdf('To'));
	}

	$pdf->SetFont($fontFamily, '', $fontSize);

	$invoiceNo = CSalePdf::prepareToPdf($params["ACCOUNT_NUMBER"]);
	$invoiceNoWidth = $pdf->GetStringWidth($invoiceNo);

	$invoiceDate = CSalePdf::prepareToPdf($params["DATE_INSERT"]);
	$invoiceDateWidth = $pdf->GetStringWidth($invoiceDate);

	$invoiceDueDate = CSalePdf::prepareToPdf(
		ConvertDateTime($params["DATE_PAY_BEFORE"], FORMAT_DATE)
			?: $params["DATE_PAY_BEFORE"]
	);
	$invoiceDueDateWidth = $pdf->GetStringWidth($invoiceDueDate);

	$invoiceInfoWidth = max($invoiceNoWidth, $invoiceDateWidth, $invoiceDueDateWidth);

	$pdf->Cell(0, 15, $invoiceNo, 0, 0, 'R');

	$pdf->SetFont($fontFamily, 'B', $fontSize);

	$title = CSalePdf::prepareToPdf($params['BILLEN_HEADER'].' # ');
	$titleWidth = $pdf->GetStringWidth($title);
	$pdf->SetX($pdf->GetX() - $invoiceInfoWidth - $titleWidth - 6);
	$pdf->Write(15, $title, 0, 0, 'R');
	$pdf->Ln();

	$pdf->SetFont($fontFamily, '', $fontSize);

	if ($params["BUYER_PERSON_COMPANY_NAME"])
	{
		$pdf->Write(15, CSalePdf::prepareToPdf($params["BUYER_PERSON_COMPANY_NAME"]));
	}

	$pdf->Cell(0, 15, $invoiceDate, 0, 0, 'R');

	$pdf->SetFont($fontFamily, 'B', $fontSize);

	$title = CSalePdf::prepareToPdf('Issue Date: ');
	$titleWidth = $pdf->GetStringWidth($title);
	$pdf->SetX($pdf->GetX() - $invoiceInfoWidth - $titleWidth - 6);
	$pdf->Write(15, $title, 0, 0, 'R');
	$pdf->Ln();
}
$pdf->SetFont($fontFamily, '', $fontSize);

if ($params["BUYER_PERSON_COMPANY_NAME"])
{
	if ($params["BUYER_PERSON_COMPANY_ADDRESS"])
	{
		$buyerAddress = $params["BUYER_PERSON_COMPANY_ADDRESS"];
		if($buyerAddress)
		{
			if (is_string($buyerAddress))
			{
				$buyerAddress = explode("\n", str_replace(array("\r\n", "\n", "\r"), "\n", $buyerAddress));
				if (count($buyerAddress) === 1)
					$buyerAddress = $buyerAddress[0];
			}
			if (is_array($buyerAddress))
			{
				if (!empty($buyerAddress))
				{
					foreach ($buyerAddress as $item)
					{
						$pdf->Write(15, CSalePdf::prepareToPdf($item));
						$pdf->Ln();
					}
					unset($item);
				}
			}
			else
			{
				$pdf->Write(15, CSalePdf::prepareToPdf($buyerAddress));
				$pdf->Ln();
			}
		}
	}
}

if ($params["DATE_PAY_BEFORE"])
{
	$pdf->Cell(0, 15, $invoiceDueDate, 0, 0, 'R');

	$pdf->SetFont($fontFamily, 'B', $fontSize);

	$title = CSalePdf::prepareToPdf('Due Date: ');
	$titleWidth = $pdf->GetStringWidth($title);
	$pdf->SetX($pdf->GetX() - $invoiceInfoWidth - $titleWidth - 6);
	$pdf->Write(15, $title, 0, 0, 'R');
}

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();


$pdf->SetFont($fontFamily, '', $fontSize);


$basketItems = array();

/** @var \Bitrix\Sale\PaymentCollection $paymentCollection */
$paymentCollection = $payment->getCollection();

/** @var \Bitrix\Sale\Order $order */
$order = $paymentCollection->getOrder();

/** @var \Bitrix\Sale\Basket $basket */
$basket = $order->getBasket();

$columnList = array('NUMBER', 'NAME', 'QUANTITY', 'MEASURE', 'PRICE', 'VAT_RATE', 'SUM');
$arColsCaption = array();
$vatRateColumn = 0;
foreach ($columnList as $column)
{
	if ($params['BILLEN_COLUMN_'.$column.'_SHOW'] == 'Y')
		$arColsCaption[$column] = CSalePdf::prepareToPdf($params['BILLEN_COLUMN_'.$column.'_TITLE']);
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

	foreach ($arColsCaption as $columnId => $caption)
		$arRowsWidth[$columnId] = max($arRowsWidth[$columnId], $pdf->GetStringWidth($caption));

	$n = 0;
	$sum = 0.00;
	$vat = 0;
	$vats = array();

	/** @var \Bitrix\Sale\BasketItem $basketItem */
	foreach ($basket->getBasketItems() as $basketItem)
	{
		// @TODO: replace with real vatless price
		if ($basketItem->isVatInPrice())
			$vatLessPrice = roundEx($basketItem->getPrice() / (1 + $basketItem->getVatRate()), SALE_VALUE_PRECISION);
		else
			$vatLessPrice = $basketItem->getPrice();

		$productName = $basketItem->getField("NAME");
		if ($productName == "OrderDelivery")
			$productName = "Shipping";
		else if ($productName == "OrderDiscount")
			$productName = "Discount";

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
					$data = CSalePdf::prepareToPdf($basketItem->getField("MEASURE_NAME") ? $basketItem->getField("MEASURE_NAME") : 'pcs');
					break;
				case 'PRICE':
					$data = CSalePdf::prepareToPdf(SaleFormatCurrency($vatLessPrice, $basketItem->getCurrency(), false));
					break;
				case 'VAT_RATE':
					$data = CSalePdf::prepareToPdf(roundEx($basketItem->getVatRate()*100, SALE_VALUE_PRECISION)."%");
					break;
				case 'SUM':
					$data = CSalePdf::prepareToPdf(SaleFormatCurrency($vatLessPrice * $basketItem->getQuantity(), $basketItem->getCurrency(), false));
					break;
			}
			if ($data !== null)
				$arCells[$n][$columnId] = $data;
		}

		$arProps[$n] = array();

		/** @var \Bitrix\Sale\BasketPropertyItem $basketItemProperty */
		foreach ($basketItem->getPropertyCollection() as $basketItemProperty)
		{
			if ($basketItemProperty->getField('CODE') == 'CATALOG.XML_ID' || $basketItemProperty->getField('CODE') == 'PRODUCT.XML_ID')
				continue;

			$arProps[$n][] = CSalePdf::prepareToPdf(sprintf("%s: %s", $basketItemProperty->getField("NAME"), $basketItemProperty->getField("VALUE")));
		}

		foreach ($arColsCaption as $columnId => $caption)
			$arRowsWidth[$columnId] = max($arRowsWidth[$columnId], $pdf->GetStringWidth($arCells[$n][$columnId]));

		$sum += doubleval($vatLessPrice * $basketItem->getQuantity());
		$vat = max($vat, $basketItem->getVatRate());
		if ($basketItem->getVatRate() > 0)
		{
			if (!isset($vats[$basketItem->getVatRate()]))
				$vats[$basketItem->getVatRate()] = 0;

			if ($basketItem->isVatInPrice())
				$vats[$basketItem->getVatRate()] += ($basketItem->getPrice() - $vatLessPrice) * $basketItem->getQuantity();
			else
				$vats[$basketItem->getVatRate()] += ($basketItem->getPrice()*(1 + $basketItem->getVatRate()) - $vatLessPrice) * $basketItem->getQuantity();
		}
	}

	if ($vat <= 0)
	{
		unset($arColsCaption['VAT_RATE']);
		$columnCount = count($arColsCaption);
		$arColumnKeys = array_keys($arColsCaption);
		foreach ($arCells as $i => $cell)
			unset($arCells[$i]['VAT_RATE']);
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

	if ($shipment && (float)$shipment->getPrice() > 0)
	{
		$sDeliveryItem = "Shipping";
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
					$data = CSalePdf::prepareToPdf(SaleFormatCurrency($shipment->getPrice() / (1 + $vat), $shipment->getCurrency(), false));
					break;
				case 'VAT_RATE':
					$data = CSalePdf::prepareToPdf(roundEx($vat*100, SALE_VALUE_PRECISION)."%");
					break;
				case 'SUM':
					$data = CSalePdf::prepareToPdf(SaleFormatCurrency($shipment->getPrice() / (1 + $vat), $shipment->getCurrency(), false));
					break;
			}
			if ($data !== null)
				$arCells[$n][$columnId] = $data;
		}

		$sum += roundEx(
			doubleval($shipment->getPrice() / (1 + $vat)),
			SALE_VALUE_PRECISION
		);

		if ($vat > 0)
			$vats[$vat] += roundEx(
				$shipment->getPrice() * $vat / (1 + $vat),
				SALE_VALUE_PRECISION
			);
	}

	$items = $n;
	if ($params['BILLEN_TOTAL_SHOW'] == 'Y')
	{
		if ($sum < $payment->getSum())
		{
			$arCells[++$n] = array();
			for ($i = 0; $i < $columnCount; $i++)
				$arCells[$n][$arColumnKeys[$i]] = null;

			$arCells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf("Subtotal:");
			$arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($sum, $order->getCurrency(), false));

			$arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
		}

		if (!empty($vats))
		{
			// @TODO: remove on real vatless price implemented
			$delta = intval(roundEx(
				$payment->getSum() - $sum - array_sum($vats),
				SALE_VALUE_PRECISION
			) * pow(10, SALE_VALUE_PRECISION));

			if ($delta)
			{
				$vatRates = array_keys($vats);
				rsort($vatRates);

				$ful = intval($delta / count($vatRates));
				$ost = $delta % count($vatRates);

				foreach ($vatRates as $vatRate)
				{
					$vats[$vatRate] += ($ful + $ost) / pow(10, SALE_VALUE_PRECISION);

					if ($ost > 0)
						$ost--;
				}
			}

			foreach ($vats as $vatRate => $vatSum)
			{
				$arCells[++$n] = array();
				for ($i = 0; $i < $columnCount; $i++)
					$arCells[$n][$arColumnKeys[$i]] = null;

				$arCells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf(sprintf("Tax (%s%%):", roundEx($vatRate * 100, SALE_VALUE_PRECISION)));
				$arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($vatSum, $order->getCurrency(), false));

				$arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
			}
		}
		else
		{
			$taxes = $order->getTax();
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
						($tax["IS_IN_PRICE"] == "Y") ? "Included " : "",
						$tax["TAX_NAME"],
						sprintf(' (%s%%)', roundEx($tax["VALUE"], SALE_VALUE_PRECISION))
					));
					$arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($tax["VALUE_MONEY"], $order->getCurrency(), false));

					$arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
				}
			}
		}

		$sumPaid = $paymentCollection->getPaidSum();
		if (DoubleVal($sumPaid) > 0)
		{
			$arCells[++$n] = array();
			for ($i = 0; $i < $columnCount; $i++)
				$arCells[$n][$arColumnKeys[$i]] = null;

			$arCells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf("Payment made:");
			$arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($sumPaid, $order->getCurrency(), false));

			$arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
		}

		if (DoubleVal($order->getDiscountPrice()) > 0)
		{
			$arCells[++$n] = array();
			for ($i = 0; $i < $columnCount; $i++)
				$arCells[$n][$arColumnKeys[$i]] = null;

			$arCells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf("Discount:");
			$arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($order->getDiscountPrice(), $order->getCurrency(), false));

			$arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
		}

		$arCells[++$n] = array();
		for ($i = 0; $i < $columnCount; $i++)
			$arCells[$n][$arColumnKeys[$i]] = null;

		$arCells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf("Total:");
		$arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($payment->getSum(), $payment->getField('CURRENCY'), false));

		$arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
	}
	foreach ($arColsCaption as $columnId => $caption)
		$arRowsWidth[$columnId] += 10;
	if ($vat <= 0)
		$arRowsWidth['VAT_RATE'] = 0;
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
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();


$pdf->SetFont($fontFamily, 'B', $fontSize);

if ($params["BILLEN_COMMENT1"] || $params["BILLEN_COMMENT2"])
{
	$pdf->Write(15, CSalePdf::prepareToPdf('Terms & Conditions'));
	$pdf->Ln();

	$pdf->SetFont($fontFamily, '', $fontSize);

	if ($params["BILLEN_COMMENT1"])
	{
		$pdf->Write(15, HTMLToTxt(preg_replace(
			array('#</div>\s*<div[^>]*>#i', '#</?div>#i'), array('<br>', '<br>'),
			CSalePdf::prepareToPdf($params["BILLEN_COMMENT1"])
		), '', array(), 0));
		$pdf->Ln();
		$pdf->Ln();
	}

	if ($params["BILLEN_COMMENT2"])
	{
		$pdf->Write(15, HTMLToTxt(preg_replace(
			array('#</div>\s*<div[^>]*>#i', '#</?div>#i'), array('<br>', '<br>'),
			CSalePdf::prepareToPdf($params["BILLEN_COMMENT2"])
		), '', array(), 0));
		$pdf->Ln();
		$pdf->Ln();
	}
}

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

if ($params['BILLEN_PATH_TO_STAMP'])
{
	$filePath = $pdf->GetImagePath($params['BILLEN_PATH_TO_STAMP']);
	if ($filePath != '' && !$blank && \Bitrix\Main\IO\File::isFileExists($filePath))
	{
		list($stampHeight, $stampWidth) = $pdf->GetImageSize($params['BILLEN_PATH_TO_STAMP']);

		if ($stampHeight && $stampWidth)
		{
			if ($stampHeight > 120 || $stampWidth > 120)
			{
				$ratio = 120 / max($stampHeight, $stampWidth);
				$stampHeight = $ratio * $stampHeight;
				$stampWidth  = $ratio * $stampWidth;
			}

			$pdf->Image(
				$params['BILLEN_PATH_TO_STAMP'],
				$margin['left']+$width/2+45, $pdf->GetY(),
				$stampWidth, $stampHeight
			);
		}
	}
}

$y0 = $pdf->GetY();

$bankAccNo = $params["SELLER_COMPANY_BANK_ACCOUNT"];
$bankRouteNo = $params["SELLER_COMPANY_BANK_ACCOUNT_CORR"];
$bankSwift = $params["SELLER_COMPANY_BANK_SWIFT"];

if ($bankAccNo && $bankRouteNo && $bankSwift)
{
	$pdf->SetFont($fontFamily, 'B', $fontSize);

	$pdf->Write(15, CSalePdf::prepareToPdf("Bank Details"));
	$pdf->Ln();

	$pdf->SetFont($fontFamily, '', $fontSize);

	$bankDetails = '';

	if ($params["SELLER_COMPANY_NAME"])
	{
		$bankDetails .= CSalePdf::prepareToPdf(sprintf(
			"Account Name: %s\n",
			$params["SELLER_COMPANY_NAME"]
		));
	}

	$bankDetails .= CSalePdf::prepareToPdf(sprintf("Account #: %s\n", $bankAccNo));

	$bank = $params["SELLER_COMPANY_BANK_NAME"];
	$bankAddr = $params["SELLER_COMPANY_BANK_ADDR"];
	$bankPhone = $params["SELLER_COMPANY_BANK_PHONE"];

	if ($bank || $bankAddr || $bankPhone)
	{
		$bankDetails .= CSalePdf::prepareToPdf("Bank Name and Address: ");
		if ($bank)
			$bankDetails .= CSalePdf::prepareToPdf($bank);
		$bankDetails .= CSalePdf::prepareToPdf("\n");

		if ($bankAddr)
			$bankDetails .= CSalePdf::prepareToPdf(sprintf("%s\n", $bankAddr));

		if ($bankPhone)
		{
			$bankDetails .= CSalePdf::prepareToPdf(sprintf("%s\n", $bankPhone));
		}
	}

	$bankDetails .= CSalePdf::prepareToPdf(sprintf("Bank's routing number: %s\n", $bankRouteNo));
	$bankDetails .= CSalePdf::prepareToPdf(sprintf("Bank SWIFT: %s\n", $bankSwift));

	$pdf->MultiCell($width/2, 15, $bankDetails, 0, 'L');
}

$pdf->SetY($y0 + 15);
if ($params["SELLER_COMPANY_DIRECTOR_POSITION"])
{
	if ($params["SELLER_COMPANY_DIRECTOR_NAME"] || $params["SELLER_COMPANY_DIR_SIGN"])
	{
		$isDirSign = false;
		if (!$blank && $params['SELLER_COMPANY_DIR_SIGN'])
		{
			list($signHeight, $signWidth) = $pdf->GetImageSize($params['SELLER_COMPANY_DIR_SIGN']);

			if ($signHeight && $signWidth)
			{
				$ratio = min(37.5/$signHeight, 150/$signWidth);
				$signHeight = $ratio * $signHeight;
				$signWidth  = $ratio * $signWidth;

				$isDirSign = true;
			}
		}

		if ($params["SELLER_COMPANY_DIRECTOR_NAME"])
		{
			$pdf->SetX($pdf->GetX() + $width/2 + 15);
			$pdf->Write(15, CSalePdf::prepareToPdf($params["SELLER_COMPANY_DIRECTOR_NAME"]));
			$pdf->Ln();
			$pdf->Ln();
		}

		$pdf->SetX($pdf->GetX() + $width/2 + 15);
		$pdf->Write(15, CSalePdf::prepareToPdf($params["SELLER_COMPANY_DIRECTOR_POSITION"]));

		$pdf->Cell(0, 15, '', 'B');

		if ($isDirSign)
		{
			$pdf->Image(
				$params['SELLER_COMPANY_DIR_SIGN'],
				$pdf->GetX() - 150, $pdf->GetY() - $signHeight + 15,
				$signWidth, $signHeight
			);
		}

		$pdf->Ln();
		$pdf->Ln();
	}
}

if ($params["SELLER_COMPANY_ACCOUNTANT_POSITION"])
{
	if ($params["SELLER_COMPANY_ACCOUNTANT_NAME"] || $params["SELLER_COMPANY_ACC_SIGN"])
	{
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

		if ($params["SELLER_COMPANY_ACCOUNTANT_NAME"])
		{
			$pdf->SetX($pdf->GetX() + $width/2 + 15);
			$pdf->Write(15, CSalePdf::prepareToPdf($params["SELLER_COMPANY_ACCOUNTANT_NAME"]));
			$pdf->Ln();
			$pdf->Ln();
		}

		$pdf->SetX($pdf->GetX() + $width/2 + 15);
		$pdf->Write(15, CSalePdf::prepareToPdf($params["SELLER_COMPANY_ACCOUNTANT_POSITION"]));

		$pdf->Cell(0, 15, '', 'B');

		if ($isAccSign)
		{
			$pdf->Image(
				$params['SELLER_COMPANY_ACC_SIGN'],
				$pdf->GetX() - 150, $pdf->GetY() - $signHeight + 15,
				$signWidth, $signHeight
			);
		}

		$pdf->Ln();
	}
}

$dest = 'I';
if ($_REQUEST['GET_CONTENT'] == 'Y')
	$dest = 'S';
else if ($_REQUEST['DOWNLOAD'] == 'Y')
	$dest = 'D';

return $pdf->Output(
	sprintf(
		'Invoice # %s (Issue Date %s).pdf',
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