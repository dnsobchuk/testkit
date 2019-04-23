<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Test */
/* @var $model app\models\Answer */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="answer-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'CONTENT_ANSWER')->textarea() ?>
    <?= $form->field($model,'IS_RIGHT')->checkbox(['label' => 'Верно']) ?>
    <?= Html::submitButton('Сохранить изменения', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>
</div>
