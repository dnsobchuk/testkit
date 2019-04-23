<?php

/* @var $this yii\web\View */
/* @var $userName string */

use yii\helpers\Html;

$this->title = 'Доступ запрещен';
?>
<div class="access-deny">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="alert alert-danger">
        Уважаемый <?= $userName ?>! К сожалению доступ в данный раздел запрещен.
    </div>
        Пожалуйста не пишите нам если видите это. Спасибо.
    </p>

</div>
