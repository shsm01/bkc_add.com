                            <form action="/quiz/inc/question.getnext.php" method="post" id="cur_quest_form">
                                <input type="hidden" name="question" value="<?=$q["id"]?>">
                                <div class="test-container">
                                    <div class="test-header">
                                        <div class="test-header-title test-header-title-<?=$_SESSION["quiz"]["lang-data"][1]?>"><?=$_SESSION["quiz"]["test_info"]["name"]?></div>
                                        <div class="test-count">Вопрос: <strong><?=count($_SESSION["quiz"]["answered"])?> / <?=$_SESSION["quiz"]["quest_total"]?></strong></div>
                                    </div>

                                    <div class="test-timer" data-textend="К сожалению, время закончилось. Тест провален">Времени осталось: <strong><span class="minutes"><?=$time_minuts?></span> мин <span class="seconds"><?=IntVal($time_seconds)?></span> сек</strong></div>
                                    
                                    <div class="test-question-title">Вопрос <?=count($_SESSION["quiz"]["answered"])?></div>
                                    <div class="test-question"><?=$q["question"] // <span>__ go</span>?></div>

<?if($q["question_type"] == 1){?>
                                    <div class="test-finish-form">
                                        <div class="form-row form-row-2">
                                            <div class="form-label">Выберите пропущенное слово</div>
                                            <div class="form-field">
                                                <div class="form-radios">
                                                    <?
                                                     foreach ($q["answers"] as $keyA=>$a){?>
                                                    <div class="form-radio"><span><input type="radio" name="answer" value="<?=$a["id"]?>"<?=$keyA ? '': ' checked="checked"'?> /></span><?=$a["answer"]?></div>
                                                    <?}?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
<?}else{?>
                                    <div class="test-finish-form">
                                        <div class="form-row form-row-2">
                                            <div class="form-label">Введите пропущенное слово</div>
                                            <div class="form-field">
                                                <div class="form-input"><input type="text" name="answer" value="" /></div>
                                            </div>
                                        </div>
                                    </div>
<?}?>
                                </div>
                                <div class="test-next test-next-wide">
                                    <a href="#" class="btn">Продолжить</a>
                                </div>
                            </form>
                        </div>
                        <!-- test END -->