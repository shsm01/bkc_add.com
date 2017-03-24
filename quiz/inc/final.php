<?
if(!$_SESSION["quiz"]["finished"]) LocalRedirect(".");

//получим уровень quiz_ranks - Таблицаа с диапазонами, quiz_rank_levels - таблица с уровнями языков                               

$total = IntVal($_SESSION["quiz"]["answered_correct"]);
$query = "SELECT `l`.`title` as `level` FROM `quiz_rank_levels` as `l`, `quiz_ranks` as `r` WHERE `r`.`quiz_type_id` = ".$_SESSION["quiz"]["finished"]." AND `r`.`from` <= ".$total. " AND  `r`.`to` >= ".$total. " AND `r`.`quiz_rank_level_id` = `l`.`id`";
$lvl = $DB->Query($query)->Fetch();

//сформируем список школ
CModule::IncludeModule("iblock");
$arSelect = Array("ID", "NAME");
$arFilter = Array("IBLOCK_ID"=>11, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, Array("nTopCount"=>100), $arSelect);
$schools = array();
while($r = $res->Fetch())
{
 $schools[$r["ID"]] = $r;
}

if($_GET["name"]){
  //сохранение в базу
  
  //письмо
  
  LocalRedirect("./?step=5");

}

?>

                        <!-- test -->
                        <div class="test">
                            <form action="#" method="get">
                              <input type="hidden" name="step" value="4">
                                <div class="test-container">
                                    <div class="test-header">
                                        <div class="test-header-title test-header-title-<?=$_SESSION["quiz"]["lang-data"][1]?>"><?=$_SESSION["quiz"]["test_info"]["name"]?></div>
                                    </div>

                                    <div class="test-finish-text">Тест закончен.<br /> Количество правильных ответов <strong><?=$_SESSION["quiz"]["answered_correct"]?> из <?=$_SESSION["quiz"]["quest_total"]?></strong></div>
                                    <div class="test-finish-level">Ваш уровень: <?=$lvl["level"]?></div>

                                    <div class="test-finish-form">
                                        <div class="form-row">
                                            <div class="form-label">Ваше ФИО <span>*</span></div>
                                            <div class="form-field">
                                                <div class="form-input"><input type="text" name="name" value="<?=$_SESSION["quiz"]["name"]?>" class="required" /></div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-label">Ваш телефон <span>*</span></div>
                                            <div class="form-field">
                                                <div class="form-input form-input-2"><input type="text" name="phone" value="<?=$_SESSION["quiz"]["phone"]?>" class="required maskPhone" /></div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-label">Ваш email</div>
                                            <div class="form-field">
                                                <div class="form-input"><input type="text" name="email" value="<?=$_SESSION["quiz"]["email"]?>" class="email" /></div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-label">Ваш возраст</div>
                                            <div class="form-field">
                                                <div class="form-input form-input-3"><input type="text" name="age" value="" class="number" /></div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-label">Откуда вы узнали о нас?</div>
                                            <div class="form-field">
                                                <div class="form-input"><input type="text" name="where" value="" /></div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-label">Выберите школу</div>
                                            <div class="form-field">
                                                <div class="form-select">
                                                    <select name="level" data-placeholder="Выберите" class="required">
                                                        <option value=""></option>
                                                        <? foreach($schools as $sc){?>
                                                        <option value="<?=$sc["ID"]?>"><?=$sc["NAME"]?></option>
                                                        <?}?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-label form-label-test">&nbsp;</div>
                                            <div class="form-field">
                                                <div class="form-checkboxes">
                                                    <div class="form-checkbox"><span><input type="checkbox" name="skype" /></span>Обучение по Skype</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="test-next test-next-wide">
                                    <div class="form-submit"><input type="submit" value="Отправить" /></div>
                                </div>
                            </form>
                        </div>
                        <!-- test END -->