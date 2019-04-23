<?php

/* @var $this yii\web\View */
/* @var $userName string */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\UserSearch */
/* @var $resModel app\models\Result */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <div class="body-content">
        <div class="admin-index">

            <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?php Pjax::begin(['id' => 'some-id',
                'timeout' => false,
                'enablePushState' => false,
            ]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered table-black'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn',  'contentOptions'=>['id' => 'center', 'style'=>'width: 5%;']],
                    [
                        'attribute' => 'LOGIN', 'contentOptions'=>['style'=>'width: 20%;'], 'format' => 'raw',
                        'value' => function ($model) {
                        return "<span class='glyphicon glyphicon-user'></span>" . "  " . $model['LOGIN'];
                        },
                    ],
                    [
                        'attribute' => 'EMAIL', 'contentOptions'=>['style'=>'width: 20%;'], 'format' => 'raw',
                        'value' => function ($model) {
                            return "<span class='glyphicon glyphicon-envelope'></span>" . "  " . $model['EMAIL'];
                        }
                    ],
                    [
                        'attribute' => 'PHONE', 'contentOptions'=>['style'=>'width: 15%;'], 'format' => 'raw',
                        'value' => function ($model) {
                            return "<span class='glyphicon glyphicon-phone-alt'></span>" . "  " . $model['PHONE'];
                        }
                    ],
                    [
                        'attribute' => 'dateTime', 'contentOptions'=>['style'=>'width: 20%;'], 'format' => 'raw',
                        'value' => function ($model) {
                                if(!$model['TimeOver'])
                                {
                                    return "<span class='glyphicon glyphicon-time'></span>" . "  " . $model['DateTime'];
                                }
                                return "<span class='glyphicon glyphicon-lock'></span> Истек срок действия";
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn', 'buttons' => ['update' => function ($url, $model) {
                        return Html::a('<button type="button" class="btn btn-default" id="userEdit">
                        <span class="glyphicon glyphicon-pencil" ></span></button>',
                            ['admin/update', 'id' => $model->ID_USER]);
                        }, 'delete' => function ($url, $model) {
                        return Html::a('<button type="button" class="btn btn-default" id="userDel">
                        <span class="glyphicon glyphicon-trash" ></span></button>',
                            ['admin/delete', 'id' => $model->ID_USER],
                            [
                                'data' => [
                                    'confirm' => 'Вы уверены? Вы потеряете всю информацию об этом пользователе после этого действия.',
                                    'method' => 'post',
                                ],
                            ]);
                        }, 'view' => function ($url, $model) {
                                return Html::a('<button type="button" class="btn btn-default" id = "userview">
                                <span class="glyphicon glyphicon-eye-open"></span></button>',
                            ['admin/view', 'id' => $model->ID_USER]);
                            }],
                        'contentOptions'=>['style'=>'width: 12%;'],
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>