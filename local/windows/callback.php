<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (CModule::IncludeModule("iblock")):

$_REQUEST['phone']=strip_tags($_REQUEST['phone']);

	$el = new CIBlockElement;
	$arLoadProductArray = Array(
		"IBLOCK_SECTION_ID"	=> false,
		"IBLOCK_ID"				=> 31,
		"ACTIVE_FROM"			=> ConvertTimeStamp(time(),"FULL"),
		"NAME"						=> $_REQUEST['phone'],
		"ACTIVE"					=> "Y",
	);

    //can add without authorization
    $ID = $el->Add($arLoadProductArray);
    if($ID>0)
		{
		$files=false;
		CEvent::SendImmediate(
            55, //почтовое событие 
            "s1", //EMAIL 
            array(
				"PHONE"=> $_REQUEST['phone'],
            ), //параметры
            "N", //продублировать всем исходящим 
            29, //шаблон
			$files
        ); 
        
		print('Данные отправлены. Ждите в ближайшее время звонка!');
		}
    else
		{	
        print("Ошибка: ".$el->LAST_ERROR);
		}
endif;
?>

<div class="window">
	<div class="window-overlay" style="width: 100%; height: 100%;">
	</div>
	<div class="window-container" style="left: 50%; margin-left: -337px; top: 50%; margin-top: -165.5px;">
		<div class="window-content">
			<div class="window-success">
    				<h1>Спасибо!</h1>
    				<p>
				Ваша заявка принята.
				<br>
				Мы с Вами свяжемся в ближайшее время.
				</p>
    				<a href="#" class="btn">закрыть</a>
			</div>
		</div>
	</div>
	<a href="#" class="window-close">Закрыть</a>
</div>
