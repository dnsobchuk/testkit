<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Question */
/* @var $answerModel app\models\Answer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Редактировать вопрос: ' . $questionModel->CONTENT_QUESTION;
$this->params['breadcrumbs'][] = ['label' => 'Вопросы', 'url' => ['edit/update', 'id' => $questionModel->FID_TEST]];
$this->params['breadcrumbs'][] = ['label' => $questionModel->CONTENT_QUESTION, 'url' => ['view', 'id' => $questionModel->ID_QUESTION]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['action' => ['update', 'id' => $questionModel->ID_QUESTION]]); ?>
        <?= $form->field($questionModel, 'CONTENT_QUESTION')->textarea() ?>
        <?= Html::submitButton('Сохранить изменения', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($answerModel, 'CONTENT_ANSWER')->textarea() ?>
        <?= $form->field($answerModel,'IS_RIGHT')->checkbox(['label' => 'Верно']) ?>
        <?= Html::hiddenInput('Answer[FID_QUESTION]', $questionModel->ID_QUESTION) ?>
        <?= Html::submitButton('Добавить ответ', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered text-center table-black'
        ],
        'columns' => [
            'CONTENT_ANSWER',
            ['label' => 'Верно/Неверно', 'value' => function ($model) {
                return $model->IS_RIGHT ? 'Верно' : 'Неверно';
            }],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => ['update' => function ($url, $model) {
                    return Html::a('<button type="button" class="btn btn-default" id="answEdit">
                                        <span class="glyphicon glyphicon-pencil" ></span></button>',
                        ['answer/update', 'id' => $model->ID_ANSWER]);
                }, 'delete' => function ($url, $model) {
                    return Html::a('<button type="button" class="btn btn-default" id="answDel">
                                        <span class="glyphicon glyphicon-trash"></span></button>',
                        ['answer/delete', 'id' => $model->ID_ANSWER],
                        [
                            'data' => [
                                'confirm' => 'Вы уверены? Вы потяряете всю информацию о данной записи',
                                'method' => 'post',
                            ],
                        ]);
                }, 'view' => function ($url, $model) {
                    return Html::a('<button type="button" class="btn btn-default" id="answView">
                                        <span class="glyphicon glyphicon-eye-open"></span></button>',
                        ['answer/view', 'id' => $model->ID_ANSWER]);
                }],
            ],
        ]]); ?>
</div>