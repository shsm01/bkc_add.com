					<div id="map"></div>
					<script src="http://api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU" type="text/javascript"></script>
					<script>
						var schools = [
<?
	$color=array(
		"red"=>"1",
		"green"=>"2",
		"blue"=>"3",
		"blue"=>"4",
		"brown"=>"5",
		"orange"=>"6",
		"purple"=>"7",
		"yellow"=>"8",
		"grey"=>"9",
		"lime"=>"10",
		"teal"=>"11",
		"blue-grey"=>"12",
	);
	$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
	$arFilter = Array("IBLOCK_ID"=>11, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
	CModule::IncludeModule("iblock");
	$res = CIBlockElement::GetList(Array(), $arFilter, false);
	while($ob = $res->GetNextElement()){
		$arFields = $ob->GetFields();
		$arProp = $ob->GetProperties();
		
		$mmm = GetIBlockElement($arProp['metro']['VALUE']);
		$rsSections = CIBlockSection::GetList(
			Array('SORT'=>'ASC'), 
			Array(
				'IBLOCK_ID'=>$mmm['IBLOCK_ID'],
				'ID'=>$mmm['IBLOCK_SECTION_ID']
			),
			false, 
			array("ID","IBLOCK_ID","IBLOCK_SECTION_ID","NAME","UF_*")
		);
		$st = $rsSections->Fetch();
		$coords = explode(',',$arProp['coords']['VALUE']);
?>
[<?=$coords[1].','.$coords[0]?>, '/map/metro.php?id=<?=$arFields['ID']?>', '<?=str_replace("'",'"',$arFields['NAME'])?>',  '<?=$st['UF_COLOR']?$st['UF_COLOR']:'none'?>'],
<?
}
?>
];
                        ymaps.ready(init);

                        var myMap;

                        function init() {
                            myMap = new ymaps.Map('map', {
                                center: [55.755768, 37.617671],
                                zoom: 10,
                                controls: []
                            });

                            myMap.controls.add('zoomControl', {position: {left: 'auto', right: 10, top: 108}});
                            myMap.behaviors.disable('scrollZoom');

                            var MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
                                '<div class="popover">' +
                                    '<a class="close" href="#"></a>' +
                                    '$[[options.contentLayout]]' +
                                '</div>', {
                                    build: function() {
                                        this.constructor.superclass.build.call(this);
                                        this._$element = $('.popover', this.getParentElement());
                                        this.applyElementOffset();
                                        this._$element.find('.close')
                                            .on('click', $.proxy(this.onCloseClick, this));
                                    },

                                    clear: function() {
                                        this._$element.find('.close')
                                            .off('click');
                                        this.constructor.superclass.clear.call(this);
                                    },

                                    onSublayoutSizeChange: function() {
                                        MyBalloonLayout.superclass.onSublayoutSizeChange.apply(this, arguments);
                                        if (!this._isElement(this._$element)) {
                                            return;
                                        }
                                        this.applyElementOffset();
                                        this.events.fire('shapechange');
                                    },

                                    applyElementOffset: function() {
                                        this._$element.css({
                                            left: 33,
                                            top: -76
                                    });
                                },

                                onCloseClick: function(e) {
                                    e.preventDefault();
                                    this.events.fire('userclose');
                                },

                                getShape: function () {
                                    if (!this._isElement(this._$element)) {
                                        return MyBalloonLayout.superclass.getShape.call(this);
                                    }

                                    var position = this._$element.position();

                                    return new ymaps.shape.Rectangle(new ymaps.geometry.pixel.Rectangle([
                                        [position.left, position.top], [
                                            position.left + this._$element[0].offsetWidth,
                                            position.top + this._$element[0].offsetHeight
                                        ]
                                    ]));
                                },

                                _isElement: function(element) {
                                    return element && element[0];
                                }
                            });

                            var MyBalloonContentLayout = ymaps.templateLayoutFactory.createClass(
                                '$[properties.balloonContent]'
                            );

                            for (var i = 0; i < schools.length; i++) {
                                var curItem = schools[i];
                                var myPlacemark = new ymaps.Placemark([curItem[1], curItem[0]], {
                                    hintContent: curItem[3],
                                    balloonLink: curItem[2],
                                    balloonContent: '<div class="popup"><h3>Идет загрузка данных...</h3></div>'
                                }, {
                                    balloonShadow: false,
                                    balloonLayout: MyBalloonLayout,
                                    balloonContentLayout: MyBalloonContentLayout,
                                    hideIconOnBalloonOpen: false,
                                    balloonPanelMaxMapArea: 0,
                                    iconLayout: 'default#image',
                                    iconImageHref: '/local/layout/images/map-icon-' + curItem[4] + '.png',
                                    iconImageSize: [49, 37],
                                    iconImageOffset: [-16, -37]
                                });
                                myPlacemark.events.add('balloonopen', function(e) {
                                    var curPlacemark = e.get('target');
                                    $.ajax({
                                        type: 'POST',
                                        url: curPlacemark.properties.get('balloonLink'),
                                        dataType: 'html',
                                        cache: false
                                    }).done(function(html) {
                                        curPlacemark.properties.set('balloonContent', html);
                                    });
                                });
                                myMap.geoObjects.add(myPlacemark);
                            }
                        }
                    </script>
					<a href="/map/" class="main-map-link">Школы ВКС списком</a>