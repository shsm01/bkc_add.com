<?
//$_SESSION["quiz"]["time_start"] = 0;
if(!$_SESSION["quiz"]["test"]) LocalRedirect(".");

//инициируем опрос если надо
if(!$_SESSION["quiz"]["time_start"]){
   $_SESSION["quiz"]["time_start"] = time();
} 

   if(!count($_SESSION["quiz"]["stages"])){
     //получим стадии вопросов (группы) для текущего теста. проигнорируем фильтр тест
     $query = "SELECT * FROM `quiz_stages` WHERE `quiz_type_id` = ".IntVal($_SESSION["quiz"]["test"])." AND NOT `is_filter`";
     $q = $DB->Query($query);
     $_SESSION["quiz"]["stages"] = array();
     while($st = $q->Fetch()){
        $_SESSION["quiz"]["stages"][] = $st["id"];      
     }
   }
   

   //получим количество вопросов
   $query = "SELECT count(*) as `cnt` FROM `quiz_questions` WHERE `quiz_stage_id` IN (".implode(", ", $_SESSION["quiz"]["stages"]).")";
   $q = $DB->Query($query)->Fetch();
   $_SESSION["quiz"]["quest_total"] = $q['cnt'];
   $_SESSION["quiz"]["quest_passed"] = array();

   //загрузим параметры теста
   $query = "SELECT * FROM `quiz_types` WHERE  `status` = 1 AND `id` = ".IntVal($_SESSION["quiz"]["test"])." LIMIT 1";
   $rs = $DB->Query($query)->Fetch();
   
   $_SESSION["quiz"]["test_info"] = $rs;

   $_SESSION["quiz"]["lang-data"] = $langs[$rs["lid"]]; //возможно потом придется заменить на контроль через БД


   //посчтиаем время
   $time = $_SESSION["quiz"]["test_info"]["time"]*60 - (time() - $_SESSION["quiz"]["time_start"]);
        
          
   $time_minuts   = floor($time/60);
   $time_seconds  = $time - $time_minuts * 60;  
     
   $query = "SELECT * FROM `quiz_questions` WHERE `quiz_stage_id` IN (".implode(", ", $_SESSION["quiz"]["stages"]).") AND `id` NOT IN (".implode(",", $_SESSION["quiz"]["answered"]).") ORDER BY `mysort` LIMIT 1";
   //echo $query;
   $q = $DB->Query($query)->Fetch();
//   var_dump($q);
   $_SESSION["quiz"]["curr_quest"] = $q["id"];

   //получим массив вариантов
   $query = "SELECT * FROM `quiz_answers` WHERE `quiz_question_id` = ".$q["id"]." ORDER BY `mysort`";
   $a_res = $DB->Query($query);

   while($answ = $a_res->Fetch()){
      $q["answers"][] = $answ;   
   }


?>
                        <p>Прежде чем приступить к усовершенствованию Ваших знаний, необходимо определить, в каком объеме Вы уже владеете языком. Здесь Вы сможете пройти онлайн тесты по английскому и другим иностранным языкам и определить свой уровень, а также определиться с курсом и (или) учебником для дальнейшего обучения.</p>
                        <p>Просим обратить внимание на то, что результаты письменного тестирования не отражает всю полноту знаний и для правильных рекомендаций важно пройти устное тестирование, которое возможно пройти бесплатно с нашим преподавателем в одной из школ ВКС-IH.</p>

                        <!-- test -->
                        <div class="test">

<?
if($time > 0){
  require("question.php");
}else
  require("timeout.php");
?>

                        </div>