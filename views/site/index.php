<?php

/* @var $this yii\web\View */
/* @var $userName string */
/* @var $models array */
/* @var $words array */
/* @var $finish bool */
/* @var $test app\models\Test */
/* @var $pages Pagination */

use yii\bootstrap\Modal;
use yii\data\Pagination;
use yii\helpers\Html;
use app\models\Test;
use yii\widgets\LinkPager;

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="body-content">
        <?php if ($finish) { ?>
            <?php Modal::begin([
                'header' => "<h4>Ваш результат: $result из $count</h4>",
                'id' => 'resultModal',
                'closeButton' => false,
                'clientOptions' => [
                    'show' => true,
                    'backdrop' => 'static',
                    'keyboard' => false,
                ],
            ]) ?>
            <?= Html::button('Завершить', ['onclick' => 'closeModal()', 'class' => 'btn btn-primary']) ?>
            <?php Modal::end() ?>
        <?php } ?>
        <div class="page-header text-center">
            <h2>Добро пожаловать <?= Html::encode(ucfirst(Yii::$app->user->identity->LOGIN) . '!') ?></h2>
        </div>
        <div class="container">
            <div class="text-center">
                <p>Выберите один из тестов для прохождения</p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <ul class="list-group">
                        <?php foreach ($models as $test) { ?>
                            <?php if (Test::testDone($test->ID_TEST)) { ?>
                                <?php $countQuestions = $test->getCountQuestions(); ?>
                                <li class="list-group-item animateLink">
                                    <?= Html::a("<span class='glyphicon glyphicon-hand-right'></span>" . '  ' .
                                        $test->TITLE_TEST . "  <span class='label label-primary'>" . $countQuestions . ' ' .
                                        $test->words($countQuestions, $words) . "</span>",
                                        ['test/index?testId=' . $test->ID_TEST])
                                    ?>
                                </li>
                            <?php } else { ?>
                                <li class="list-group-item">
                                    <span class='glyphicon glyphicon-saved'></span>
                                    <?= $test->TITLE_TEST . "  " . "<span class='label label-success'>Завершен</span>" ?>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center">
            <?= LinkPager::widget([
                'pagination' => $pages
            ]); ?>
        </div>
    </div>
</div>
