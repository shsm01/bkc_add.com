<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

// var_dump($arResult);
// $arResult['NAME'] ="Отзывы о ".Delta;
$arResult['NAME'] ="";
// echo $arResult["ITEMS"][0]['IBLOCK_SECTION_ID'];
// $sec=GetIBlockSection($arResult["ITEMS"][0]['IBLOCK_SECTION_ID']);
// $arResult['NAME'] ="Отзывы о ".strtoupper($sec['NAME']);
// var_dump($sec);
// print($sec['DESCRIPTION']);

?>

<!-- <p> D:\Ampps\www\bkc-add.com\local\templates\.default\components\bitrix\news.list\reviews\template.php  Мы тут !</p> -->


<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
<?
if (is_array($arItem["DETAIL_PICTURE"])){
  if ($arItem["DETAIL_PICTURE"]["WIDTH"]>70 && $arItem["DETAIL_PICTURE"]["HEIGHT"]>70){
  	$w=70;
  	$h=70;
  }elseif($arItem["DETAIL_PICTURE"]["WIDTH"]<=70){
  	$w=$arItem["DETAIL_PICTURE"]["WIDTH"];
  	$h=$arItem["DETAIL_PICTURE"]["WIDTH"];
  }else{
  	$w=$arItem["DETAIL_PICTURE"]["HEIGHT"];
  	$h=$arItem["DETAIL_PICTURE"]["HEIGHT"];
  }
  
  if($arItem["DETAIL_PICTURE"]["WIDTH"]<=70 && $arItem["DETAIL_PICTURE"]["WIDTH"]<$w){
  	$w=$arItem["DETAIL_PICTURE"]["WIDTH"];
  	$h=$arItem["DETAIL_PICTURE"]["WIDTH"];
  }
  if($arItem["DETAIL_PICTURE"]["HEIGHT"]<=70 && $arItem["DETAIL_PICTURE"]["HEIGHT"]<$h){
  	$w=$arItem["DETAIL_PICTURE"]["HEIGHT"];
  	$h=$arItem["DETAIL_PICTURE"]["HEIGHT"];
  }
  
  
  	$arItem["DETAIL_PICTURE"]=CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array('width'=>$w, 'height'=>$h), BX_RESIZE_IMAGE_EXACT, true);
  	if (!$arItem["DETAIL_PICTURE"]['SRC'])
  	 $arItem["DETAIL_PICTURE"]['SRC']=$arItem["DETAIL_PICTURE"]['src'];
}else{
  $arItem["DETAIL_PICTURE"]["WIDTH"] = $arItem["DETAIL_PICTURE"]["HEIGHT"] = 70;
  $arItem["DETAIL_PICTURE"]['SRC'] = '/local/layout/images/response.png';
}
	?>

<!-- response -->
                        <div class="response" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                            <div class="response-text">
                                <div class="response-text-wrap">
								<?if($arParams["DISPLAY_DETAIL_TEXT"]!="N" && $arItem["DETAIL_TEXT"]):?>
                                    <div class="response-text-inner"><?echo $arItem["DETAIL_TEXT"];?></div>
								<?endif;?>
                                </div>
                                <div class="response-text-more"><a href="#" data-alttext="Свернуть">Подробнее</a></div>
                            </div>
                            <div class="response-author">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["DETAIL_PICTURE"])):?>
				<div class="response-author-photo"><img
						src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>"
						width="<?=$arItem["DETAIL_PICTURE"]["WIDTH"]?>"
						height="<?=$arItem["DETAIL_PICTURE"]["HEIGHT"]?>"
						alt="<?=$arItem["DETAIL_PICTURE"]["ALT"]?>"
						title="<?=$arItem["DETAIL_PICTURE"]["TITLE"]?>"
						/></div>
		<?endif?>

                                <div class="response-author-text">
                                    <div class="response-author-name"><?echo $arItem["NAME"]?> <!--div class="info"><a href="#" class="info-icon">i</a></div--></div>
                                    <div class="response-author-info">
									<?if ($arItem["PROPERTIES"]['state']['VALUE']):?>	<?=$arItem["PROPERTIES"]['state']['VALUE']?>,<?endif?> 
									<?if ($arItem["PROPERTIES"]['course']['VALUE']):?>	<?=$arItem["PROPERTIES"]['course']['VALUE']?>,<br /><?endif;?>
									<?if ($arItem["PROPERTIES"]['country']['VALUE']):?>	<?=$arItem["PROPERTIES"]['country']['VALUE']?><?endif;?>
									<?if($arItem["PROPERTIES"]['now']['VALUE']):?>, <?=$arItem["PROPERTIES"]['now']['VALUE']?><?endif;?></div>
                                    <div class="response-author-social">
                                        <?if($arItem["PROPERTIES"]['vk']['VALUE']):?>
										<a href="<?=$arItem["PROPERTIES"]['vk']['VALUE']?>" class="response-author-social-1"></a>
										<?endif;?>
                                        <?if($arItem["PROPERTIES"]['fb']['VALUE']):?>
                                        <a href="<?=$arItem["PROPERTIES"]['fb']['VALUE']?>" class="response-author-social-2"></a>
										<?endif;?>
                                        <?if($arItem["PROPERTIES"]['ln']['VALUE']):?>
                                        <a href="<?=$arItem["PROPERTIES"]['ln']['VALUE']?>" class="response-author-social-3"></a>
										<?endif;?>
                                        <?if($arItem["PROPERTIES"]['ok']['VALUE']):?>
                                        <a href="<?=$arItem["PROPERTIES"]['ok']['VALUE']?>" class="response-author-social-4"></a>
										<?endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- response END -->



	
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
