<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Question */
/* @var $model app\models\Answer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Редактировать ответ: ' . $model->CONTENT_ANSWER;
$this->params['breadcrumbs'][] = ['label' => 'Ответы', 'url' => ['question/update','id' => $model->FID_QUESTION]];
$this->params['breadcrumbs'][] = ['label' => $model->CONTENT_ANSWER, 'url' => ['answer/update', 'id' => $model->ID_ANSWER]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="answer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>