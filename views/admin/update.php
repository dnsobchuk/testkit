<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $tests array */
/* @var $userTest app\models\UserTest */

$this->title = 'Редактировать пользователя: ' . $model->LOGIN;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->LOGIN, 'url' => ['view', 'id' => $model->ID_USER]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="test-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tests' => $tests,
        'userTest' => $userTest
    ]) ?>

</div>
