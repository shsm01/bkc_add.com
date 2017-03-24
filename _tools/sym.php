<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

define("NEED_AUTH", true);
global $USER;
if (!$USER->IsAdmin()) LocalRedirect("/");

set_time_limit(600);
$IBLOCK_TYPE = 'school';


# функция для замены символа "_" на "-"
function repSymCode($code){
	if(strripos($code, '_')!==false){
		$code = str_replace('_','-',$code);
		if(substr($code, -1) == '-')
			$code = substr($code,0,(strlen($code) - 1));
	return $code;
	} else return false;
}

# кнопка старт
if (isset($_REQUEST['start']) && CModule::IncludeModule("iblock")){

#------------------------------
# Обновление кодов секций
#------------------------------
$sectionRes = CIBlockSection::GetList(
		array("SORT"=>"ASC"),
array(),//		array('IBLOCK_TYPE' => $IBLOCK_TYPE),
		false,
		array('CODE','ID','NAME'),
		false
);
$siCnt=0;
$secObj = new CIBlockSection;
while($arSection = $sectionRes->GetNext()){
	$code = repSymCode($arSection['CODE']);
	if ($code != false){
		$siCnt++;
		$secObj->Update($arSection['ID'], array('CODE' => $code));
	}
//	print($arSection['NAME'].'='.$arSection['CODE'].'='.$code.'<br>');
}
$arResult['MSG'][] = 'Обновлено разделов: '.$siCnt;
#-------------------------------


#-----------------------------
#	Обновление кодов элементов
#-----------------------------
$elemRes = CIBlockElement::GetList(
	array("SORT"=>"ASC"),
array(),//	array('IBLOCK_TYPE' => $IBLOCK_TYPE),
	false,
	false,
	array('ID','CODE')
);

$elObj = new CIBlockElement;
$eiCnt = 0;
while($arElemObj = $elemRes->GetNextElement()){
	$arElemFields = $arElemObj->GetFields();
	$code = repSymCode($arElemFields['CODE']);
	if ($code != false){
		$elObj->Update($arElemFields['ID'], array('CODE' => $code));
		$eiCnt++;
	}
}
$arResult['MSG'][] = 'Обновлено элементов: '.$siCnt;
#----------------------------------------------------

} # end if
?>

<h2>Замена символов в символьных кодах</h2>
<?if (count($arResult['MSG'])>0){
	foreach($arResult['MSG'] as $msgValue){?><p><?=$msgValue?></p><?}
}?>
<form method="post"><input type="submit" name="start" value="Старт"></form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>