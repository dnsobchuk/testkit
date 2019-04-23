<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Администрирование', 'url' => ['admin/index']],
                ['label' => 'Редактирование', 'url' => ['edit/index']],
                ['label' => 'Результаты', 'url' => ['result/index']],
                (
                    '<li>'
                    . Html::beginForm(['/auth/logout'], 'post')
                    . Html::submitButton(
                        'Выход  <span class="glyphicon glyphicon-log-out"></span>',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
        ]);
        NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Example Company <?= date('Y') ?></p>

            <p class="pull-right"><?= Yii::t('yii', 'Powered by {yii}', [
                    'yii' => '<a href="http://www.yiiframework.com/" rel="external">' . Yii::t('yii',
                            'Yii Framework') . '</a>',
                ]); ?></p>
        </div>
    </footer>
    <div class="lightbox"></div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>