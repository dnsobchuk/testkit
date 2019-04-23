<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->LOGIN;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->ID_USER], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->ID_USER], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить пользователя ' . Html::encode($model->LOGIN) . '?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'LOGIN',
            'EMAIL',
            'PHONE',
            [
                'attribute' => 'ACCESS_LEVEL',
                'format' => 'raw',
                'value' => Html::checkboxList('', $model->getAccessRights(),
                    $model->available_level, [
                        'itemOptions' => ['disabled' => true],
                        'separator' => '<br>'
                    ]),
            ],
            'dateTime',
        ],
    ]) ?>

</div>
