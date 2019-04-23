<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Question */
/* @var $model app\models\Answer*/
/* @var $dataProvider yii\data\ActiveDataProvider*/

$this->params['breadcrumbs'][] = ['label' => 'Вопрос', 'url' => ['question/update','id' => $model->FID_QUESTION]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->ID_ANSWER], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->ID_ANSWER], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить эелемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

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
        ],
    ]) ?>

</div>
