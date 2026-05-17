<?php

use app\models\Page;
use kartik\widgets\Select2;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent_id')->widget(Select2::className(), [
        'id' => rand(),
        'data' => Page::getList(),
        'options' => [
            'encode' => false,
            'placeholder' => 'Выберите родительскую страницу ...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_ky')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'menu_title_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'menu_title_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'menu_title_ky')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content_ru')->widget(
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
                'imageUpload' => Url::to(['/admin/page/image-upload']),
                'fileUpload' => Url::to(['/admin/page/file-upload']),

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

    <?= $form->field($model, 'content_en')->widget(
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
                'imageUpload' => Url::to(['/admin/page/image-upload']),
                'fileUpload' => Url::to(['/admin/page/file-upload']),

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

    <?= $form->field($model, 'content_ky')->widget(
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
                'imageUpload' => Url::to(['/admin/page/image-upload']),
                'fileUpload' => Url::to(['/admin/page/file-upload']),

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

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <?= $form->field($model, 'is_main')->checkbox() ?>

    <?= $form->field($model, 'show_in_menu')->checkbox() ?>

    <?= $form->field($model, 'show_subpages')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
