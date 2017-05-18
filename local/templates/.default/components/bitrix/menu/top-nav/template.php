<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul>
<?
$prev=0;

foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
if ($prev>$arItem["DEPTH_LEVEL"]){print('</li></ul>');}
if ($arItem['IS_PARENT']):
?>
<li class="with-submenu"><a href="<?=$arItem["LINK"]?>" class="top-nav__menu-item"><?=$arItem["TEXT"]?></a><ul>
	<?else:?>
<li><a href="<?=$arItem["LINK"]?>" class="top-nav__menu-item"><?=$arItem["TEXT"]?></a></li>
<?endif;?>
<?
$prev=$arItem["DEPTH_LEVEL"];
endforeach;
if ($prev>1)print('</li></ul>');
?>
</ul>
<?endif?>