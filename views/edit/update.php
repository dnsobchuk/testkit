<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $questModel app\models\Question */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\Test */
/* @var $form yii\widgets\ActiveForm */
/* @var $words */
/* @var array $availableTest */

$this->title = 'Редактировать тест: ' . $testModel->TITLE_TEST;
$this->params['breadcrumbs'][] = ['label' => 'Тесты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $testModel->TITLE_TEST, 'url' => ['view', 'id' => $testModel->ID_TEST]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>

<div class="test-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['action' => ['update', 'id' => $testModel->ID_TEST]]); ?>
        <?= $form->field($testModel, 'TITLE_TEST')->textInput() ?>
        <?= Html::submitButton('Сохранить изменения', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>

    <?php $form = ActiveForm::begin(); ?>
        <?= Html::hiddenInput('Question[FID_TEST]', $testModel->ID_TEST) ?>
        <?= $form->field($questModel, 'CONTENT_QUESTION')->textarea() ?>
        <?= Html::submitButton('Добавить вопрос', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered text-center table-black',
            'format' => ['html']
        ],
        'columns' => [
            'CONTENT_QUESTION',
            ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['style' => 'width:15%'],
                'buttons' => ['update' => function ($url, $model) {
                    return Html::a('<button type="button" class="btn btn-default"  id="questEdit">
                                        <span class="glyphicon glyphicon-pencil"></span></button>',
                        ['question/update', 'id' => $model->ID_QUESTION]);
                }, 'delete' => function ($url, $model) {
                    return Html::a('<button type="button" class="btn btn-default" id="questDel">
                                        <span class="glyphicon glyphicon-trash" ></span></button>',
                        ['question/delete', 'id' => $model->ID_QUESTION],[
                            'data' => [
                                'confirm' => 'Вы уверены? Вы потяряете всю информацию о данной записи',
                                'method' => 'post',
                            ],
                        ]);
                }, 'view' => function ($url, $model) {
                    return Html::a('<button type="button" class="btn btn-default" id="questView">
                                        <span class="glyphicon glyphicon-eye-open" ></span></button>',
                        ['question/view', 'id' => $model->ID_QUESTION]);
                }]
            ],
        ],
    ]); ?>
</div>

