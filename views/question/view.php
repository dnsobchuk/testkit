<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\Question */
/* @var $answModel app\models\Answer */
/* @var $testId */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = ['label' => 'Вопросы', 'url' => ['edit/update', 'id' => $testId]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->ID_QUESTION], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->ID_QUESTION], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'CONTENT_QUESTION',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered text-center'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Текст ответа',
                'attribute' => 'CONTENT_ANSWER',
                'value' => function ($model) {
                    return Html::decode($model->CONTENT_ANSWER);
                }
            ],
            ['label' => 'Верно/неверно', 'value' => function ($model) {
                return $model->IS_RIGHT ? 'Верно' : 'Неверно';
            }],
            ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['style' => 'width:15%'],
                'buttons' => ['update' => function ($url, $model) {
                    return Html::a('<button type="button" class="btn btn-default" id="answ-edit">
                                        <span class="glyphicon glyphicon-pencil" ></span></button>',
                        ['answer/update', 'id' => $model->ID_ANSWER]);
                }, 'delete' => function ($url, $model) {
                    return Html::a('<button type="button" class="btn btn-default" id="answ-del">
                                        <span class="glyphicon glyphicon-trash" ></span></button>',
                        ['answer/delete', 'id' => $model->ID_ANSWER],
                        [
                            'data' => [
                                'confirm' => 'Вы уверены? Вы потяряете всю информацию о данной записи',
                                'method' => 'post',
                            ],
                        ]);
                }, 'view' => function ($url, $model) {
                    return Html::a('<button type="button" class="btn btn-default" id="answ-view">
                                        <span class="glyphicon glyphicon-eye-open" ></span></button>',
                        ['answer/view', 'id' => $model->ID_ANSWER]);
                }],
            ],
        ],
    ]) ?>

</div>
