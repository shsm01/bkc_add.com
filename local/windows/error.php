<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if (CModule::IncludeModule("iblock")):
 if ($_REQUEST['name']):
foreach($_REQUEST as $k=>$v)
$_REQUEST[$k]=strip_tags($v);
	$el = new CIBlockElement;
	$PROP = array();
	$state='';
	$PROP["email"] = $_REQUEST['email'];
	$PROP["page"] = $_REQUEST['page'];


	$arLoadProductArray = Array(
		"IBLOCK_SECTION_ID"	=> false,
		"IBLOCK_ID"				=> 46,
		"ACTIVE_FROM"			=> ConvertTimeStamp(time(),"FULL"),
		"NAME"						=> $_REQUEST['name'],
		"PROPERTY_VALUES"	=> $PROP,
		"PREVIEW_TEXT"			=> $_REQUEST['message'],
		"DETAIL_TEXT"			=> '',
		"ACTIVE"					=> "Y",
	);
      
    
	if($PRODUCT_ID = $el->Add($arLoadProductArray)){
		print('<div class="window-success">
    <h1>Спасибо!</h1>
    <p>Ваше обращение принято!</p>
    <a href="#" class="btn">закрыть</a>
</div>');
		$files=false;
		CEvent::SendImmediate(
            55, //почтовое событие 
            "s1", //EMAIL 
            array(
				"FIO"=>$_REQUEST['name'],
				"EMAIL"=>$_REQUEST['email'],
				"PAGE"=> $_REQUEST['page'],
				"MESS"=>$_REQUEST['message'],
            ), //параметры
            "N", //продублировать всем исходящим 
            34, //шаблон
			$files
        ); 
	};
else:?>
		<div class="window-order">
    <div class="order">
        <h2>Пожелание по работе новой версии сайта</h2>
		<br />
        <form action="/local/windows/error.php" method="post">
		<input type="hidden" name="page" value="<?=$_SERVER['HTTP_REFERER']?>">
            <div class="form-row">
                <div class="form-label">Ваше ФИО <span>*</span></div>
                <div class="form-field">
                    <div class="form-input"><input type="text" name="name" value="" class="required" /></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Ваш email</div>
                <div class="form-field">
                    <div class="form-input"><input type="text" name="email" value="" class="email" /></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Комментарий<br /><span style='font-size: 12px; font-weight: 300'>(Ошибка/Пожелание)</span></div>
                <div class="form-field">
                    <div class="form-input">
					<textarea name="message" rows="5" cols="20"></textarea>
                    </div>
                </div>
            </div>

            <div class="form-submit"><input type="submit" value="Отправить" /></div>
        </form>
    </div>
</div>
<?
 endif;

endif;				
?>