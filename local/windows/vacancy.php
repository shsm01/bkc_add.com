<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if (CModule::IncludeModule("iblock")):
 if ($_REQUEST['name']):
foreach($_REQUEST as $k=>$v)
$_REQUEST[$k]=strip_tags($v);

$vac=GetIBlockElement($_REQUEST['vac']);

	$el = new CIBlockElement;
	$PROP = array();
	$state='';
	$PROP["tel"] = $_REQUEST['phone'];
	$PROP["email"] = $_REQUEST['email'];
	$PROP["male"] = $_REQUEST['male'];
	$PROP["age"] = $_REQUEST['age'];
	$PROP["citizen"] = $_REQUEST['citizen'];
	$PROP["address"] = $_REQUEST['address'];
	$PROP["family"] = $_REQUEST['family'];
	$PROP["children"] = $_REQUEST['children'];
	$PROP["education"] = $_REQUEST['education'];
	$PROP["experience"] = $_REQUEST['experience'];
	$PROP["languages"] = $_REQUEST['languages'];
	$PROP["hobbies"] = $_REQUEST['hobbies'];
	$PROP["add"] = $_REQUEST['add'];
	$PROP["vac"] = $vac['ID'];

	$arLoadProductArray = Array(
		"IBLOCK_SECTION_ID"	=> false,
		"IBLOCK_ID"				=> 32,
		"ACTIVE_FROM"			=> ConvertTimeStamp(time(),"FULL"),
		"NAME"						=> $_REQUEST['name'],
		"PROPERTY_VALUES"	=> $PROP,
		"PREVIEW_TEXT"			=> '',
		"DETAIL_TEXT"			=> '',
		"ACTIVE"					=> "Y",
	);
      
    
	if($PRODUCT_ID = $el->Add($arLoadProductArray)){
		print('
<div class="window-success">
    <h1>Спасибо!</h1>
    <p>Ваша заявка принята.<br />Мы с Вами свяжемся в ближайшее время.</p>
    <a href="#" class="btn">закрыть</a>
</div>
');
		$files=false;
		CEvent::SendImmediate(
            55, //почтовое событие 
            "s1", //EMAIL 
            array(

				"NAME"=>$_REQUEST['name'],
				"PHONE"=> $_REQUEST['phone'],
				"EMAIL"=>$_REQUEST['email'],
				"MALE"=>$_REQUEST['male'],
				"AGE"=>$_REQUEST['age'],
				"CITIZEN"=>$_REQUEST['citizen'],
				"FAMILY"=>$_REQUEST['family'],
				"CHILDREN"=>$_REQUEST['children'],
				"EDUCATION"=>$_REQUEST['education'],
				"EXPERIENCE"=>$_REQUEST['experience'],
				"LANGUAGES"=>$_REQUEST['languages'],
				"HOBBIES"=>$_REQUEST['hobbies'],
				"ADD"=>$_REQUEST['add'],
				"VAC"=>$vac['NAME'],

            ), //параметры
            "N", //продублировать всем исходящим 
            30, //шаблон
			$files
        ); 
	};

 else:
$vac=GetIBlockElement($_REQUEST['id']);
?>
<div class="window-order">
    <div class="order">
        <h2>Резюме</h2>
        <div class="order-text">Отклик на вакансию <?=$vac['NAME']?>.</div>
        <form action="/local/windows/vacancy.php" method="post" onsubmit="alert('Спасибо за ваше резюме, мы свяжемся с вами в ближайшее время');return false;">
<input type="hidden" name="vac" value="<?=$vac['ID']?>">
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
                <div class="form-label">Ваша электронная почта</div>
                <div class="form-field">
                    <div class="form-input"><input type="text" name="email" value="" class="email" /></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Пол</div>
                <div class="form-field">
                    <div class="form-select"><select name="male">
						<option value="Не выбрано" selected>Не выбрано
						<option value="Мужской">Мужской
						<option value="Женский">Женский
                    </select></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Возраст</div>
                <div class="form-field">
                    <div class="form-input"><input type="text" name="age" value="" class="" /></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Гражданство</div>
                <div class="form-field">
                    <div class="form-input"><input type="text" name="citizen" value="" class="" /></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Место проживания</div>
                <div class="form-field">
                    <div class="form-input"><input type="text" name="address" value="" class="" /></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Семейное положение</div>
                <div class="form-field">
                    <div class="form-input"><input type="text" name="family" value="" class="" /></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Дети</div>
                <div class="form-field">
                    <div class="form-input"><input type="text" name="children" value="" class="" /></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Образование</div>
                <div class="form-field">
                    <div class="form-input"><textarea name="education" value="" class="" /></textarea></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Опыт работы</div>
                <div class="form-field">
                    <div class="form-input"><textarea name="experience" value="" class="" /></textarea></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Иностранные языки</div>
                <div class="form-field">
                    <div class="form-input"><textarea name="languages" value="" class="" /></textarea></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Увлечения</div>
                <div class="form-field">
                    <div class="form-input"><textarea name="hobbies" value="" class="" /></textarea></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Дополнительная информация</div>
                <div class="form-field">
                    <div class="form-input"><textarea name="add" value="" class="" /></textarea></div>
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