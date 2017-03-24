<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("404 Not Found");
$APPLICATION->AddChainItem("404 Not Found");
?>

            <!-- container -->
            <div class="container">

                <!-- content -->
                <div class="content">
                    <div class="content-wrap">

                        <div class="page-404-text-1">404</div>
                        <div class="page-404-text-2">Страница не найдена</div>
                        <div class="page-404-text-3">Страница, которую вы ищете, не существует либо устарела.<br />Вы можете перейти в один из разделов сайта или воспользоваться поиском.</div>
                        <div class="page-404-text-4"><a href="/">Перейти на главную</a></div>

                    </div>
                </div>
                <!-- content END -->

            </div>
            <!-- container END -->


<?
/*
$APPLICATION->IncludeComponent("bitrix:main.map", ".default", Array(
	"LEVEL"	=>	"3",
	"COL_NUM"	=>	"2",
	"SHOW_DESCRIPTION"	=>	"Y",
	"SET_TITLE"	=>	"Y",
	"CACHE_TIME"	=>	"36000000"
	)
);
*/
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>