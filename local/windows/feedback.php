<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if (CModule::IncludeModule("iblock")):
 if ($_REQUEST['name']):
foreach($_REQUEST as $k=>$v)
$_REQUEST[$k]=strip_tags($v);
$sch=GetIBlockElement($_REQUEST['school']);
	$el = new CIBlockElement;
	$PROP = array();
	$state='';
	$PROP["tel"] = $_REQUEST['phone'];
	$PROP["email"] = $_REQUEST['email'];
	$PROP["school_name"] = $sch['NAME'];
	$PROP["school"] = $_REQUEST['school'];


	$arLoadProductArray = Array(
		"IBLOCK_SECTION_ID"	=> false,
		"IBLOCK_ID"				=> 45,
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
    <p>Ваша заявка принята. <br>Мы с Вами свяжемся в ближайшее время.</p>
    <a href="#" class="btn">закрыть</a>
</div>');
		$files=false;
		CEvent::SendImmediate(
            55, //почтовое событие 
            "s1", //EMAIL 
            array(
				"FIO"=>$_REQUEST['name'],
				"PHONE"=> $_REQUEST['phone'],
				"EMAIL"=>$_REQUEST['email'],
				"SCHOOL"=> $sch['NAME'],
				"MESS"=>$_REQUEST['message'],
            ), //параметры
            "N", //продублировать всем исходящим 
            33, //шаблон
			$files
        ); 
	};
else:?>
<?
$sch=GetIBlockElement($_REQUEST['id']);
?>
		<div class="window-order">
    <div class="order">
        <h2>Обратная связь. Школа <?=$sch['NAME']?></h2>
        <div class="order-text"></div>
        <form action="/local/windows/feedback.php" method="post">
		<input type="hidden" name="school" value="<?=$sch['ID']?>">
            <div class="form-row">
                <div class="form-label">Ваше ФИО <span>*</span></div>
                <div class="form-field">
                    <div class="form-input"><input type="text" name="name" value="" class="required" /></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Ваш телефон <span>*</span></div>
                <div class="form-field">
                    <div class="form-input"><input type="text" name="phone" value="" class="required maskPhone" /></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Ваш email</div>
                <div class="form-field">
                    <div class="form-input"><input type="text" name="email" value="" class="email" /></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Сообщение</div>
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