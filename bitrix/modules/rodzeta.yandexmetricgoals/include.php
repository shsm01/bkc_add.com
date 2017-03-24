<?php
/***********************************************************************************************
 * rodzeta.yandexmetricgoals - Yandex Metrika targets assignements
 * Copyright 2016 Semenov Roman
 * MIT License
 ************************************************************************************************/

defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;
use Bitrix\Main\Config\Option;

EventManager::getInstance()->addEventHandler("main", "OnEpilog", function () {
	if (CSite::InDir("/bitrix/")) {
		return;
	}

	global $APPLICATION;
	$APPLICATION->AddHeadString(Option::get("rodzeta.yandexmetricgoals", "yandex_metrika_code"), true);
	$APPLICATION->AddHeadString(Option::get("rodzeta.yandexmetricgoals", "google_analytics_code"), true);

	if (is_readable($_SERVER["DOCUMENT_ROOT"] . \Rodzeta\Yandexmetricgoals\Utils::CACHE_NAME)) {
		$APPLICATION->AddHeadScript(\Rodzeta\Yandexmetricgoals\Utils::CACHE_NAME);
	}
});
