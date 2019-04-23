<?php

use app\models\TestSearch;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var array $availableTest */

$this->title = 'Тесты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-index">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    <hr>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'TITLE_TEST')->textinput() ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'id' => 'save-test']) ?>
    <?php ActiveForm::end(); ?>

    <?= /** @var TestSearch $searchModel */
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' =>  $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered text-center table-black'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width:5%']],
            [
                'label' => 'Название теста',
                'attribute' => 'TITLE_TEST',
                'value' => function ($model) {
                    return Html::decode($model->TITLE_TEST);
                }
            ],
            ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['style' => 'width:15%'],
                'buttons' => ['update' => function ($url, $model) {
                    return Html::a('<button type="button" class="btn btn-default" id="testEdit">
                                            <span class="glyphicon glyphicon-pencil" ></span></button>',
                        ['edit/update', 'id' => $model->ID_TEST]);
                }, 'delete' => function ($url, $model) {
                    return Html::a('<button type="button" class="btn btn-default" id="testDel">
                                            <span class="glyphicon glyphicon-trash" ></span></button>',
                        ['edit/delete', 'id' => $model->ID_TEST],
                        [
                            'data' => [
                                'confirm' => 'Вы уверены? Вы потяряете всю информацию о данной записи',
                                'method' => 'post',
                            ],
                        ]);
                }, 'view' => function ($url, $model) {
                    return Html::a('<button type="button" class="btn btn-default" id = "testView">
                                            <span class="glyphicon glyphicon-eye-open"></span></button>',
                        ['edit/view', 'id' => $model->ID_TEST]);
                }]
            ],
        ],
    ]); ?>
</div>
