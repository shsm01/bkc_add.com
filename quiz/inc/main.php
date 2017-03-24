<?if(IntVal($_GET["test"])){
  //обнулим сессию, заведем новую запись
  $_SESSION["quiz"] = array();
  $_SESSION["quiz"]["test"] = IntVal($_GET["test"]); //возможно потом придется заменить на контроль через БД
  $_SESSION["quiz"]["answered_correct"] = 0;
  $_SESSION["quiz"]["answered"][] = 0; //для обезкостыливания запроса 
  
  LocalRedirect("?step=2");
}?>
                        <p>Прежде чем приступить к усовершенствованию Ваших знаний, необходимо определить, в каком объеме Вы уже владеете языком. Здесь Вы сможете пройти онлайн тесты по английскому и другим иностранным языкам и определить свой уровень, а также определиться с курсом и (или) учебником для дальнейшего обучения.</p>
                        <p>Просим обратить внимание на то, что результаты письменного тестирования не отражает всю полноту знаний и для правильных рекомендаций важно пройти устное тестирование, которое возможно пройти бесплатно с нашим преподавателем в одной из школ ВКС-IH.</p>

                        <!-- test -->
                        <div class="test">
                            <form action="." method="get">
                                <div class="test-container">
                                    <div class="test-step-number">Шаг 1</div>
                                    <div class="test-step-title">Выбор языка</div>

                                    <div class="test-select-langs">
<?
$query = "SELECT * FROM `quiz_types` WHERE  `status` = 1 ORDER BY `language_id` ASC, `mysort` ASC";
$rs = $DB->Query($query);
$courses = array();
while($type = $rs->Fetch()){    
  $ind = $type["lid"];

  $showed = false;
  
  if($courses[$ind]){
    $showed = true;
    $courses[$ind][] = $type;
  }else{
    $courses[$ind][] = $type;
  }

  if(!$showed){
?>
                                        <div class="test-select-lang<?=$k++ ? '':' active'?>">
                                            <div class="test-select-lang-icon test-select-lang-icon-<?=$langs[$ind][1]?>"></div>
                                            <?=$langs[$ind][0]?>
                                        </div>
<?
  }
}
?>
                                    </div>

                                    <div class="test-select-sub">
<?
$k = 0;
foreach($courses as $lid => $lang){
  $elem_count = count($lang);
?>
                                        <div class="test-select-sub-item<?=$k++ ? '':' active'?>">
                                            <div class="test-select-sub-list">
      <?
      //$z = 0;
      foreach($lang as $course){?>
                                                <div class="test-select-sub-list-item<?=$elem_count > 1 ? ' test-select-sub-list-item-2':''?>">
                                                    <input type="radio" name="test" value="<?=$course["id"]?>"<?=$z++ ? '':' checked="checked"'?> />
                                                    <?=$course["name"]?>
                                                </div>
      <?}?>
                                            </div>
                                        </div>
<?}?>
                                    </div>
                                </div>
                                <div class="test-next">
                                    <div class="form-submit"><input type="submit" value="Продолжить" /></div>
                                </div>
                            </form>
                        </div>
                        <!-- test END -->