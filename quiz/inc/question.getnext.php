<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
if(!$_SESSION["quiz"]["test"]) LocalRedirect(".");

//обработаем данные
if($_POST["answer"] && $_POST["question"]){
   $_SESSION["quiz"]["answered"][] = IntVal($_POST["question"]);

   $query = "SELECT * FROM `quiz_questions` WHERE `quiz_stage_id` IN (".implode(", ", $_SESSION["quiz"]["stages"]).") AND `id` = ". IntVal($_POST["question"]);
   $q = $DB->Query($query)->Fetch();

   //получим массив вариантов
   $query = "SELECT * FROM `quiz_answers` WHERE `quiz_question_id` = ".$q["id"]." ORDER BY `mysort`";
   $a_res = $DB->Query($query);

   //сравним ответы, если выбрать из списка
   if($q["question_type"] == 1){
     while($answ = $a_res->Fetch()){
        if($answ["id"] == IntVal($_POST["answer"]) && $answ["correct"]) $_SESSION["quiz"]["answered_correct"]++ ;
     }
   }else{
    //если надо было ввести слово
      $inc_answer = trim(mb_strtolower($_POST["answer"]));
      $right_answer = trim($answ["answer"]);
        if($right_answer == $inc_answer) $_SESSION["quiz"]["answered_correct"]++ ;
   }

}

//если мы достигли лимита - покажем форму финальную
if(count($_SESSION["quiz"]["answered"]) >= $_SESSION["quiz"]["quest_total"]){
  $_SESSION["quiz"]["finished"] = 1;
  echo "<script>top.location.href='./?step=4'</script>";
  return;
}


//если нет - получим следующий вопрос
   $query = "SELECT * FROM `quiz_questions` WHERE `quiz_stage_id` IN (".implode(", ", $_SESSION["quiz"]["stages"]).") AND `id` NOT IN (".implode(",", $_SESSION["quiz"]["answered"]).") ORDER BY `mysort` LIMIT 1";
   $q = $DB->Query($query)->Fetch();


   if($q["id"]){
     //получим массив вариантов
     $query = "SELECT * FROM `quiz_answers` WHERE `quiz_question_id` = ".$q["id"]." ORDER BY RAND()";
     $a_res = $DB->Query($query);
  
     while($answ = $a_res->Fetch()){
        $q["answers"][] = $answ;   
     }
  
     $_SESSION["quiz"]["curr_quest"] = $q["id"];
     
     
     //посчтиаем время
     $time = $_SESSION["quiz"]["test_info"]["time"]*60 - (time() - $_SESSION["quiz"]["time_start"]);
     
     if ($time <= 0) {
      require("timeout.php");
      return;
     } 
     
     $time_minuts   = floor($time/60);
     $time_seconds  = $time - $time_minuts * 60;  
     
     require ("question.php");
   }

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');
?>