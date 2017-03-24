<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (CModule::IncludeModule("iblock")):

$_REQUEST['phone']=strip_tags($_REQUEST['phone']);

	$el = new CIBlockElement;
	$PROP = array();
	$PROP["tel"] = $_REQUEST['phone'];
	$PROP["email"] = $_REQUEST['email'];
	$PROP["post"] = $_REQUEST['post'];
	$PROP["company"] = $_REQUEST['company'];
	$PROP["language"] = $_REQUEST['language'];

	$arLoadProductArray = Array(
		"IBLOCK_SECTION_ID"	=> false,
		"IBLOCK_ID"				=> 48,
		"ACTIVE_FROM"			=> ConvertTimeStamp(time(),"FULL"),
		"NAME"						=> $_REQUEST['name'],
		"PROPERTY_VALUES"	=> $PROP,
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
				"EMAIL"=> $_REQUEST['email'],
				"POST"=> $_REQUEST['post'],
				"COMP"=> $_REQUEST['company'],
				"LANG"=> $_REQUEST['language'],
				"FIO"=> $_REQUEST['name'],
            ), //параметры
            "N", //продублировать всем исходящим 
            36, //шаблон
			$files
        ); 
        
		print('
	<div class="window-success">
    <h1>Спасибо!</h1>
    <p>Ваша заявка принята. <br>Наши специалисты свяжутся с вами в ближайшее время!</p>
    <a href="#" class="btn" onclick="$('."'".'.order-corporate'."'".').html('."'".''."'".');">закрыть</a>
</div>	
		');
		}
    else
		{	
        print("Ошибка: ".$el->LAST_ERROR);
		}
endif;
?>