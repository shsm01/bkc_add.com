<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (CModule::IncludeModule("iblock")):

$_REQUEST['ID']=strip_tags($_REQUEST['ID']);

$res=GetIBlockElement($_REQUEST['ID']);
$p=$res['PROPERTIES'];
$coords=explode(',',$p['coords']['VALUE']);

$arFilter = Array("IBLOCK_ID"=>12, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", 'ID'=>$p['metro']['VALUE']);
$res = CIBlockElement::GetList(Array(), $arFilter);
$metro=array();
while($ob = $res->GetNextElement())
{
 $arFields = $ob->GetFields();
$metro[$arFields['ID']]['f']=$arFields;
	$rsSections = CIBlockSection::GetList(Array('SORT'=>'ASC'), 
	Array('IBLOCK_ID'=>$arFields['IBLOCK_ID'],'ID'=>$arFields['IBLOCK_SECTION_ID']),
	false, 
	array("ID","IBLOCK_ID","IBLOCK_SECTION_ID","NAME","UF_*")
	);
	$metro[$arFields['ID']]['st'] = $rsSections->Fetch();

}

?>
<div class="window-school">
    <h2>Как добраться</h2>
<?=$p['map_route']['~VALUE']['TEXT']?>
    <div class="window-school-map">
        <div id="mapWindow"></div>
        <script src="http://api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU" type="text/javascript"></script>
        <script>
            ymaps.ready(init);

            var myMap;

            function init() {
                myMap = new ymaps.Map('mapWindow', {
                    center: [55.755768, 37.617671],
                    zoom: 16,
                    controls: ['zoomControl']
                });

                myMap.behaviors.disable('scrollZoom');

                myPlacemark = new ymaps.Placemark([<?=$p['coords']['VALUE']?>], {}, {
                    iconLayout: 'default#image',
                    iconImageHref: '/local/layout/images/map-icon-<?=(($metro[$p['metro']['VALUE']]['st']['UF_COLOR'])?$metro[$p['metro']['VALUE']]['st']['UF_COLOR']:'none')?>-big.png',
                    iconImageSize: [74, 57],
                    iconImageOffset: [-23, -57]
                });
                myMap.geoObjects.add(myPlacemark);
                myMap.setCenter([<?=$p['coords']['VALUE']?>]);
            }
        </script>
    </div>
</div>
<?
endif;
?>