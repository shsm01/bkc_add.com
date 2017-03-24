<?php
/***********************************************************************************************
 * rodzeta.yandexmetricgoals - Yandex Metrika targets assignements
 * Copyright 2016 Semenov Roman
 * MIT License
 ************************************************************************************************/

defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Text\String;
use Bitrix\Main\Loader;

if (!$USER->isAdmin()) {
	$APPLICATION->authForm("ACCESS DENIED");
}

$app = Application::getInstance();
$context = $app->getContext();
$request = $context->getRequest();

Loc::loadMessages(__FILE__);

$tabControl = new CAdminTabControl("tabControl", array(
  array(
		"DIV" => "edit1",
		"TAB" => Loc::getMessage("RODZETA_YANDEXMETRICGOALS_MAIN_TAB_SET"),
		"TITLE" => Loc::getMessage("RODZETA_YANDEXMETRICGOALS_MAIN_TAB_TITLE_SET"),
  ),
));

?>

<?= BeginNote() ?>
<p>
	<b>Как работает</b>
	<ul>
		<li>загрузите или создайте файл <b><a href="<?= \Rodzeta\Yandexmetricgoals\Utils::SRC_NAME ?>">rodzeta.yandexmetricgoals.csv</a></b> в папке /upload/ с помощью
			<a target="_blank" href="/bitrix/admin/fileman_file_edit.php?path=<?= urlencode(\Rodzeta\Yandexmetricgoals\Utils::SRC_NAME) ?>">стандартного файлового менеджера</a>;
		<li>после изменений в файле rodzeta.yandexmetricgoals.csv - нажмите в настройке модуля кнопку "Применить настройки";
	</ul>
</p>
<p>
	Для отключения отправки целей из csv-файла нажмите "Сбросить кеш целей".
</p>
<?= EndNote() ?>

<?php

if ($request->isPost() && check_bitrix_sessid()) {
	if (!empty($save) || !empty($restore)) {
		Option::set("rodzeta.yandexmetricgoals", "yandex_metrika_code", $request->getPost("yandex_metrika_code"));
		Option::set("rodzeta.yandexmetricgoals", "yandex_metrika_id", $request->getPost("yandex_metrika_id"));
		Option::set("rodzeta.yandexmetricgoals", "google_analytics_code", $request->getPost("google_analytics_code"));
		Option::set("rodzeta.yandexmetricgoals", "google_analytics_id", $request->getPost("google_analytics_id"));

		\Rodzeta\Yandexmetricgoals\Utils::createCache();

		CAdminMessage::showMessage(array(
	    "MESSAGE" => Loc::getMessage("RODZETA_YANDEXMETRICGOALS_OPTIONS_SAVED"),
	    "TYPE" => "OK",
	  ));
	}	else if ($request->getPost("clear") != "") {
		\Rodzeta\Yandexmetricgoals\Utils::clearCache();

		CAdminMessage::showMessage(array(
	    "MESSAGE" => Loc::getMessage("RODZETA_YANDEXMETRICGOALS_OPTIONS_RESETED"),
	    "TYPE" => "OK",
	  ));
	}
}

$tabControl->begin();

?>

<form method="post" action="<?= sprintf('%s?mid=%s&lang=%s', $request->getRequestedPage(), urlencode($mid), LANGUAGE_ID) ?> type="get">
	<?= bitrix_sessid_post() ?>

	<?php $tabControl->beginNextTab() ?>

	<tr class="heading">
		<td colspan="2">Настройки для Яндекс.Метрика</td>
	</tr>

	<tr>
		<td class="adm-detail-content-cell-l" width="50%">
			<label>ID счетчика Яндекс.Метрика</label>
		</td>
		<td class="adm-detail-content-cell-r" width="50%">
			<input type="text" size="30" name="yandex_metrika_id"
				value="<?= Option::get("rodzeta.yandexmetricgoals", "yandex_metrika_id") ?>" ?>
		</td>
	</tr>

	<tr>
		<td class="adm-detail-content-cell-l" width="50%">
			<label>Код счетчика</label>
		</td>
		<td class="adm-detail-content-cell-r" width="50%">
			<textarea name="yandex_metrika_code" rows="10" cols="60"
				><?= Option::get("rodzeta.yandexmetricgoals", "yandex_metrika_code") ?></textarea>
		</td>
	</tr>

	<tr class="heading">
		<td colspan="2">Настройки для Google Analytics</td>
	</tr>

	<tr>
		<td class="adm-detail-content-cell-l" width="50%">
			<label>Идентификатор отслеживания</label>
		</td>
		<td class="adm-detail-content-cell-r" width="50%">
			<input type="text" size="30" name="google_analytics_id"
				value="<?= Option::get("rodzeta.yandexmetricgoals", "google_analytics_id") ?>" ?>
		</td>
	</tr>

	<tr>
		<td class="adm-detail-content-cell-l" width="50%">
			<label>Код отслеживания</label>
		</td>
		<td class="adm-detail-content-cell-r" width="50%">
			<textarea name="google_analytics_code" rows="10" cols="60"
				><?= Option::get("rodzeta.yandexmetricgoals", "google_analytics_code") ?></textarea>
		</td>
	</tr>

	<?php
	 $tabControl->buttons();
  ?>

  <input class="adm-btn-save" type="submit" name="save" value="Применить настройки">
  <input type="submit" name="clear" value="Сбросить кеш целей">

</form>

<?php

$tabControl->end();
