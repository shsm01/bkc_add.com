<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if (CModule::IncludeModule("iblock")):
 if ($_REQUEST['name']):
foreach($_REQUEST as $k=>$v)
$_REQUEST[$k]=strip_tags($v);
$group=GetIBlockElement($_REQUEST['group']);
$course=-1;
if ($group['PROPERTIES']['course']['VALUE'])$course=$group['PROPERTIES']['course']['VALUE'];
if ($group['PROPERTIES']['course2']['VALUE'])$course=$group['PROPERTIES']['course2']['VALUE'];
if ($group['PROPERTIES']['course3']['VALUE'])$course=$group['PROPERTIES']['course3']['VALUE'];
if ($group['PROPERTIES']['course4']['VALUE'])$course=$group['PROPERTIES']['course4']['VALUE'];
if ($group['PROPERTIES']['course5']['VALUE'])$course=$group['PROPERTIES']['course5']['VALUE'];
if ($group['PROPERTIES']['course6']['VALUE'])$course=$group['PROPERTIES']['course6']['VALUE'];

$course=GetIBlockElement($course);
$lvl=GetIBlockElement($group['PROPERTIES']['level']['VALUE']);
$school=GetIBlockElement($group['PROPERTIES']['school']['VALUE']);
$lang_res=CIBlockSection::GetList(array('SORT'=>'ASC'),Array('IBLOCK_ID'=>$course['IBLOCK_ID'],'ID'=>$course['IBLOCK_SECTION_ID']));
$lang=$lang_res->GetNext();
while($lang['DEPTH_LEVEL']>1)
{
	$lang_res=CIBlockSection::GetList(array('SORT'=>'ASC'),Array('IBLOCK_ID'=>$course['IBLOCK_ID'],'ID'=>$lang['IBLOCK_SECTION_ID']));
	$lang=$lang_res->GetNext();

}
	$el = new CIBlockElement;
	$PROP = array();
	$state='';
	$PROP["tel"] = $_REQUEST['phone'];
	$PROP["email"] = $_REQUEST['email'];
	$PROP["lang"] = $lang['NAME'];
	$PROP["course"] = $course['NAME'];
	$PROP["group"] = $group['NAME'];
	$PROP["type"] = $course['IBLOCK_NAME'];
	$PROP['level']=$lvl['NAME'];
	$PROP['school']=$school['NAME'];
	$arLoadProductArray = Array(
		"IBLOCK_SECTION_ID"	=> false,
		"IBLOCK_ID"				=> 44,
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
    <p>Ваша заявка принята. <br>Мы с Вами свяжемся в ближайшее время.</p>
    <a href="#" class="btn">закрыть</a>
</div>		
');
		$files=false;
		CEvent::SendImmediate(
            55, //почтовое событие 
            "s1", //EMAIL 
            array(
				"FIO"=>$_REQUEST['name'],
				"PHONE"=> $_REQUEST['phone'],
				"EMAIL"=>$_REQUEST['email'],
				"LANG"=> $lang['NAME'],
				"GROUP"=> $group['NAME'],
				"LEVEL" => $lvl['NAME'],
				"COURSE" => $course['NAME'],
				"TYPE" => $course['IBLOCK_NAME'],
				"SCHOOL" => $school['NAME'],

            ), //параметры
            "N", //продублировать всем исходящим 
            32, //шаблон
			$files
        ); 
	};
else:?>
<?
//print_r($_REQUEST);
$group=GetIBlockElement($_REQUEST['id']);
?>
		<div class="window-order">
    <div class="order course-order">
        <h2>Заказать курс</h2>
        <div class="order-text">Оставьте заявку, и наши специалисты свяжутся с вами в ближайшее время</div>
        <form action="/local/windows/order_group.php" method="post">
		<input type="hidden" name="group" value="<?=$group['ID']?>">
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

            <div class="form-submit"><input type="submit" value="Подать заявку" /></div>
        </form>
    </div>
</div>
<?
 endif;

endif;				
?>