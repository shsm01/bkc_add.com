<div class="top-menu">
	<?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"top-nav",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(""),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "Y"
	)
	);?>
	<div class="top-menu-sub">
		<div class="top-menu-sub-title"></div>
		<div class="top-menu-sub-content"></div>
	</div>

</div>
<a href="#" class="top-menu-link"></a>
<a href="#" class="search-link"></a>
<div class="search">
	<form action="/search/" method="post">
		<div class="search-input"><input type="text" name="q" value="" placeholder="Поиск по сайту" /></div>
		<div class="search-submit"><input type="submit" value="" /></div>
	</form>
</div>
<?$APPLICATION->IncludeFile("/local/includes/h.menu.course.php",Array(),Array("MODE"=>"php"));?>