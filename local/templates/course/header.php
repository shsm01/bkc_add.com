<?require(dirname(__FILE__)."/../.default/header.php");?><?require_once($_SERVER['DOCUMENT_ROOT'].'/local/includes/lang_pic.php');?>

	<body class="page-course">
		<?$APPLICATION->ShowPanel()?>
<?include($_SERVER['DOCUMENT_ROOT'].'/local/windows/prew.php');?>
<?//$APPLICATION->IncludeFile("/local/includes/err_link.php",Array(),Array("MODE"=>"php"));?>

		<!-- wrapper -->
		<div class="wrapper">

			<header>
				<div class="header-inner">
					<div class="header-left">
						<a href="#" onclick='alert("Функционал в разработке");return false;' class="header-user"><span>Личный кабинет</span></a>

						<div class="header-social">
							<?$APPLICATION->IncludeFile("/local/includes/h.social.php",Array(),Array("MODE"=>"text"));?>
						</div>

						<div class="logo"><a href="/"><img src="/local/layout/images/logo.png" alt="" width="282" height="120" /></a></div>
					</div>

					<div class="header-right">
						<div class="header-contacts">
							<?$APPLICATION->IncludeFile("/local/includes/h.contacts.php",Array(),Array("MODE"=>"text"));?>
						</div>
						<a href="/local/windows/order.php" class="header-link-order window-link">Заявка на обучение</a>
						<a href="/quiz/" class="header-link-test">Пройти онлайн-тест</a>
					</div>

					<div class="header-center"><img src="/local/layout/images/N1-<?=$lang_pic?>.png" alt="" width="370" height="167" /></div>
				</div>
			</header>




            <a href="#" class="nav-menu-mobile-link"></a>
            <div class="nav-menu-mobile">
                <div class="nav-menu-mobile-level-1"></div>
                <div class="nav-menu-mobile-level-2"></div>
                <div class="nav-menu-mobile-level-3"></div>
            </div>


			<!-- nav -->
			<div class="nav">
				<div class="nav-inner">
					<?$APPLICATION->IncludeFile("/local/includes/h.menu.top.php",Array(),Array("MODE"=>"text"));?>
				</div>
			</div>
			<!-- nav END -->

<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "bkc", Array(
	"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
		"SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
		"START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
	),
	false
);?>

			<!-- container -->
			<div class="container">

				<!-- left -->
				<div class="left">

					<a href="#" class="left-menu-mobile"></a>
<?
if(isset($_SERVER["REAL_FILE_PATH"]))
{
    $APPLICATION->SetCurPage($_SERVER["REAL_FILE_PATH"]);
}
else if($_SERVER["PHP_SELF"] != "/bitrix/urlrewrite.php")
{
    $APPLICATION->SetCurPage($_SERVER["PHP_SELF"]);
}
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"vertical_multilevel_courses", 
	array(
		"ALLOW_MULTI_SELECT" => "Y",
		"CHILD_MENU_TYPE" => "",
		"DELAY" => "Y",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "left_c",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "vertical_multilevel_courses"
	),
	false
);?>
<?
$APPLICATION->reinitPath();
?>
				</div>
				<!-- left END -->

				<!-- content -->
				<div class="content">
					<div class="content-wrap">

						<h1><?$APPLICATION->ShowTitle()?></h1>
