<?php

/* @var $this yii\web\View */
/* @var $userName string */
/* @var $models array */
/* @var $result app\models\Result */
/* @var $countQuery app\models\Result */
/* @var $test app\models\Test */
/* @var $pages \yii\data\Pagination */

/* @var $user app\models\User */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'Результаты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="results">
    <div class="page-header">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <span>Показаны результаты <b>1-<?= count($models) ?></b> из <b><?= $countQuery->count() ?></b></span>
                    <?php Pjax::begin(['id' => 'some-id',
                        'timeout' => false,
                        'enablePushState' => false,
                    ]); ?>
                    <table class="table table-hover table-bordered table-black">
                        <thead class="thead-default">
                        <tr>
                            <th>#</th>
                            <th>Пользователь</th>
                            <th>Наименование теста</th>
                            <th class="text-center">Правильные ответы / Всего</th>
                        </tr>
                        <tr class="filters">
                            <td></td>
                            <td>
                                <?php $form = ActiveForm::begin([
                                    'method' => 'post',
                                    'options' => [
                                        'data' => ['pjax' => true]
                                    ],
                                ]); ?>
                                <?= $form->field($searchModel, 'Result')
                                    ->textInput(['autofocus' => true,])->label(false) ?>
                                <?php ActiveForm::end(); ?>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($models as $result) {
                            $test = $result->test;
                            $user = $result->user;
                            $count = $test->getCountQuestions();
                            ?>
                            <tr>
                                <td class="animateLink">
                                    <?= Html::a("<span class='glyphicon glyphicon-arrow-right'></span> " .
                                        $result->ID_RESULT, ['result/result?id=' . $result->ID_RESULT],
                                        ['class' => 'animateLink']) ?></td>
                                <td><span class="glyphicon glyphicon-user"></span> <?= $user->LOGIN ?></td>
                                <td><span class="glyphicon glyphicon-book"></span> <?= $test->TITLE_TEST ?></td>
                                <td class="text-center"><span class="glyphicon glyphicon-stats"></span>
                                    <?= $result->RIGHT_ANSWERS . '/' . $count ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <?= LinkPager::widget([
                        'pagination' => $pages,
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
