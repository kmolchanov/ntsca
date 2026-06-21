<?php

use app\models\Gallery;
use app\models\Page;
use app\models\Video;
use app\modules\admin\components\RedactorSettings;
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
    <?php $contentEditorSettings = RedactorSettings::content(
        Url::to(['/admin/page/image-upload']),
        Url::to(['/admin/page/file-upload'])
    ); ?>

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
            'settings' => $contentEditorSettings,
        ]
    ); ?>

    <?= $form->field($model, 'content_en')->widget(
        Widget::className(),
        [
            'settings' => $contentEditorSettings,
        ]
    ); ?>

    <?= $form->field($model, 'content_ky')->widget(
        Widget::className(),
        [
            'settings' => $contentEditorSettings,
        ]
    ); ?>

    <?= $form->field($model, 'top_gallery_id')->widget(Select2::className(), [
        'id' => rand(),
        'data' => Gallery::getList(),
        'options' => [
            'encode' => false,
            'placeholder' => 'Выберите галерею ...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'bottom_gallery_id')->widget(Select2::className(), [
        'id' => rand(),
        'data' => Gallery::getList(),
        'options' => [
            'encode' => false,
            'placeholder' => 'Выберите галерею ...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'top_video_id')->widget(Select2::className(), [
        'id' => rand(),
        'data' => Video::getList(),
        'options' => [
            'encode' => false,
            'placeholder' => 'Выберите видео ...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'bottom_video_id')->widget(Select2::className(), [
        'id' => rand(),
        'data' => Video::getList(),
        'options' => [
            'encode' => false,
            'placeholder' => 'Выберите видео ...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <?= $form->field($model, 'is_main')->checkbox() ?>

    <?= $form->field($model, 'show_in_menu')->checkbox() ?>

    <?= $form->field($model, 'show_subpages')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
