<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	CModule::IncludeModule("subscribe");
//there must be at least one newsletter category
    $arFields = Array(
        "USER_ID" => false,
        "FORMAT" => "text",
        "EMAIL" => $_REQUEST['sf_EMAIL'],
        "ACTIVE" => "Y",
        "RUB_ID" => $_REQUEST['sf_RUB_ID']
    );
    $subscr = new CSubscription;

    //can add without authorization
    $ID = $subscr->Add($arFields);
    if($ID>0)
        print('<div class="window-success">
    <h1>Поздравляем!</h1>
    <p>Вы успешно подписались на новсти и акции нашего сайта. Адрес подписки <span class="subscribe-email">'.$_REQUEST['sf_EMAIL'].'</span></p>
    <a href="#" class="btn">закрыть</a>
</div>');
    else
        print("Ошибка подписки: ".strip_tags($subscr->LAST_ERROR));
?>