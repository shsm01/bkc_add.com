<?
if($_GET["name"] && $_GET["phone"] && check_email($_GET["email"])){
  $_SESSION["quiz"]["name"]  = $_GET["name"]; 
  $_SESSION["quiz"]["phone"] = $_GET["phone"]; 
  $_SESSION["quiz"]["email"] = $_GET["email"]; //возможно потом придется заменить на контроль через БД
  LocalRedirect("?step=3");
}
?>
                        <p>Прежде чем приступить к усовершенствованию Ваших знаний, необходимо определить, в каком объеме Вы уже владеете языком. Здесь Вы сможете пройти онлайн тесты по английскому и другим иностранным языкам и определить свой уровень, а также определиться с курсом и (или) учебником для дальнейшего обучения.</p>
                        <p>Просим обратить внимание на то, что результаты письменного тестирования не отражает всю полноту знаний и для правильных рекомендаций важно пройти устное тестирование, которое возможно пройти бесплатно с нашим преподавателем в одной из школ ВКС-IH.</p>

                        <!-- test -->
                        <div class="test">
                            <form action="." method="get">
                                <input type="hidden" name="step" value="2">
                                <div class="test-container">
                                    <div class="test-step-number">Шаг 2</div>
                                    <div class="test-step-title">Персональные данные</div>

                                    <div class="test-personal">
                                        <div class="form-row">
                                            <div class="form-label">Ваши имя и фамилия <span>*</span></div>
                                            <div class="form-field">
                                                <div class="form-input"><input type="text" name="name" value="" class="required" /></div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-label">Ваш телефон <span>*</span></div>
                                            <div class="form-field">
                                                <div class="form-input"><input type="text" name="phone" value="" class="required maskPhone" /></div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-label">Ваш email <span>*</span></div>
                                            <div class="form-field">
                                                <div class="form-input"><input type="text" name="email" value="" class="required email" /></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="test-next">
                                    <div class="form-submit"><input type="submit" value="Начать тестирование" /></div>
                                </div>
                            </form>
                        </div>
                        <!-- test END -->