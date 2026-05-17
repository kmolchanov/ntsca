<?php

use app\models\Video;
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

    <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_ky')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description_ru')->widget(
        Widget::className(),
        [
            'settings' => [
                'minHeight' => 300,
                'replaceDivs' => false,
                'deniedTags' => false,
                'cleanOnPaste' => false,
                'imageCaption' => true,
                'cleanup' => false,
                'removeEmptyTags' => false,
                'removeSpaces' => false,
                'paragraphize' => false,

                'plugins' => [
                    'imagemanager',
                    'filemanager',
                    'clips',
                    'fullscreen',
                    'table',
                    'fontsize',
                    'fontcolor',
                    'video',
                ]
            ],
        ]
    ); ?>

    <?= $form->field($model, 'description_en')->widget(
        Widget::className(),
        [
            'settings' => [
                'minHeight' => 300,
                'replaceDivs' => false,
                'deniedTags' => false,
                'cleanOnPaste' => false,
                'imageCaption' => true,
                'cleanup' => false,
                'removeEmptyTags' => false,
                'removeSpaces' => false,
                'paragraphize' => false,

                'plugins' => [
                    'imagemanager',
                    'filemanager',
                    'clips',
                    'fullscreen',
                    'table',
                    'fontsize',
                    'fontcolor',
                    'video',
                ]
            ],
        ]
    ); ?>

    <?= $form->field($model, 'description_ky')->widget(
        Widget::className(),
        [
            'settings' => [
                'minHeight' => 300,
                'replaceDivs' => false,
                'deniedTags' => false,
                'cleanOnPaste' => false,
                'imageCaption' => true,
                'cleanup' => false,
                'removeEmptyTags' => false,
                'removeSpaces' => false,
                'paragraphize' => false,

                'plugins' => [
                    'imagemanager',
                    'filemanager',
                    'clips',
                    'fullscreen',
                    'table',
                    'fontsize',
                    'fontcolor',
                    'video',
                ]
            ],
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
