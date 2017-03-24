<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?$APPLICATION->ShowTitle()?></title>
		
		
		<link rel="SHORTCUT ICON" href="/favicon.png" type="image/x-icon">

		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fira+Sans:300,300italic,400,500,500italic&amp;subset=latin,cyrillic" />
		
		<link href='https://code.cdn.mozilla.net/fonts/fira.css' rel='stylesheet' type='text/css' />
		
        <?
        $APPLICATION->SetAdditionalCSS('/local/layout/css/styles.css');
        $APPLICATION->SetAdditionalCSS('/local/layout/js/chosen/chosen.css');
        $APPLICATION->SetAdditionalCSS('/local/layout/js/jscrollpane/jquery.jscrollpane.css');
        $APPLICATION->SetAdditionalCSS('/local/layout/js/datatables/datatables.css');
        $APPLICATION->SetAdditionalCSS('/local/layout/js/slick/slick.css');
        $APPLICATION->SetAdditionalCSS('/local/layout/css/add.css');
        ?>

        <?
        $APPLICATION->AddHeadScript('/local/layout/js/jquery-2.2.4.min.js');
        $APPLICATION->AddHeadScript('/local/layout/js/chosen/chosen.jquery.min.js');
        $APPLICATION->AddHeadScript('/local/layout/js/jquery.maskedinput.min.js');
        $APPLICATION->AddHeadScript('/local/layout/js/validation/jquery.validate.min.js');
        $APPLICATION->AddHeadScript('/local/layout/js/validation/messages_ru.js');
        $APPLICATION->AddHeadScript('/local/layout/js/jscrollpane/jquery.mousewheel.js');
        $APPLICATION->AddHeadScript('/local/layout/js/jscrollpane/jquery.jscrollpane.min.js');
        $APPLICATION->AddHeadScript('/local/layout/js/jquery.cookie.js');
        $APPLICATION->AddHeadScript('/local/layout/js/datatables/datatables.min.js');
        $APPLICATION->AddHeadScript('/local/layout/js/jquery.scrollTo.min.js');
        $APPLICATION->AddHeadScript('/local/layout/js/slick/slick.min.js');
        $APPLICATION->AddHeadScript('/local/layout/js/tools.js');
        $APPLICATION->AddHeadScript('/local/layout/js/add.js');
        ?>

		<?$APPLICATION->ShowHead()?>

        <meta name="viewport" content="width=480" />
	</head>