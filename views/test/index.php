<?php

/* @var $this yii\web\View */
/* @var $currentTest app\models\Test */
/* @var $currentQuestion app\models\Question */
/* @var array $currentAnswers */
/* @var $questionForm app\models\QuestionsForm */
/* @var array $dataTime */
/* @var int $countQuestion */
/* @var int $currentQuestionNumber */

use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Тестирование';
?>
<div class="site-index">
    <div class="container">
        <div id="test" class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="page-header">
                    <h1 class="text-center"><?= $currentTest->TITLE_TEST ?></h1>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-info-sign"></span>
                        <span>Пройдено: <?= $currentQuestionNumber ?> из <?= $countQuestion ?></span>
                    </div>
                    <div class="panel-body">
                        <div id="timer">
                            <span class="glyphicon glyphicon-time"></span>
                            <span id="titleTime">Время завершения: </span>
                            <span id="minutes"><?= $dataTime['min'] ?></span>
                            <span id="colons">:</span>
                            <span id="seconds"><?= $dataTime['sec'] ?></span>
                        </div>
                    </div>
                </div>
                <div class="test-form">
                    <?php $form = ActiveForm::begin(['action' => 'post']); ?>
                    <input type="hidden" name="currentTest" value="<?= $currentTest->ID_TEST ?>">
                    <input type="hidden" name="currentQuestion" value="<?= $currentQuestion->ID_QUESTION ?>">

                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="glyphicon glyphicon-comment"></span>
                            <span><?= Html::decode($currentQuestion->CONTENT_QUESTION) ?></span>
                        </li>
                        <li class="list-group-item">
                            <?= $form->field($questionForm, 'answers')->checkboxList(ArrayHelper::map
                            ($currentAnswers, 'ID_ANSWER', 'CONTENT_ANSWER')) ?>
                        </li>
                        <li class="list-group-item">
                            <?= Html::submitButton('Подтвердить', ['id' => 'submitButton', 'class' => 'btn btn-success']) ?>
                        </li>

                        <?php ActiveForm::end(); ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>