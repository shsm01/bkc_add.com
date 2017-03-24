<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
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
/** @var \Bitrix\Disk\Internals\BaseComponent $component */
$this->IncludeLangFile("edit.php");
CJSCore::Init(array("core", "uploader"));

$m = GetMessage("MPF_ERROR1");
$thumb = <<<HTML
<div class="mobile-grid-field-file-item-inner">
	<i class="mobile-grid-wait"></i>
	<del></del>
	<span class="mobile-grid-field-file-preview">
		<span class="files-preview-border"><span class="files-preview-alignment">
			#preview#
		</span></span>
	</span>
	<span class="mobile-grid-field-file-icon icon icon-#ext#"></span>
	<span class="mobile-grid-field-file-name">#name#</span>
	<span class="mobile-grid-field-file-size">#size#</span>
	<span class="mobile-grid-field-file-error-text">$m</span>
</div>
HTML;

$uploadedFile = <<<HTML
<div class="mobile-grid-field-file-item mobile-grid-field-file-#class#" id="diskuf-#id#">
	<div class="mobile-grid-field-file-item-inner">
		<del></del>
		<span class="mobile-grid-field-file-preview">
			<span class="files-preview-border"><span class="files-preview-alignment">
				<img class="files-preview" src="#preview_url#" />
			</span></span>
		</span>
		<span class="mobile-grid-field-file-icon icon icon-#ext#"></span>
		<span class="mobile-grid-field-file-name">#name#</span>
		<span class="mobile-grid-field-file-size">#size#</span>
		<input type="hidden" name="#control_name#" value="#id#" />
	</div>
</div>
HTML;
$thumb = preg_replace("/[\n\t]+/", "", $thumb);
$uploadedFile =  preg_replace("/[\n\t]+/", "", $uploadedFile);

?><div id="diskuf-placeholder-<?=$arResult['UID']?>"><?
foreach ($arResult['FILES'] as $file)
{
	if (array_key_exists("IMAGE", $file))
	{
		CFile::ScaleImage(
			$file["IMAGE"]["WIDTH"],
			$file["IMAGE"]["HEIGHT"],
			\Bitrix\Disk\Uf\Controller::$previewParams,
			BX_RESIZE_IMAGE_PROPORTIONAL,
			$bNeedCreatePicture,
			$arSourceSize,
			$arDestinationSize
		);
		$file["width"] = $arDestinationSize["width"];
		$file["height"] = $arDestinationSize["height"];
	}
	$f = $uploadedFile;
	$pat = array("#uid#", "#control_name#", "#class#");
	$rep = array($arResult['UID'], $arResult['controlName'], (array_key_exists("IMAGE", $file) ? "image" : "file"));
	foreach ($file as $k => $v)
	{
		if($k == 'EXTENSION')
			$k = 'ext';
		$pat[] = "#".strtolower($k)."#"; $rep[] = $v;
	}
	?><?=str_ireplace($pat, $rep, $f);
}
?>
	</div>
	<a class="mobile-grid-button file" href="#" id="diskuf-eventnode-<?=$arResult['UID']?>"><?=GetMessage("MPF_ADD")?></a>
<script type="text/javascript">
BX.ready(function(){
	BX.Disk.UFMobile.add({
		UID : '<?=$arResult['UID']?>',
		controlName : '<?= CUtil::JSEscape($arResult['controlName'])?>'
	});
});
BX.message({
	MPF_PHOTO_DISK : '<?=GetMessageJS("MPF_PHOTO_DISK")?>',
	MPF_INCORRECT_RESPONSE : '<?=GetMessageJS("MPF_INCORRECT_RESPONSE")?>',
	DISK_NODE : '<?=CUtil::JSEscape($thumb)?>'
});
</script>