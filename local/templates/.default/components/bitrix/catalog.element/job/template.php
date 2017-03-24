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
$templateLibrary = array('popup');
$currencyList = '';
if (!empty($arResult['NAME']))
{
$strMainID = $this->GetEditAreaId($arResult['ID']);
$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$p=$arResult['PROPERTIES'];
?>
                        <dl>
<?if ($p['zp']['VALUE']):?>
							<dt>Заработная плата</dt>
                            <dd><strong><?=str_replace('руб','<span class="rouble">i</span>',$p['zp']['VALUE'])?></strong></dd>
<?endif;?>
<?if ($p['metro']['VALUE']):?>
                            <dt>Метро</dt>
                            <dd><?=$p['metro']['VALUE']?></dd>
<?endif;?>
<?if ($p['work']['VALUE']):?>
                            <dt>Должность</dt>
                            <dd><?=$p['work']['VALUE']?></dd>
<?endif;?>
<?if ($p['graph']['VALUE']):?>
                            <dt>График работы</dt>
                            <dd><?=$p['graph']['VALUE']?></dd>
<?endif;?>

						</dl>
<a href="/local/windows/vacancy.php?id=<?=$arResult['ID']?>" class="btn window-link">Откликнуться</a>
<?if ($p['usl']['VALUE']):?>
                            <h3>Условия работы</h3>
						<ul>
						<li><?=$p['usl']['VALUE']['TEXT']?></li>
						</ul>
<?endif;?>
<?if (count($p['treb']['VALUE'])>0):?>
                        <h3>Требования</h3>
                        <ul>
<?foreach($p['treb']['VALUE'] as $v)print('<li>'.$v.'</li>');?>
                        </ul>
<?endif;?>
<?if (count($p['obyaz']['VALUE'])>0):?>
                        <h3>Обязанности</h3>
                        <ul>
<?foreach($p['obyaz']['VALUE'] as $v)print('<li>'.$v.'</li>');?>
                        </ul>
<?endif;?>
<?if (is_array($p['dop']['VALUE']) && count($p['dop']['VALUE'])>0):?>
                        <h3>Дополнительно</h3>
                        <ul>
<?foreach($p['dop']['VALUE'] as $v)print('<li>'.$v.'</li>');?>
                        </ul>
<?endif;?>
						
	<a href="/local/windows/vacancy.php?id=<?=$arResult['ID']?>" class="btn window-link">Откликнуться</a>
<?
}
?>