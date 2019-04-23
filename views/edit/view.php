<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Test */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->TITLE_TEST;
$this->params['breadcrumbs'][] = ['label' => 'Тесты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->TITLE_TEST;
?>
<div class="test-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->ID_TEST], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->ID_TEST], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены? Вы потяряете всю информацию о данной записи',
                'method' => 'POST',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Название теста',
                'value' => function ($model) {return Html::decode($model->TITLE_TEST);}
            ]
        ]
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered text-center'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','contentOptions' => ['style' => 'width:5%'],],
            [
                'attribute' => 'CONTENT_QUESTION',
                'value' => function ($model) {
                    return Html::decode($model->CONTENT_QUESTION);
                }
            ],
            ['class' => 'yii\grid\ActionColumn','contentOptions' => ['style' => 'width:15%'],
                'buttons' => ['update' => function ($url, $model) {
                return Html::a('<button type="button" class="btn btn-default" id="questEdit">
                                        <span class="glyphicon glyphicon-pencil"></span></button>',
                    ['question/update', 'id' => $model->ID_QUESTION]);
            }, 'delete' => function ($url, $model) {
                return Html::a('<button type="button" class="btn btn-default" id="questDel">
                                        <span class="glyphicon glyphicon-trash"></span></button>',
                    ['question/delete', 'id' => $model->ID_QUESTION],
                    [
                        'data' => [
                            'confirm' => 'Вы уверены? Вы потяряете всю информацию о данной записи',
                            'method' => 'post',
                        ],
                    ]);
            }, 'view' => function ($url, $model) {
                return Html::a('<button type="button" class="btn btn-default" id="questView">
                                        <span class="glyphicon glyphicon-eye-open"></span></button>',
                    ['question/view', 'id' => $model->ID_QUESTION]);
            }]
            ],
        ],
    ]); ?>

</div>
