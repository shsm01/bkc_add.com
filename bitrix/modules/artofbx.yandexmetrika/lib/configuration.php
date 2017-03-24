<?php


namespace Artofbx\Yandexmetrika;


use Bitrix\Main\Config\Option;

class Configuration
{
    public static function getModuleId()
    {
        return 'artofbx.yandexmetrika';
    }

    public static function isUserAuthorized()
    {
        return isset($_SESSION["SESS_AUTH"]) &&
        is_array($_SESSION["SESS_AUTH"]) &&
        $_SESSION["SESS_AUTH"]["AUTHORIZED"] === "Y";
    }

    public static function isUserAdmin()
    {
        return self::isUserAuthorized() && $_SESSION['SESS_AUTH']['ADMIN'];
    }

    public static function isActive($config)
    {
        return
            $config['active'] &&
            $config['id'] &&
            (!$config['ignore_admin'] && self::isUserAdmin()) &&
            (!$config['ignore_authorized'] && self::isUserAuthorized());
    }

    public static function getJsConfig($config)
    {
        return array(
            'id' => $config['id'],
            'webvisor' => $config['webvisor'] ? 'true' : 'false',
            'clickmap' => $config['clickmap'] ? 'true' : 'false',
            'trackLinks' => $config['track_links'] ? 'true' : 'false',
            'accurateTrackBounce' => $config['accurate_track_bounce'] ? 'true' : 'false',
            'trackHash' => $config['track_hash'] ? 'true' : 'false',
            'ut' => $config['noindex'] ? '"noindex"' : 'false',
        );
    }

    public static function getConfig($siteId = SITE_ID)
    {
        return array(
            'active' => Option::get(self::getModuleId(), "active", '', $siteId),
            'id' => Option::get(self::getModuleId(), "id", '', $siteId),
            'webvisor' => Option::get(self::getModuleId(), "webvisor", '', $siteId),
            'clickmap' => Option::get(self::getModuleId(), "clickmap", '', $siteId),
            'track_links' => Option::get(self::getModuleId(), "track_links", '', $siteId),
            'accurate_track_bounce' => Option::get(self::getModuleId(), "accurate_track_bounce", '', $siteId),
            'noindex' => Option::get(self::getModuleId(), "noindex", '', $siteId),
            'track_hash' => Option::get(self::getModuleId(), "track_hash", '', $siteId),
            'informer' => Option::get(self::getModuleId(), "informer", '', $siteId),
            'ignore_admin' => Option::get(self::getModuleId(), "ignore_admin", '', $siteId),
            'ignore_authorized' => Option::get(self::getModuleId(), "ignore_authorized", '', $siteId),
        );
    }
}