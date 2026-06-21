<?php

use app\models\Video;
use app\modules\admin\components\RedactorSettings;
use kartik\widgets\Select2;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Video */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php $descriptionEditorSettings = RedactorSettings::description(); ?>

    <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_ky')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description_ru')->widget(
        Widget::className(),
        [
            'settings' => $descriptionEditorSettings,
        ]
    ); ?>

    <?= $form->field($model, 'description_en')->widget(
        Widget::className(),
        [
            'settings' => $descriptionEditorSettings,
        ]
    ); ?>

    <?= $form->field($model, 'description_ky')->widget(
        Widget::className(),
        [
            'settings' => $descriptionEditorSettings,
        ]
    ); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description_position')->widget(Select2::className(), [
        'data' => Video::getDescriptionPositionOptions(),
        'options' => [
            'encode' => false,
            'placeholder' => 'Выберите позицию описания ...',
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
