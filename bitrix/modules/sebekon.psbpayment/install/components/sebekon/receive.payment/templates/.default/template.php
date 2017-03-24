<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>

<?if(empty($arResult['ORDER_ID'])) {
	return;
}?>

<h1 class="head"><?=GetMessage('PAY_ORDER_TITLE', array('#ORDER_ID#' => $arResult['ORDER_ID']))?></h1>


	<p><h3><?=(count($arResult['ERRORS'])==0 ? GetMessage('PAYMENT_SUCCESS') : GetMessage('PAYMENT_ERROR'))?></h3></p>
	
	<b><?=GetMessage('ORDER_DETAILS')?></b><br>
	<li><?=GetMessage('ORDER_NUMBER', array('#ORDER_ID#' => $arResult['ORDER_ID']))?></li>			
	<li><?=GetMessage('ORDER_STATUS', array('#STATUS#' => $arResult['STATUS']['VALUE']))?></li>			
	<li><?=GetMessage('ORDER_AMOUNT', array('#AMOUNT#' => number_format($arResult['DATA']['AMOUNT'],2,',',' ')))?></li>
<?if(count($arResult['ERRORS'])):?>
	<p style="color: red;"><?=GetMessage('REQUEST_REJECTED')?><br/>
	<?
	foreach($arResult['ERRORS'] as $e) {
		echo $e."<br/>";
	}
	?>
	</p>
	<?//echo "<p>Попробуйте оплатить его еще раз перейдя по ссылке <a href=\"/personal/order/payment/?ORDER_ID={$arResult['ORDER_ID']}\">Оплатить заказ</a> или свяжитесь с нашим оператором.</p>";*/?>
<?endif;?>


