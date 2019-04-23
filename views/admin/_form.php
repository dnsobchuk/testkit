<?php

use kartik\datetime\DateTimePicker;
use yii\bootstrap\Button;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $userTest app\models\UserTest */
/* @var $tests array */
?>

<div class="test-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'LOGIN')->textInput(['autofocus' => true]) ?>
    <?php if($model->isNewRecord) {
        echo $form->field($model, 'PASSWORD')->textInput([
            'onblur' => 'inputPass(this)',
            'onfocus' => 'inputText(this)'
            ]);
        echo $form->field($model, 'passwordRepeat')->textInput([
            'onblur' => 'inputPass(this)',
            'onfocus' => 'inputText(this)'
            ]);
        echo Button::widget([
            'label' => 'Генерировать',
            'options' => [
                'class' => 'btn-ld btn-primary',
                'onclick' => 'genPass()'
            ]
        ]);
    } ?>
    <?= $form->field($model, 'EMAIL')->textInput() ?>
    <?= $form->field($model, 'PHONE')->widget(MaskedInput::class, [
        'mask' => '9999999999',
    ]) ?>
    <?= $form->field($model, 'dateTime')->widget(DateTimePicker::class,
        [
            'options' => ['placeholder' => 'Введите время действия учетной записи ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'language' => 'ru',
            ],
        ]);
    ?>
    <?= $form->field($model, 'accessRights')->checkboxList($model->available_level) ?>

    <?= $form->field($userTest, 'TestData')->checkboxList(ArrayHelper::map($tests,
        'ID_TEST', 'TITLE_TEST'), ['name' => 'TestData']) ?>

    <div class="form-group">
        <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
