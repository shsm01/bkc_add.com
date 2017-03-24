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
?>
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<p><img
			src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
			width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
			height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
			alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
			title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
			/></p>
	<?endif?>
	<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
		<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
	<?endif;?>
	<?if(strlen($arResult["DETAIL_TEXT"])>0):?>
		<?echo $arResult["DETAIL_TEXT"];?>
	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
						<div class="detail">
                            <div class="detail-inner">
<?	foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

                                <div class="detail-row">
                                    <div class="detail-row-name"><?=$arProperty["NAME"]?></div>
                                    <div class="detail-row-value">
		<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
			<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
		<?else:?>
			<?=$arProperty["DISPLAY_VALUE"];?>
		<?endif?>
									</div>
								</div>
	<?endforeach;?>
                            </div>
                        </div>
<?
	if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
	{
		?>
                        <p>
                            <span id="ya_share_counter"></span>
                            <script src="http://yandex.st/share/share.js"></script>
                            <script>
                                var yaShareCounter = new Ya.share({
                                    'element': 'ya_share_counter',
                                    'theme': 'counter',
                                    'elementStyle': {'quickServices': ['vkontakte', 'facebook', 'twitter'], 'type': 'small'}
                                 });
                            </script>
                        </p>
		<?
	}
	?>