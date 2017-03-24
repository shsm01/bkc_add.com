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
?>

<?
$frame = $this->createFrame("subscribe-form", false)->begin();
?>
<form action="/local/windows/subscr.php" method="post" onsubmit="$.ajax({type: 'POST',url: $(this).attr('action'),data: $(this).serialize(),dataType: 'html',		}).done(function(html) {windowOpen2(html);});return false;">

		<input type="checkbox" name="sf_RUB_ID[]" style="display:none;" id="sf_RUB_ID_1" value="1"<?echo " checked"?> />


							<div class="form-input"><input type="text" name="sf_EMAIL" value="<?=$arResult["EMAIL"]?>" title="<?=GetMessage("subscr_form_email_title")?>"  placeholder="Ваш адрес электронной почты" class="required" /></div>
                            <div class="form-submit"><input type="submit" name="OK" value="Ок" /></div>
	</form>
<?
$frame->beginStub();
?>
	<form action="<?=$arResult["FORM_ACTION"]?>" method="post">

		<input type="checkbox" name="sf_RUB_ID[]" style="display:none;" id="sf_RUB_ID_1" value="1"<?echo " checked"?> />

							<div class="form-input"><input type="text" name="sf_EMAIL" value="<?=$arResult["EMAIL"]?>" title="<?=GetMessage("subscr_form_email_title")?>"  placeholder="Ваш адрес электронной почты" class="required" /></div>
                            <div class="form-submit"><input type="submit" name="OK" value="Ок" /></div>
	</form>
<?
$frame->end();
?>
